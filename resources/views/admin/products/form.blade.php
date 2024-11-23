<div class="grid gap-4 lg:grid-cols-12">
    <!-- Name -->
    <div class="col-span-full">
        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
        <input value="{{ old('name') ?? $product->name }}" type="text" id="name" name="name" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
        @error('name')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Slug -->
    <div class="col-span-full">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input value="{{ old('slug') ?? $product->slug }}" type="text" id="slug" name="slug" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
        @error('slug')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Category -->
    <div class="col-span-6">
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
        <select id="category_id" name="category_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
            <option value=""> -- Select Category -- </option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected((old('category') ?? ($product->category_id ?? '')) == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Description -->
    <div class="col-span-full">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" class="w-full min-h-40 rounded-lg">{{ $product->description }}</textarea>
        @error('description')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <hr class="col-span-full" />

    <!-- Product Photos -->
    <div class="col-span-full grid grid-cols-4 gap-4">
        <label for="imgInput1" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview1" src="{{ $product->photos[0] ?? '' }}" alt="Photo 1" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput1" onchange="previewImage(event, 'preview1')" class="hidden" type="file" accept="image/*" />
        </label>
    </div>
    @error('photos')
    <div class="text-red-500 mt-1">{{ $message }}</div>
    @enderror

    <!-- Body -->
    <div class="col-span-full">
        <label for="body" class="block text-sm font-medium text-gray-700">Details</label>
        <x-text-editor name="body" :value="$product->body" />
        @error('body')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    function previewImage(event, imgId) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById(imgId);
            output.src = reader.result;
            output.classList.add('border-2', 'border-brand-primary/30');
        }
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
