<div class="grid gap-4 lg:grid-cols-12">
    <!-- Title -->
    <div class="col-span-full">
        <label for="title" class="block text-sm font-medium text-gray-700">
            (*) Blog Title
        </label>
        <input
            value="{{ old('title') ?? $blog->title }}"
            type="text"
            id="title"
            name="title"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
        />
        @error('title')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Slug -->
    <div class="col-span-full">
        <label for="slug" class="block text-sm font-medium text-gray-700">
            <b>(*) Slug</b> (Must be unique)
        </label>
        <input
            value="{{ old('slug') ?? $blog->slug }}"
            type="text"
            id="slug"
            name="slug"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
        />
        @error('slug')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Keywords -->
    <div class="col-span-full">
        <label for="keywords" class="block text-sm font-medium text-gray-700">
            <b>Keywords</b> : separated by (,) comma. Example: keyword1,
            keyword2
        </label>
        <input
            value="{{ old('keywords') ?? $blog->keywords }}"
            type="text"
            id="keywords"
            name="keywords"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
        />
        @error('keywords')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Description -->
    <div class="col-span-full">
        <label
            for="description"
            class="block text-sm font-medium text-gray-700"
        >
            Description
        </label>
        <textarea
            name="description"
            class="w-full min-h-40 rounded-lg"
            >{{ $blog->description }}</textarea
        >
        @error('description')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Body -->
    <div class="col-span-full">
        <label for="body" class="block text-sm font-medium text-gray-700">
            Details
        </label>
        <x-text-editor name="body" :value="$blog->body" />
        @error('body')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Is Active -->
    <div class="lg:col-span-6">
        <label for="is_active" class="block text-sm font-medium text-gray-700">
            (*) Is Active
        </label>
        <select
            id="is_active"
            name="is_active"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
        >
            <option value="{{ 1 }}" @selected(old('is_active') ?? $blog->is_active)>Yes</option>
            <option value="{{ 0 }}" @selected(!(old('is_active') ?? $blog->is_active))>No</option>
        </select>
        @error('is_active')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Published Date -->
    <div class="lg:col-span-6">
        <label
            for="published_at"
            class="block text-sm font-medium text-gray-700"
        >
            Published Date
        </label>
        <input
            value="{{ old('published_at') ?? $blog->published_at->format('Y-m-d') }}"
            type="date"
            id="published_at"
            name="published_at"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
        />
        @error('published_at')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
