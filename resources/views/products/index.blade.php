<x-app-layout>
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Products</h1>

            <a href="{{ route('products.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                + Add Product
            </a>
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
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-t border-gray-800">
                            <td class="px-4 py-3">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-center">{{ $product->stock }}</td>
                            <td class="px-4 py-3 text-center">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('products.edit', $product) }}"
                                class="text-indigo-400 hover:underline">
                                    Edit
                                </a>

                                @if(auth()->user()->role !== 'operator')
                                    <form action="{{ route('products.destroy', $product) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 hover:underline"
                                                onclick="return confirm('Hapus product ini?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
