<x-app-layout>
@php
    $authUser = auth()->user();

    $canManage = fn ($user) =>
        $authUser->role === 'super_admin' ||
        ($authUser->role === 'admin' && $user->role === 'user');
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Users</h1>

            <div class="flex gap-3">
                @if($authUser->role === 'super_admin')
                    <a href="{{ route('users.trash') }}"
                       class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
                        🗑 Sampah
                    </a>
                @endif

                <a href="{{ route('users.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    + Add User
                </a>
            </div>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('users.index') }}" class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama / email / username..."
                class="w-72 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm focus:ring-indigo-500"
            />

            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('users.index') }}"
                   class="px-3 py-2 text-sm text-gray-400 hover:underline">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="bg-green-900/40 border border-green-700 text-green-300 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800 text-gray-400">
                <tr>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-center">Email</th>
                    <th class="px-4 py-3 text-center">Role</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($users as $user)
                @continue($user->role === 'super_admin')

                <tr class="border-t border-gray-800 hover:bg-gray-800/40">

                    {{-- User --}}
                    <td class="px-4 py-3 flex items-center gap-3">
                        <img src="{{ $user->avatarUrl() }}"
                             class="w-8 h-8 rounded-full border border-gray-700">
                        {{ $user->name }}
                    </td>

                    <td class="px-4 py-3 text-center">{{ $user->email }}</td>

                    {{-- Role --}}
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $user->role === 'admin' ? 'bg-blue-700' : 'bg-gray-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-3">

                            <span class="{{ $user->is_active ? 'text-green-400' : 'text-red-400' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            @if($canManage($user))
                                <form method="POST" action="{{ route('users.toggle-active', $user) }}">
                                    @csrf
                                    @method('PATCH')

                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            class="sr-only peer"
                                            {{ $user->is_active ? 'checked' : '' }}
                                            onchange="this.form.submit()"
                                        >

                                        <div class="relative w-10 h-5 bg-gray-600 rounded-full peer-checked:bg-green-600 transition
                                            after:content-['']
                                            after:absolute
                                            after:top-0.5
                                            after:left-0.5
                                            after:w-4
                                            after:h-4
                                            after:bg-white
                                            after:rounded-full
                                            after:transition-all
                                            peer-checked:after:translate-x-5
                                        ">
                                        </div>
                                    </label>
                                </form>
                            @endif

                        </div>
                    </td>

                    {{-- Action --}}
                    <td class="px-4 py-3 text-center space-x-3">
                        @if($canManage($user))
                            <a href="{{ route('users.edit', $user) }}"
                               class="text-indigo-400 hover:underline">Edit</a>

                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                  class="inline"
                                  onsubmit="return confirm('Yakin mau hapus akun ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">
                        Tidak ada data user.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-gray-800">
            {{ $users->links('pagination.dark') }}
        </div>
    </div>
</div>
</x-app-layout>
