@extends('admin.principal')

@section('title', 'Products')
@section('page-title', 'Products')
@section('breadcrumb')
    <span>Home</span> <span>/</span> <span class="text-gray-700">Products</span>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5 border-b border-gray-200">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2 gap-2 flex-1 sm:flex-initial">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    <input type="text" placeholder="Search products..." class="bg-transparent text-sm text-gray-600 outline-none w-full sm:w-56">
                </div>
                <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 text-gray-600 outline-none">
                    <option value="">All Categories</option>
                </select>
            </div>
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center gap-2 bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Product
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-5 py-3"><input type="checkbox" class="rounded border-gray-300"></th>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Stock</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-3.5"><input type="checkbox" class="rounded border-gray-300"></td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="package" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500">SKU: {{ $product->sku ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-5 py-3.5 text-gray-900 font-medium">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $product->stock }}</td>
                            <td class="px-5 py-3.5">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="p-2 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-primary-600 transition" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i data-lucide="package-open" class="w-10 h-10"></i>
                                    <p class="font-medium">No products found</p>
                                    <a href="{{ route('admin.products.create') }}" class="text-primary-600 hover:underline text-sm">Create your first product</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="px-5 py-4 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
