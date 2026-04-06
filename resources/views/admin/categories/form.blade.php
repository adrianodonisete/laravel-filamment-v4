@extends('admin.principal')

@section('title', isset($category) ? 'Edit Category' : 'New Category')
@section('page-title', isset($category) ? 'Edit Category' : 'New Category')
@section('breadcrumb')
    <span>Home</span> <span>/</span>
    <a href="{{ route('admin.categories.index') }}" class="hover:text-primary-600">Categories</a>
    <span>/</span> <span class="text-gray-700">{{ isset($category) ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
    <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition font-mono text-xs">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">{{ old('description', $category->description ?? '') }}</textarea>
                </div>
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition shadow-sm">
                    {{ isset($category) ? 'Update' : 'Create' }} Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Cancel</a>
            </div>
        </div>
    </form>
@endsection
