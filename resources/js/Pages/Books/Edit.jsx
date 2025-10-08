import { Head, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import BookForm from '@/Components/BookForm';

export default function Edit({ book, auth }) {
	const handleSubmit = data => {
		router.put(`/books/${book.id}`, data);
	};

	return (
		<AppLayout auth={auth}>
			<Head title={`Edit ${book.name}`} />

			<div className="max-w-4xl mx-auto">
				<div className="md:flex md:items-center md:justify-between">
					<div className="flex-1 min-w-0">
						<h2 className="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
							Edit Book
						</h2>
						<p className="mt-1 text-sm text-gray-500 dark:text-gray-400">Update the book information.</p>
					</div>
				</div>

				<div className="mt-6">
					<div className="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
						<div className="px-4 py-5 sm:p-6">
							<BookForm book={book} onSubmit={handleSubmit} submitText="Update Book" />
						</div>
					</div>
				</div>
			</div>
		</AppLayout>
	);
}
