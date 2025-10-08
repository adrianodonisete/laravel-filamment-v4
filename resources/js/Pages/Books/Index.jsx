import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PlusIcon, MagnifyingGlassIcon, PencilIcon, TrashIcon, EyeIcon, FunnelIcon } from '@heroicons/react/24/outline';

export default function Index({ books, filters, auth }) {
	const [searchTerm, setSearchTerm] = useState(filters.name || '');
	const [showFilters, setShowFilters] = useState(false);

	const handleSearch = e => {
		e.preventDefault();
		router.get('/books', { name: searchTerm }, { preserveState: true });
	};

	const handleFilterChange = (key, value) => {
		router.get('/books', { ...filters, [key]: value }, { preserveState: true });
	};

	const clearFilters = () => {
		router.get('/books', {}, { preserveState: true });
		setSearchTerm('');
	};

	const deleteBook = id => {
		if (confirm('Are you sure you want to delete this book?')) {
			router.delete(`/books/${id}`);
		}
	};

	return (
		<AppLayout auth={auth}>
			<Head title="Books" />

			<div className="sm:flex sm:items-center">
				<div className="sm:flex-auto">
					<h1 className="text-2xl font-semibold text-gray-900 dark:text-white">Books</h1>
					<p className="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all books in your collection.</p>
				</div>
				<div className="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
					<Link
						href="/books/create"
						className="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
						<PlusIcon className="h-4 w-4 mr-2" />
						Add Book
					</Link>
				</div>
			</div>

			{/* Search and Filters */}
			<div className="mt-6">
				<div className="flex flex-col sm:flex-row gap-4">
					<form onSubmit={handleSearch} className="flex-1">
						<div className="relative">
							<div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
								<MagnifyingGlassIcon className="h-5 w-5 text-gray-400" />
							</div>
							<input
								type="text"
								value={searchTerm}
								onChange={e => setSearchTerm(e.target.value)}
								className="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
								placeholder="Search books..."
							/>
						</div>
					</form>

					<button
						onClick={() => setShowFilters(!showFilters)}
						className="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
						<FunnelIcon className="h-4 w-4 mr-2" />
						Filters
					</button>
				</div>

				{/* Advanced Filters */}
				{showFilters && (
					<div className="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
						<div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
							<div>
								<label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
								<input
									type="text"
									value={filters.author || ''}
									onChange={e => handleFilterChange('author', e.target.value)}
									className="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
									placeholder="Filter by author"
								/>
							</div>
							<div>
								<label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Pages</label>
								<input
									type="number"
									value={filters.pages || ''}
									onChange={e => handleFilterChange('pages', e.target.value)}
									className="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
									placeholder="Filter by pages"
								/>
							</div>
							<div>
								<label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
								<input
									type="number"
									step="0.01"
									value={filters.price || ''}
									onChange={e => handleFilterChange('price', e.target.value)}
									className="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
									placeholder="Filter by price"
								/>
							</div>
							<div>
								<label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
								<select
									value={filters.status || ''}
									onChange={e => handleFilterChange('status', e.target.value)}
									className="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
									<option value="">All Status</option>
									<option value="Active">Active</option>
									<option value="Out of Stock">Out of Stock</option>
									<option value="Inactive">Inactive</option>
								</select>
							</div>
						</div>
						<div className="mt-4 flex justify-end">
							<button
								onClick={clearFilters}
								className="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
								Clear filters
							</button>
						</div>
					</div>
				)}
			</div>

			{/* Books List */}
			<div className="mt-8 flex flex-col">
				<div className="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
					<div className="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
						<div className="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
							<table className="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
								<thead className="bg-gray-50 dark:bg-gray-700">
									<tr>
										<th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
											Book
										</th>
										<th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
											Author
										</th>
										<th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
											Pages
										</th>
										<th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
											Price
										</th>
										<th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
											Status
										</th>
										<th className="relative px-6 py-3">
											<span className="sr-only">Actions</span>
										</th>
									</tr>
								</thead>
								<tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
									{books.data.map(book => (
										<tr key={book.id} className="hover:bg-gray-50 dark:hover:bg-gray-700">
											<td className="px-6 py-4 whitespace-nowrap">
												<div className="text-sm font-medium text-gray-900 dark:text-white">{book.name}</div>
												<div className="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
													{book.description}
												</div>
											</td>
											<td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
												{book.author}
											</td>
											<td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
												{book.pages}
											</td>
											<td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
												${book.price}
											</td>
											<td className="px-6 py-4 whitespace-nowrap">
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
											</td>
											<td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
												<div className="flex space-x-2">
													<Link
														href={`/books/${book.id}`}
														className="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
														<EyeIcon className="h-4 w-4" />
													</Link>
													<Link
														href={`/books/${book.id}/edit`}
														className="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
														<PencilIcon className="h-4 w-4" />
													</Link>
													<button
														onClick={() => deleteBook(book.id)}
														className="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
														<TrashIcon className="h-4 w-4" />
													</button>
												</div>
											</td>
										</tr>
									))}
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			{/* Pagination */}
			{books.links && (
				<div className="mt-6 flex items-center justify-between">
					<div className="flex-1 flex justify-between sm:hidden">
						{books.links.prev && (
							<Link
								href={books.links.prev}
								className="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
								Previous
							</Link>
						)}
						{books.links.next && (
							<Link
								href={books.links.next}
								className="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
								Next
							</Link>
						)}
					</div>
					<div className="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
						<div>
							<p className="text-sm text-gray-700 dark:text-gray-300">
								Showing <span className="font-medium">{books.from}</span> to{' '}
								<span className="font-medium">{books.to}</span> of <span className="font-medium">{books.total}</span>{' '}
								results
							</p>
						</div>
						<div>
							<nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
								{books.links.prev && (
									<Link
										href={books.links.prev}
										className="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
										Previous
									</Link>
								)}
								{books.links.next && (
									<Link
										href={books.links.next}
										className="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
										Next
									</Link>
								)}
							</nav>
						</div>
					</div>
				</div>
			)}
		</AppLayout>
	);
}
