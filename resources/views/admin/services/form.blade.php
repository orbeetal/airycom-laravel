<div class="grid gap-4 lg:grid-cols-12">
    <!-- Name -->
    <div class="col-span-full">
        <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
        <input value="{{ old('name') ?? $service->name }}" type="text" id="name" name="name" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
        @error('name')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Slug -->
    <div class="col-span-full">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input value="{{ old('slug') ?? $service->slug }}" type="text" id="slug" name="slug" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
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
            <option value="{{ $category->id }}" @selected((old('category') ?? ($service->category_id ?? '')) == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Price -->
    <div class="col-span-6">
        <label for="price" class="block text-sm font-medium text-gray-700">Price (optional)</label>
        <input value="{{ old('price') ?? $service->price }}" type="number" id="price" name="price" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
        @error('price')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Description -->
    <div class="col-span-full">
        <label for="country" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" class="w-full min-h-40 rounded-lg">{{ $service->description }}</textarea>
        @error('description')
        <div class="text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <hr class="col-span-full" />

    <!-- Service Photos -->
    <div class="col-span-full grid grid-cols-4 gap-4">
        <label for="imgInput1" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview1" src="{{ $service->photos[0] ?? '' }}" alt="Photo 1" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput1" onchange="previewImage(event, 'preview1')" class="hidden" type="file" accept="image/*" />
            {{-- <button type="button" onclick="removeImage(0)">Remove</button> --}}
        </label>
        <label for="imgInput2" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview2" src="{{ $service->photos[1] ?? '' }}" alt="Photo 2" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput2" onchange="previewImage(event, 'preview2')" class="hidden" type="file" accept="image/*" />
            {{-- <button type="button" onclick="removeImage(1)">Remove</button> --}}
        </label>
        <label for="imgInput3" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview3" src="{{ $service->photos[2] ?? '' }}" alt="Photo 3" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput3" onchange="previewImage(event, 'preview3')" class="hidden" type="file" accept="image/*" />
            {{-- <button type="button" onclick="removeImage(2)">Remove</button> --}}
        </label>
        <label for="imgInput4" class="border rounded w-full aspect-square cursor-pointer">
            <img id="preview4" src="{{ $service->photos[3] ?? '' }}" alt="Photo 4" class="w-full aspect-square object-contain" />
            <input name="photos[]" id="imgInput4" onchange="previewImage(event, 'preview4')" class="hidden" type="file" accept="image/*" />
            {{-- <button type="button" onclick="removeImage(3)">Remove</button> --}}
        </label>
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

    function removeImage(index) {
        console.log(index)

        const preview = document.getElementById('preview' + (index + 1));
        const imgInput = document.getElementById('imgInput' + (index + 1));

        // Reset the image preview
        preview.src = '';
        preview.classList.remove('border-2', 'border-brand-primary/30');

        // Clear the file input value
        imgInput.value = '-';
    }

</script>
