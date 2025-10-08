import { useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function BookForm({ book, onSubmit, submitText = 'Save' }) {
	const { data, setData, errors, processing } = useForm({
		name: book?.name || '',
		author: book?.author || '',
		pages: book?.pages || '',
		price: book?.price || '',
		description: book?.description || '',
		status: book?.status || 'Active',
	});

	const handleSubmit = e => {
		e.preventDefault();
		onSubmit(data);
	};

	return (
		<form onSubmit={handleSubmit} className="space-y-6">
			<div className="grid grid-cols-1 gap-6 sm:grid-cols-2">
				<div>
					<label htmlFor="name" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
						Book Name *
					</label>
					<div className="mt-1">
						<input
							type="text"
							name="name"
							id="name"
							value={data.name}
							onChange={e => setData('name', e.target.value)}
							className="block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
							placeholder="Enter book name"
						/>
						{errors.name && <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.name}</p>}
					</div>
				</div>

				<div>
					<label htmlFor="author" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
						Author *
					</label>
					<div className="mt-1">
						<input
							type="text"
							name="author"
							id="author"
							value={data.author}
							onChange={e => setData('author', e.target.value)}
							className="block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
							placeholder="Enter author name"
						/>
						{errors.author && <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.author}</p>}
					</div>
				</div>

				<div>
					<label htmlFor="pages" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
						Number of Pages *
					</label>
					<div className="mt-1">
						<input
							type="number"
							name="pages"
							id="pages"
							value={data.pages}
							onChange={e => setData('pages', parseInt(e.target.value))}
							className="block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
							placeholder="Enter number of pages"
							min="1"
						/>
						{errors.pages && <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.pages}</p>}
					</div>
				</div>

				<div>
					<label htmlFor="price" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
						Price *
					</label>
					<div className="mt-1 relative rounded-md shadow-sm">
						<div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
							<span className="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
						</div>
						<input
							type="number"
							name="price"
							id="price"
							value={data.price}
							onChange={e => setData('price', parseFloat(e.target.value))}
							className="block w-full pl-7 pr-12 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
							placeholder="0.00"
							step="0.01"
							min="0"
						/>
						{errors.price && <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.price}</p>}
					</div>
				</div>
			</div>

			<div>
				<label htmlFor="status" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
					Status *
				</label>
				<div className="mt-1">
					<select
						name="status"
						id="status"
						value={data.status}
						onChange={e => setData('status', e.target.value)}
						className="block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
						<option value="Active">Active</option>
						<option value="Out of Stock">Out of Stock</option>
						<option value="Inactive">Inactive</option>
					</select>
					{errors.status && <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.status}</p>}
				</div>
			</div>

			<div>
				<label htmlFor="description" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
					Description *
				</label>
				<div className="mt-1">
					<textarea
						name="description"
						id="description"
						rows={4}
						value={data.description}
						onChange={e => setData('description', e.target.value)}
						className="block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
						placeholder="Enter book description"
					/>
					{errors.description && <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.description}</p>}
				</div>
			</div>

			<div className="flex justify-end space-x-3">
				<button
					type="button"
					onClick={() => window.history.back()}
					className="inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
					Cancel
				</button>
				<button
					type="submit"
					disabled={processing}
					className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
					{processing ? 'Saving...' : submitText}
				</button>
			</div>
		</form>
	);
}
