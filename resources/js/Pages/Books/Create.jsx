import { Head, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import BookForm from '@/Components/BookForm';

export default function Create({ auth }) {
	const handleSubmit = data => {
		router.post('/books', data);
	};

	return (
		<AppLayout auth={auth}>
			<Head title="Create Book" />

			<div className="max-w-4xl mx-auto">
				<div className="md:flex md:items-center md:justify-between">
					<div className="flex-1 min-w-0">
						<h2 className="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
							Create New Book
						</h2>
						<p className="mt-1 text-sm text-gray-500 dark:text-gray-400">Add a new book to your collection.</p>
					</div>
				</div>

				<div className="mt-6">
					<div className="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
						<div className="px-4 py-5 sm:p-6">
							<BookForm onSubmit={handleSubmit} submitText="Create Book" />
						</div>
					</div>
				</div>
			</div>
		</AppLayout>
	);
}
