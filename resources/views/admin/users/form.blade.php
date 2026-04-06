@extends('admin.principal')

@section('title', isset($user) ? 'Edit User' : 'New User')
@section('page-title', isset($user) ? 'Edit User' : 'New User')
@section('breadcrumb')
    <span>Home</span> <span>/</span>
    <a href="{{ route('admin.users.index') }}" class="hover:text-primary-600">Users</a>
    <span>/</span> <span class="text-gray-700">{{ isset($user) ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password {{ isset($user) ? '(leave blank to keep)' : '*' }}
                        </label>
                        <input type="password" name="password" id="password" {{ isset($user) ? '' : 'required' }}
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    </div>
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="role"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User
                        </option>
                        <option value="editor" {{ old('role', $user->role ?? '') === 'editor' ? 'selected' : '' }}>Editor
                        </option>
                        <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin
                        </option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                            class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit"
                    class="bg-primary-700 hover:bg-primary-800 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition shadow-sm">
                    {{ isset($user) ? 'Update' : 'Create' }} User
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Cancel</a>
            </div>
        </div>
    </form>
@endsection
