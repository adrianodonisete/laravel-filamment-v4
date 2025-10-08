import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { PencilIcon, TrashIcon, ArrowLeftIcon } from '@heroicons/react/24/outline';

export default function Show({ book, auth }) {
	const deleteBook = () => {
		if (confirm('Are you sure you want to delete this book?')) {
			router.delete(`/books/${book.id}`);
		}
	};

	return (
		<AppLayout auth={auth}>
			<Head title={book.name} />

			<div className="max-w-4xl mx-auto">
				<div className="md:flex md:items-center md:justify-between">
					<div className="flex-1 min-w-0">
						<nav className="flex" aria-label="Breadcrumb">
							<ol className="flex items-center space-x-4">
								<li>
									<Link
										href="/books"
										className="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
										<ArrowLeftIcon className="h-5 w-5" />
										<span className="sr-only">Back to books</span>
									</Link>
								</li>
								<li>
									<div className="flex items-center">
										<span className="text-gray-400 dark:text-gray-500">/</span>
										<Link
											href="/books"
											className="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
											Books
										</Link>
									</div>
								</li>
								<li>
									<div className="flex items-center">
										<span className="text-gray-400 dark:text-gray-500">/</span>
										<span className="ml-4 text-sm font-medium text-gray-900 dark:text-white truncate">{book.name}</span>
									</div>
								</li>
							</ol>
						</nav>
						<h2 className="mt-2 text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
							{book.name}
						</h2>
						<p className="mt-1 text-sm text-gray-500 dark:text-gray-400">by {book.author}</p>
					</div>
					<div className="mt-4 flex md:mt-0 md:ml-4">
						<Link
							href={`/books/${book.id}/edit`}
							className="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							<PencilIcon className="h-4 w-4 mr-2" />
							Edit
						</Link>
						<button
							onClick={deleteBook}
							className="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
							<TrashIcon className="h-4 w-4 mr-2" />
							Delete
						</button>
					</div>
				</div>

				<div className="mt-6">
					<div className="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
						<div className="px-4 py-5 sm:px-6">
							<h3 className="text-lg leading-6 font-medium text-gray-900 dark:text-white">Book Information</h3>
							<p className="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Details about this book.</p>
						</div>
						<div className="border-t border-gray-200 dark:border-gray-700">
							<dl>
								<div className="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
									<dt className="text-sm font-medium text-gray-500 dark:text-gray-400">Book Name</dt>
									<dd className="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{book.name}</dd>
								</div>
								<div className="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
									<dt className="text-sm font-medium text-gray-500 dark:text-gray-400">Author</dt>
									<dd className="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{book.author}</dd>
								</div>
								<div className="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
									<dt className="text-sm font-medium text-gray-500 dark:text-gray-400">Pages</dt>
									<dd className="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
										{book.pages} pages
									</dd>
								</div>
								<div className="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
									<dt className="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
									<dd className="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">${book.price}</dd>
								</div>
								<div className="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
									<dt className="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
									<dd className="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
										<span
											className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
												book.status === 'Active'
													? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
													: book.status === 'Out of Stock'
													? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
													: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
											}`}>
											{book.status}
										</span>
									</dd>
								</div>
								<div className="bg-white dark:bg-gray-800 px-4 py-5 sm:px-6">
									<dt className="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
									<dd className="mt-1 text-sm text-gray-900 dark:text-white">
										<p className="whitespace-pre-wrap">{book.description}</p>
									</dd>
								</div>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</AppLayout>
	);
}
