<x-admin-layout>
    <x-slot name="title">
        {{ __('Products') }}
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-darkmode2 sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-darkmode2 sm:px-20">
                    <div class="mt-8 text-2xl dark:text-darkmodetext">
                        Create Product
                    </div>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <div class="mt-6 text-gray-500 dark:text-darkmodetext">
                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="name">{{ __('Name') }}</label>

                                <input id="name" class="block w-full mt-1 rounded-lg dark:bg-darkmode" type="text" name="name"
                                    value="{{ old('name') }}" required autofocus />
                            </div>
                            <div class="mt-4">
                                <label for="description">{{ __('Description') }}</label>

                                <textarea id="description" class="block w-full mt-1 rounded-lg dark:bg-darkmode" name="description" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="mt-4">
                                <label for="price">{{ __('Price') }}</label>

                                <input id="price" class="block w-full mt-1 rounded-lg dark:bg-darkmode" type="number" name="price"  min="1" step="any"
                                    value="{{ old('price') }}" required min="0" />
                            </div>
                            <div class="mt-4">
                                <label for="image">{{ __('Image') }}</label>

                                <input id="image" class="block w-full mt-1 rounded-lg dark:bg-darkmode" type="file" name="image"
                                    required />
                            </div>
                            <div class="mt-4">
                                <label for="category">{{ __('Category') }}</label>
                                <select id="category" class="block w-full mt-1 rounded-lg dark:bg-darkmode" name="category_id" required>
                                    @if ($categories->count())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No categories found</option>
                                    @endif
                                </select>
                                <div class="flex items-center justify-end mt-4 text-blue-700">
                                    <a href="{{ route('admin.categories.create') }}">Create Category</a>
                                </div>

                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit"
                                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
