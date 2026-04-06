<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: {
                            DEFAULT: '#1e293b',
                            hover: '#334155',
                            active: '#1e40af'
                        },
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
    <style>
        .sidebar {
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 72px;
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }

        .sidebar.collapsed .sidebar-logo-text {
            display: none;
        }

        .sidebar.collapsed .sidebar-submenu {
            display: none;
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="sidebar fixed top-0 left-0 h-full w-64 bg-sidebar text-white z-30 flex flex-col shadow-xl">
            {{-- Logo --}}
            <div class="flex items-center justify-between px-4 h-16 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="sidebar-text font-bold text-lg tracking-tight">Admin<span
                            class="text-primary-400">Panel</span></span>
                </a>
                <button onclick="toggleSidebar()" class="p-1 rounded hover:bg-white/10 transition lg:hidden">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium
                   {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 text-white' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                <div class="pt-4 pb-2">
                    <span
                        class="sidebar-text text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Content</span>
                </div>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium
                   {{ request()->routeIs('admin.products.*') ? 'bg-primary-800 text-white' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }}">
                    <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="sidebar-text">Products</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium
                   {{ request()->routeIs('admin.categories.*') ? 'bg-primary-800 text-white' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }}">
                    <i data-lucide="folder-tree" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="sidebar-text">Categories</span>
                </a>

                <div class="pt-4 pb-2">
                    <span
                        class="sidebar-text text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">People</span>
                </div>

                <a href="{{ route('admin.customers.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium
                   {{ request()->routeIs('admin.customers.*') ? 'bg-primary-800 text-white' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="sidebar-text">Customers</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium
                   {{ request()->routeIs('admin.users.*') ? 'bg-primary-800 text-white' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }}">
                    <i data-lucide="user-cog" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="sidebar-text">Users</span>
                </a>

                <div class="pt-4 pb-2">
                    <span
                        class="sidebar-text text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">System</span>
                </div>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                    <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="border-t border-white/10 p-3">
                <div class="flex items-center gap-3 px-3 py-2">
                    <div
                        class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="sidebar-text overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@example.com' }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Overlay for mobile --}}
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden">
        </div>

        {{-- Main Content --}}
        <div id="main-content" class="main-content flex-1 ml-0 lg:ml-64 flex flex-col min-h-screen">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="flex items-center justify-between px-4 sm:px-6 h-16">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                            <i data-lucide="panel-left" class="w-5 h-5 text-gray-600"></i>
                        </button>
                        <div>
                            <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                            @hasSection('breadcrumb')
                                <div class="text-xs text-gray-500 flex items-center gap-1">
                                    @yield('breadcrumb')
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Search --}}
                        <div class="hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 gap-2">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                            <input type="text" placeholder="Search..."
                                class="bg-transparent text-sm text-gray-600 outline-none w-48">
                        </div>
                        {{-- Notifications --}}
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 transition">
                            <i data-lucide="bell" class="w-5 h-5 text-gray-600"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        {{-- User dropdown --}}
                        <div class="dropdown relative">
                            <button class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 transition">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-sm font-semibold">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                            </button>
                            <div
                                class="dropdown-menu absolute right-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                <a href="#"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="user" class="w-4 h-4"></i> Profile
                                </a>
                                <a href="#"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="settings" class="w-4 h-4"></i> Settings
                                </a>
                                <hr class="my-1 border-gray-200">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    class="mx-4 sm:mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mx-4 sm:mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="border-t border-gray-200 bg-white px-4 sm:px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                    <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} — PHP v{{ PHP_VERSION }}</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar toggle
        let sidebarCollapsed = false;
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            const isLg = window.innerWidth >= 1024;
            if (isLg) {
                sidebarCollapsed = !sidebarCollapsed;
                sidebar.classList.toggle('collapsed', sidebarCollapsed);
                mainContent.style.marginLeft = sidebarCollapsed ? '72px' : '16rem';
            } else {
                const isOpen = sidebar.classList.contains('translate-x-0');
                sidebar.classList.toggle('-translate-x-full', isOpen);
                sidebar.classList.toggle('translate-x-0', !isOpen);
                overlay.classList.toggle('hidden', isOpen);
            }
        }

        // Mobile: start hidden
        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    </script>
    @stack('scripts')
</body>

</html>
