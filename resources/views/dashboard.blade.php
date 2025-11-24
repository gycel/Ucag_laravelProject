<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    @if(session('success'))
        <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif
        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Archived Books</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $books->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-red-600/50 p-3 dark:bg-red-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700 dark:text-red-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-heart-icon lucide-book-heart">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="M8.62 9.8A2.25 2.25 0 1 1 12 6.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Existing Categories</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $categories->count() }}</h3>
                    </div> 
                    <div class="rounded-full bg-blue-200 p-3 dark:bg-blue-800/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-blue-600 dark:to-blue-300">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                    </div>
                </div> 
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Archive Rate</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">94%</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Management Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <!-- Add / Edit Book Form -->
                @php
                    $isEditingBook = isset($editingBook);
                @endphp
                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                        {{ $isEditingBook ? 'Update Book' : 'Add New Book' }}
                    </h2>
                    <form action="{{ $isEditingBook ? route('books.update', $editingBook) : route('books.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        @if($isEditingBook)
                            @method('PUT')
                        @endif
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title', $isEditingBook ? $editingBook->title : '') }}" placeholder="Enter book title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('title') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                            <input type="text" name="author" value="{{ old('author', $isEditingBook ? $editingBook->author : '') }}" placeholder="Enter book author" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('author') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                            <select name="category_id" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="" {{ old('category_id', $isEditingBook ? $editingBook->category_id : null) == null ? 'selected' : '' }} disabled>Choose book category</option>
                               @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id', $isEditingBook ? $editingBook->category_id : '') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                            <textarea name="description" placeholder="Enter book description" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description', $isEditingBook ? $editingBook->description : '') }}</textarea>
                            @error('description') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Book Cover</label>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @if($isEditingBook && $editingBook->image)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Current cover: <span class="font-medium">{{ basename($editingBook->image) }}</span></p>
                            @endif
                            @error('image') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                                <button type="submit" class="w-full rounded-lg bg-red-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-500/50 dark:hover:bg-red-300 dark:hover:text-gray-800 md:w-auto">
                                    {{ $isEditingBook ? 'Save Changes' : 'Archive Book' }}
                                </button>
                                @if($isEditingBook)
                                    <a href="{{ route('dashboard') }}" class="w-full rounded-lg border border-neutral-300 px-4 py-2 text-center text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-200 dark:hover:bg-neutral-800 md:w-auto">
                                        Cancel
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Archived Book List -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Book List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Cover</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Author</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Category</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($books as $book)
                                <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400"><img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-16 h-16 rounded-full"></td>
                                    <td class="px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100">{{ $book->title }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->author }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->category->name }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->description }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('books.edit', $book) }}" class="text-violet-800 transition-colors hover:text-violet-700 dark:text-violet-400 dark:hover:text-violet-300">Edit</a>
                                        <span class="mx-1 text-neutral-400">|</span>
                                        <form method="POST" action="{{ route('books.destroy', $book->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                        No books found. Archive now!

                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>