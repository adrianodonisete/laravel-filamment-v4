import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { BookOpenIcon, PlusIcon, MagnifyingGlassIcon, ChartBarIcon } from '@heroicons/react/24/outline';

export default function Welcome({ auth }) {
	const features = [
		{
			name: 'Book Management',
			description: 'Add, edit, and organize your book collection with ease.',
			icon: BookOpenIcon,
		},
		{
			name: 'Search & Filter',
			description: 'Find books quickly with advanced search and filtering options.',
			icon: MagnifyingGlassIcon,
		},
		{
			name: 'Analytics',
			description: 'Track your reading progress and collection statistics.',
			icon: ChartBarIcon,
		},
	];

	return (
		<AppLayout auth={auth}>
			<Head title="Welcome" />

			<div className="py-12">
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div className="text-center">
						<h1 className="text-4xl font-bold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
							Welcome to Book Manager
						</h1>
						<p className="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
							Organize, search, and manage your book collection with our modern, intuitive interface.
						</p>
						<div className="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
							<div className="rounded-md shadow">
								<Link
									href="/books"
									className="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
									View Books
								</Link>
							</div>
							<div className="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
								<Link
									href="/books/create"
									className="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-indigo-400 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10">
									Add New Book
								</Link>
							</div>
						</div>
					</div>
				</div>

				<div className="mt-20">
					<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<div className="lg:text-center">
							<h2 className="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">
								Features
							</h2>
							<p className="mt-2 text-3xl leading-8 font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
								Everything you need to manage your books
							</p>
							<p className="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 lg:mx-auto">
								Our platform provides all the tools you need to organize and track your book collection.
							</p>
						</div>

						<div className="mt-20">
							<dl className="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
								{features.map(feature => (
									<div key={feature.name} className="relative">
										<dt>
											<div className="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
												<feature.icon className="h-6 w-6" />
											</div>
											<p className="ml-16 text-lg leading-6 font-medium text-gray-900 dark:text-white">
												{feature.name}
											</p>
										</dt>
										<dd className="mt-2 ml-16 text-base text-gray-500 dark:text-gray-400">{feature.description}</dd>
									</div>
								))}
							</dl>
						</div>
					</div>
				</div>
			</div>
		</AppLayout>
	);
}
