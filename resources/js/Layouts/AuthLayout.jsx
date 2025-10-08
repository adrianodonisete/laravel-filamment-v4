import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import { SunIcon, MoonIcon } from '@heroicons/react/24/outline';

export default function AuthLayout({ children }) {
	const [darkMode, setDarkMode] = useState(false);

	const toggleDarkMode = () => {
		setDarkMode(!darkMode);
		document.documentElement.classList.toggle('dark');
	};

	return (
		<div className={`min-h-screen flex ${darkMode ? 'dark' : ''}`}>
			<Head title="Authentication" />

			<div className="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
				<div className="mx-auto w-full max-w-sm lg:w-96">
					<div className="flex justify-between items-center mb-8">
						<div>
							<h2 className="text-3xl font-bold text-gray-900 dark:text-white">Book Manager</h2>
							<p className="mt-2 text-sm text-gray-600 dark:text-gray-400">Manage your book collection</p>
						</div>
						<button
							onClick={toggleDarkMode}
							className="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-white">
							{darkMode ? <SunIcon className="h-5 w-5" /> : <MoonIcon className="h-5 w-5" />}
						</button>
					</div>

					{children}

					<div className="mt-6">
						<div className="relative">
							<div className="absolute inset-0 flex items-center">
								<div className="w-full border-t border-gray-300 dark:border-gray-600" />
							</div>
							<div className="relative flex justify-center text-sm">
								<span className="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
									Book Management System
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div className="hidden lg:block relative w-0 flex-1">
				<div className="absolute inset-0 bg-gradient-to-br from-blue-400 to-purple-600 dark:from-blue-600 dark:to-purple-800">
					<div className="absolute inset-0 bg-black opacity-20 dark:opacity-30" />
					<div className="relative h-full flex items-center justify-center">
						<div className="text-center text-white">
							<h1 className="text-4xl font-bold mb-4">Welcome to Book Manager</h1>
							<p className="text-xl opacity-90">Organize, search, and manage your book collection with ease</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}
