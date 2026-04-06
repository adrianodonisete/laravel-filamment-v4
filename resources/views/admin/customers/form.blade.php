@extends('admin.principal')

@section('title', isset($customer) ? 'Edit Customer' : 'New Customer')
@section('page-title', isset($customer) ? 'Edit Customer' : 'New Customer')
@section('breadcrumb')
    <span>Home</span> <span>/</span>
    <a href="{{ route('admin.customers.index') }}" class="hover:text-primary-600">Customers</a>
    <span>/</span> <span class="text-gray-700">{{ isset($customer) ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
    <form method="POST" action="{{ isset($customer) ? route('admin.customers.update', $customer) : route('admin.customers.store') }}">
        @csrf
        @if(isset($customer)) @method('PUT') @endif

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name ?? '') }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $customer->email ?? '') }}" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('email') border-red-400 @enderror">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">{{ old('address', $customer->address ?? '') }}</textarea>
                </div>
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $customer->is_active ?? true) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition shadow-sm">
                    {{ isset($customer) ? 'Update' : 'Create' }} Customer
                </button>
                <a href="{{ route('admin.customers.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Cancel</a>
            </div>
        </div>
    </form>
@endsection
