<x-app-layout>
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Trash Users</h1>

            <a href="{{ route('users.index') }}"
               class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
                ← Back
            </a>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-800 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-center">Email</th>
                        <th class="px-4 py-3 text-center">Deleted At</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr class="border-t border-gray-800">

                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-center text-xs text-gray-400">
                            {{ $user->deleted_at->diffForHumans() }}
                        </td>

                        <td class="px-4 py-3 text-center space-x-3">

                            <form method="POST"
                                  action="{{ route('users.restore', $user->id) }}"
                                  class="inline">
                                @csrf
                                <button class="text-green-400 hover:underline">
                                    Restore
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('users.force-delete', $user->id) }}"
                                  class="inline"
                                  onsubmit="return confirm('Hapus permanen akun ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-500 hover:underline">
                                    Delete Permanen
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
