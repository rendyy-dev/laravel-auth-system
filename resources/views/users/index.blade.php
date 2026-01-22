<x-app-layout>
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Users</h1>

            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                <a href="{{ route('users.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    + Add User
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-900/40 border border-green-700 text-green-300 p-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-800 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-center">Email</th>
                        <th class="px-4 py-3 text-center">Role</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)

                    @if($user->role === 'super_admin')
                        @continue
                    @endif

                    <tr class="border-t border-gray-800">

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatarUrl() }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-700">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs
                                {{ $user->role === 'admin' ? 'bg-blue-700' : 'bg-gray-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">

                                @if($user->role === 'super_admin')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        bg-green-900/40 text-green-400">
                                        Always Active
                                    </span>
                                @else
                                  
                                    <span class="text-xs font-medium
                                        {{ $user->is_active ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>

                                    @php
                                        $authUser = auth()->user();
                                    @endphp

                                    @if ($authUser->role === 'super_admin' || ($authUser->role === 'admin' && $user->role === 'user'))

                                        <form method="POST"
                                          action="{{ route('users.toggle-active', $user) }}">
                                        @csrf
                                        @method('PATCH')

                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   class="sr-only peer"
                                                   onchange="this.form.submit()"
                                                   {{ $user->is_active ? 'checked' : '' }}>

                                            <div class="w-9 h-5 bg-gray-700 rounded-full peer
                                                peer-checked:bg-green-600
                                                after:content-['']
                                                after:absolute after:top-0.5 after:left-[2px]
                                                after:bg-white after:h-4 after:w-4 after:rounded-full
                                                after:transition-all
                                                peer-checked:after:translate-x-full">
                                            </div>
                                        </label>
                                    </form>
                                    @endif                       
                                @endif

                            </div>
                        </td>

                        <td class="px-4 py-3 text-center space-x-3">

                            @if(auth()->user()->role === 'super_admin')

                                <a href="{{ route('users.edit', $user) }}"
                                   class="text-indigo-400 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('users.destroy', $user) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:underline"
                                            onclick="return confirm('Hapus user ini?')">
                                        Delete
                                    </button>
                                </form>

                            @elseif(auth()->user()->role === 'admin')

                                @if($user->role === 'admin')
                                    <span class="text-gray-500 text-xs italic">
                                        View only
                                    </span>
                                @else
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="text-indigo-400 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 hover:underline"
                                                onclick="return confirm('Hapus user ini?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif

                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
