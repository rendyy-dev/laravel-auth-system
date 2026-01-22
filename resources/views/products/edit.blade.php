<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Header -->
        <div>
            <h1 class="text-2xl font-semibold">Edit Product</h1>
            <p class="text-sm text-gray-400">Perbarui data barang</p>
        </div>

        <!-- Form -->
        <form action="{{ route('products.update', $product) }}" method="POST"
              class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="text-sm text-gray-400">Product Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $product->name) }}"
                       class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm">
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- SKU -->
            <div>
                <label class="text-sm text-gray-400">SKU</label>
                <input type="text" name="sku"
                       value="{{ old('sku', $product->sku) }}"
                       class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm">
                @error('sku')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock & Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-400">Stock</label>
                    <input type="number" name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm">
                @error('stock')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

                <div>
                    <label class="text-sm text-gray-400">Price</label>
                    <input type="number" name="price"
                           value="{{ old('price', $product->price) }}"
                           class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm">
                    @error('price')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="text-sm text-gray-400">Description</label>
                <textarea name="description" rows="3"
                          class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-800 text-gray-300 hover:bg-gray-700">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Update
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
