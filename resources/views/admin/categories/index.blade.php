@extends('admin.principal')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('breadcrumb')
    <span>Home</span> <span>/</span> <span class="text-gray-700">Categories</span>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5 border-b border-gray-200">
            <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2 gap-2 w-full sm:w-auto">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                <input type="text" placeholder="Search categories..."
                    class="bg-transparent text-sm text-gray-600 outline-none w-full sm:w-56">
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center gap-2 bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Category
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-5 py-3"><input type="checkbox" class="rounded border-gray-300"></th>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Slug</th>
                        <th class="px-5 py-3">Products</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-3.5"><input type="checkbox" class="rounded border-gray-300"></td>
                            <td class="px-5 py-3.5 font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="px-5 py-3.5 text-gray-500 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $category->products_count ?? 0 }}</td>
                            <td class="px-5 py-3.5">
                                @if ($category->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="p-2 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-primary-600 transition"><i
                                            data-lucide="pencil" class="w-4 h-4"></i></a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button
                                            class="p-2 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition"><i
                                                data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i data-lucide="folder-plus" class="w-10 h-10"></i>
                                    <p class="font-medium">No categories found</p>
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="text-primary-600 hover:underline text-sm">Create your first category</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="px-5 py-4 border-t border-gray-200">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
