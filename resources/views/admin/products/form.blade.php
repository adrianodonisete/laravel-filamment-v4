@extends('admin.principal')

@section('title', isset($product) ? 'Edit Product' : 'New Product')
@section('page-title', isset($product) ? 'Edit Product' : 'New Product')
@section('breadcrumb')
    <span>Home</span> <span>/</span>
    <a href="{{ route('admin.products.index') }}" class="hover:text-primary-600">Products</a>
    <span>/</span>
    <span class="text-gray-700">{{ isset($product) ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
    <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Product Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('name') border-red-400 @enderror">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('description') border-red-400 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku ?? '') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category_id" id="category_id"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    <option value="">Select a category</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Pricing & Stock --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Pricing & Stock</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (R$) *</label>
                            <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $product->price ?? '') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Status</h3>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="flex-1 bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition shadow-sm">
                        {{ isset($product) ? 'Update' : 'Create' }} Product
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection
