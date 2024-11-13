<div class="grid gap-4 lg:grid-cols-12">
    <!-- Name -->
    <div class="col-span-full">
        <label for="name" class="block text-sm font-medium text-gray-700">Equipment Name</label>
        <input value="{{ old('name') ?? $equipment->name }}" type="text" id="name" name="name" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
        @error('name')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Slug -->
    <div class="col-span-full">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input value="{{ old('slug') ?? $equipment->slug }}" type="text" id="slug" name="slug" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
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
            <option value="{{ $category->id }}" @selected((old('category') ?? ($equipment->category_id ?? '')) == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Price -->
    {{-- <div class="col-span-6">
        <label for="price" class="block text-sm font-medium text-gray-700">Price (optional)</label>
        <input value="{{ old('price') ?? $equipment->price }}" type="number" id="price" name="price" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        @error('price')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div> --}}

    <!-- Description -->
    <div class="col-span-full">
        <label for="country" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" class="w-full min-h-40 rounded-lg">{{ $equipment->description }}</textarea>
        @error('description')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <hr class="col-span-full" />

    <!-- Equipment Photos -->
    <div class="col-span-full grid grid-cols-4 gap-4">
        <label for="imgInput1" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview1" src="{{ $equipment->photos[0] ?? '' }}" alt="Photo 1" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput1" onchange="previewImage(event, 'preview1')" class="hidden" type="file" accept="image/*" />
        </label>
        {{-- <label for="imgInput2" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview2" src="{{ $equipment->photos[1] ?? '' }}" alt="Photo 2" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput2" onchange="previewImage(event, 'preview2')" class="hidden" type="file" accept="image/*" />
        </label>
        <label for="imgInput3" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview3" src="{{ $equipment->photos[2] ?? '' }}" alt="Photo 3" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput3" onchange="previewImage(event, 'preview3')" class="hidden" type="file" accept="image/*" />
        </label>
        <label for="imgInput4" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview4" src="{{ $equipment->photos[3] ?? '' }}" alt="Photo 4" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput4" onchange="previewImage(event, 'preview4')" class="hidden" type="file" accept="image/*" />
        </label> --}}
    </div>
    @error('photos')
    <div class="text-red-500 mt-1">{{ $message }}</div>
    @enderror
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
