import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import {
	Bars3Icon,
	XMarkIcon,
	SunIcon,
	MoonIcon,
	BookOpenIcon,
	PlusIcon,
	MagnifyingGlassIcon,
} from '@heroicons/react/24/outline';

export default function AppLayout({ children, auth, books }) {
	const [sidebarOpen, setSidebarOpen] = useState(false);
	const [darkMode, setDarkMode] = useState(false);

	const toggleDarkMode = () => {
		setDarkMode(!darkMode);
		document.documentElement.classList.toggle('dark');
	};

	const navigation = [
		{ name: 'Dashboard', href: '/', icon: BookOpenIcon, current: true },
		{ name: 'Books', href: '/books', icon: BookOpenIcon, current: false },
		{ name: 'Add Book', href: '/books/create', icon: PlusIcon, current: false },
	];

	return (
		<div className={`min-h-screen ${darkMode ? 'dark' : ''}`}>
			<Head title="Book Management" />

			{/* Mobile sidebar */}
			<div className={`fixed inset-0 z-50 lg:hidden ${sidebarOpen ? 'block' : 'hidden'}`}>
				<div className="fixed inset-0 bg-gray-600 bg-opacity-75" onClick={() => setSidebarOpen(false)} />
				<div className="fixed inset-y-0 left-0 flex w-64 flex-col bg-white dark:bg-gray-800">
					<div className="flex h-16 items-center justify-between px-4">
						<h1 className="text-xl font-bold text-gray-900 dark:text-white">Book Manager</h1>
						<button
							onClick={() => setSidebarOpen(false)}
							className="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-white">
							<XMarkIcon className="h-6 w-6" />
						</button>
					</div>
					<nav className="flex-1 space-y-1 px-2 py-4">
						{navigation.map(item => (
							<Link
								key={item.name}
								href={item.href}
								className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${
									item.current
										? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white'
										: 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white'
								}`}>
								<item.icon className="mr-3 h-5 w-5" />
								{item.name}
							</Link>
						))}
					</nav>
				</div>
			</div>

			{/* Desktop sidebar */}
			<div className="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
				<div className="flex flex-col flex-grow bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
					<div className="flex h-16 items-center justify-between px-4">
						<h1 className="text-xl font-bold text-gray-900 dark:text-white">Book Manager</h1>
						<button
							onClick={toggleDarkMode}
							className="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-white">
							{darkMode ? <SunIcon className="h-5 w-5" /> : <MoonIcon className="h-5 w-5" />}
						</button>
					</div>
					<nav className="flex-1 space-y-1 px-2 py-4">
						{navigation.map(item => (
							<Link
								key={item.name}
								href={item.href}
								className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${
									item.current
										? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white'
										: 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white'
								}`}>
								<item.icon className="mr-3 h-5 w-5" />
								{item.name}
							</Link>
						))}
					</nav>
				</div>
			</div>

			{/* Main content */}
			<div className="lg:pl-64">
				{/* Top bar */}
				<div className="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
					<button
						type="button"
						className="-m-2.5 p-2.5 text-gray-700 dark:text-gray-300 lg:hidden"
						onClick={() => setSidebarOpen(true)}>
						<Bars3Icon className="h-6 w-6" />
					</button>

					<div className="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
						<div className="relative flex flex-1 items-center">
							<MagnifyingGlassIcon className="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400 dark:text-gray-500" />
							<input
								type="text"
								placeholder="Search books..."
								className="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-0 sm:text-sm bg-transparent"
							/>
						</div>
						<div className="flex items-center gap-x-4 lg:gap-x-6">
							<button
								onClick={toggleDarkMode}
								className="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-white">
								{darkMode ? <SunIcon className="h-5 w-5" /> : <MoonIcon className="h-5 w-5" />}
							</button>
							{auth?.user && <div className="text-sm text-gray-700 dark:text-gray-300">Welcome, {auth.user.name}</div>}
						</div>
					</div>
				</div>

				{/* Page content */}
				<main className="py-6">
					<div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">{children}</div>
				</main>
			</div>
		</div>
	);
}
