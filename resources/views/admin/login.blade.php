<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        },
                    }
                }
            }
        }
    </script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700 flex items-center justify-center p-4">
    {{-- Background decoration --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-primary-400/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-white/10 backdrop-blur rounded-2xl mb-4">
                <i data-lucide="layout-dashboard" class="w-7 h-7 text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Admin<span class="text-primary-300">Panel</span></h1>
            <p class="text-primary-200 text-sm mt-1">Sign in to your account</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            {{-- Error messages --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.auth') }}" class="space-y-5">
                @csrf
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            autofocus
                            class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                            placeholder="admin@example.com">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-primary-600 hover:text-primary-800 font-medium">Forgot password?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                            placeholder="••••••••">
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2.5 px-4 rounded-lg transition shadow-lg shadow-primary-700/25 text-sm">
                    Sign in
                </button>
            </form>
        </div>

        <p class="text-center text-primary-300 text-xs mt-6">&copy; {{ date('Y') }} {{ config('app.name') }}. All
            rights reserved.</p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
