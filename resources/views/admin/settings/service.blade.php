<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between gap-2 items-center">
            <a
                href="{{ url('/dashboard/settings') }}"
                class="cursor-pointer text-gray-600 hover:text-gray-900"
            >
                &larr; Back to Settings
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Service Section Settings Form") }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('message'))
            <div
                id="session_message"
                class="text-center mb-6 md:text-xl text-green-600"
            >
                {{ session("message") }}
                <script>
                    setTimeout(() => {
                        document.getElementById("session_message").remove();
                    }, 3000);
                </script>
            </div>
            @endif

            <form
                method="POST"
                action="{{ url('/dashboard/settings') }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 grid gap-4"
                enctype="multipart/form-data"
            >
                @csrf @method('PUT')

                <div class="grid gap-4 lg:grid-cols-12 p-4 border border-brand-secondary rounded">
                    <div
                        class="col-span-full text-center text-2xl text-brand-primary font-semibold border bg-gray-100 rounded-lg py-2"
                    >
                        Clreanroom Section
                    </div>
                    <!-- Image -->
                    <div class="lg:col-span-6">
                        <div class="text-red-600 text-center">
                            Width: <b>320px</b>, Height: <b>384px</b>
                        </div>
                        <div class="flex items-center">
                            <label
                                for="service_cleanroom_thumbnail"
                                class="border w-full aspect-[5/6] cursor-pointer overflow-hidden bg-red-300"
                            >
                                <img
                                    id="imagePreviewCleanroom"
                                    src="{{ $settings['service_cleanroom_thumbnail'] ?? '' }}"
                                    alt="Clreanroom Thumbnail"
                                    class="w-full aspect-[5/6] object-cover"
                                />
                                <input
                                    name="settings[service_cleanroom_thumbnail]"
                                    id="service_cleanroom_thumbnail"
                                    onchange="previewImage(event, 'imagePreviewCleanroom')"
                                    class="hidden"
                                    type="file"
                                    accept="image/*"
                                />
                            </label>
                        </div>
                        @error('image')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="lg:col-span-6">
                        <label
                            for="service_cleanroom_description"
                            class="block text-xl font-medium text-gray-400"
                        >
                            Description:
                        </label>
                        <textarea
                            rows="12"
                            type="text"
                            id="service_cleanroom_description"
                            name="settings[service_cleanroom_description]"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                            >{{
                                old("settings.service_cleanroom_description") ??
                                    ($settings[
                                        "service_cleanroom_description"
                                    ] ??
                                        "")
                            }}</textarea
                        >
                        @error('settings.service_cleanroom_description')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-12 p-4 border border-brand-secondary rounded">
                    <div
                        class="col-span-full text-center text-2xl text-brand-primary font-semibold border bg-gray-100 rounded-lg py-2"
                    >
                        HVAC Section
                    </div>
                    <!-- Image -->
                    <div class="lg:col-span-6">
                        <div class="text-red-600 text-center">
                            Width: <b>320px</b>, Height: <b>384px</b>
                        </div>
                        <div class="flex items-center">
                            <label
                                for="service_hvac_thumbnail"
                                class="border w-full aspect-[5/6] cursor-pointer overflow-hidden bg-red-300"
                            >
                                <img
                                    id="imagePreviewHVAC"
                                    src="{{ $settings['service_hvac_thumbnail'] ?? '' }}"
                                    alt="HVAC Thumbnail"
                                    class="w-full aspect-[5/6] object-cover"
                                />
                                <input
                                    name="settings[service_hvac_thumbnail]"
                                    id="service_hvac_thumbnail"
                                    onchange="previewImage(event, 'imagePreviewHVAC')"
                                    class="hidden"
                                    type="file"
                                    accept="image/*"
                                />
                            </label>
                        </div>
                        @error('image')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="lg:col-span-6">
                        <label
                            for="service_hvac_description"
                            class="block text-xl font-medium text-gray-400"
                        >
                            Description:
                        </label>
                        <textarea
                            rows="12"
                            type="text"
                            id="service_hvac_description"
                            name="settings[service_hvac_description]"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                            >{{
                                old("settings.service_hvac_description") ??
                                    ($settings[
                                        "service_hvac_description"
                                    ] ??
                                        "")
                            }}</textarea
                        >
                        @error('settings.service_hvac_description')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr />

                <div class="flex justify-between gap-2 items-center">
                    <a
                        href="{{ url('/dashboard/settings') }}"
                        class="cursor-pointer text-gray-600 hover:text-gray-900"
                    >
                        &larr; Back without save
                    </a>
                    <button
                        type="submit"
                        class="px-4 py-1 border rounded-md cursor-pointer border-green-600 text-green-600 bg-white hover:text-white hover:bg-green-600"
                    >
                        Submit & Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
