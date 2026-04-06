@extends('admin.principal')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <span>Home</span> <span>/</span> <span class="text-gray-700">Dashboard</span>
@endsection

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pages</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">1,284</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> +12.5% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-primary-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">3,427</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> +8.2% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Posts</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">856</p>
                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        <i data-lucide="trending-down" class="w-3 h-3"></i> -2.4% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center">
                    <i data-lucide="newspaper" class="w-6 h-6 text-sky-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Categories</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">64</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> +3 new this month
                    </p>
                </div>
                <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center">
                    <i data-lucide="folder-tree" class="w-6 h-6 text-violet-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
        {{-- Content Growth (Bar) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-800">Content Growth</h3>
                <select class="text-xs border border-gray-200 rounded-lg px-2 py-1 text-gray-600 outline-none">
                    <option>Last 6 months</option>
                    <option>Last 12 months</option>
                </select>
            </div>
            <canvas id="contentGrowthChart" height="260"></canvas>
        </div>

        {{-- Content Distribution (Doughnut) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Content Distribution</h3>
            <canvas id="contentDistChart" height="260"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        {{-- User Registrations (Line) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">User Registrations</h3>
            <canvas id="userRegChart" height="220"></canvas>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                @php
                    $activities = [
                        [
                            'icon' => 'file-plus',
                            'color' => 'blue',
                            'text' => 'New page "About Us" was created',
                            'time' => '2 minutes ago',
                        ],
                        [
                            'icon' => 'user-plus',
                            'color' => 'green',
                            'text' => 'New user registered: john@example.com',
                            'time' => '15 minutes ago',
                        ],
                        [
                            'icon' => 'edit',
                            'color' => 'amber',
                            'text' => 'Product "Widget Pro" was updated',
                            'time' => '1 hour ago',
                        ],
                        [
                            'icon' => 'trash-2',
                            'color' => 'red',
                            'text' => 'Category "Old Items" was deleted',
                            'time' => '3 hours ago',
                        ],
                        [
                            'icon' => 'user-check',
                            'color' => 'indigo',
                            'text' => 'User "admin" logged in',
                            'time' => '5 hours ago',
                        ],
                    ];
                @endphp
                @foreach ($activities as $activity)
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-{{ $activity['color'] }}-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4 text-{{ $activity['color'] }}-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700">{{ $activity['text'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        // Content Growth Bar Chart
        new Chart(document.getElementById('contentGrowthChart'), {
            type: 'bar',
            data: {
                labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                        label: 'Pages',
                        data: [65, 78, 90, 81, 96, 110],
                        backgroundColor: '#3b82f6',
                        borderRadius: 6
                    },
                    {
                        label: 'Posts',
                        data: [45, 52, 48, 61, 55, 72],
                        backgroundColor: '#93c5fd',
                        borderRadius: 6
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Content Distribution Doughnut
        new Chart(document.getElementById('contentDistChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pages', 'Posts', 'Products', 'Media'],
                datasets: [{
                    data: [40, 25, 20, 15],
                    backgroundColor: ['#1e40af', '#3b82f6', '#60a5fa', '#93c5fd'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 16
                        }
                    }
                }
            }
        });

        // User Registrations Line Chart
        new Chart(document.getElementById('userRegChart'), {
            type: 'line',
            data: {
                labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                    label: 'New Users',
                    data: [120, 190, 170, 220, 250, 310],
                    borderColor: '#1e40af',
                    backgroundColor: 'rgba(30,64,175,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1e40af'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endpush
