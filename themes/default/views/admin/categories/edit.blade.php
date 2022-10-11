<x-admin-layout>
    <x-slot name="title">
        {{ __('Categories Edit') }}
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold">{{ __('Categories Edit') }}</h1>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('Name') }}
                            </label>
                            <input id="name" type="text"
                                class="form-input w-full @error('name') border-red-500 @enderror" name="name"
                                value="{{ old('name', $category->name) }}" required autocomplete="name" autofocus>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" type="text" class="form-input w-full @error('description') border-red-500 @enderror"
                                name="description" value="{{ old('description', $category->description) }}" required autocomplete="description"
                                autofocus>{{ $category->description }}</textarea>
                        </div>
                        <!-- slug -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('Slug') }}
                            </label>
                            <p>
                                <span class="text-gray-500" id="slugd"></span>
                            </p>
                            <input id="slug" type="text"
                                class="form-input w-full @error('slug') border-red-500 @enderror" name="slug"
                                value="{{ old('slug', $category->slug) }}" required autocomplete="slug" autofocus>
                        </div>
                        <script>
                            var slug = document.getElementById('slug');
                            slug.addEventListener('keyup', function() {
                                document.getElementById('slugd').textContent = '/category/' + slug.value;
                            });
                            document.getElementById('name').addEventListener('keyup', function() {

                                document.getElementById('slugd').textContent = '/category/' + document.getElementById('name').value;
                                document.getElementById('slug').value = document.getElementById('name').value;

                            });
                        </script>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
