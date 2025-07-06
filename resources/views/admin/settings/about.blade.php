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
                {{ __("About Settings Form") }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('message'))
            <div id="session_message" class="text-center mb-6 md:text-xl text-green-600">
                {{ session('message') }}
                <script>
                    setTimeout(()=> {
                        document.getElementById('session_message').remove();
                    }, 3000)
                </script>
            </div>
            @endif

            <form
                method="POST"
                action="{{ url('/dashboard/settings') }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 md:p-8 grid gap-4"
                enctype="multipart/form-data"
            >
                @csrf @method('PUT')

                <div class="grid gap-4 lg:grid-cols-12">
                    <div class="col-span-full">
                        <label
                            for="about_company"
                            class="block text-sm font-medium text-gray-700"
                        >
                            About Company
                        </label>
                        <textarea
                            rows="4"
                            type="text"
                            id="about_company"
                            name="settings[about_company]"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                        >{{ old('about_company') ?? ($settings['about_company'] ?? '') }}</textarea>
                        @error('about_company')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-full">
                        <label
                            for="company_mission"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Company Mission
                        </label>
                        <textarea
                            rows="4"
                            type="text"
                            id="company_mission"
                            name="settings[company_mission]"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                        >{{ old('company_mission') ?? ($settings['company_mission'] ?? '') }}</textarea>
                        @error('company_mission')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-full">
                        <label
                            for="company_vision"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Company Vision
                        </label>
                        <textarea
                            rows="4"
                            type="text"
                            id="company_vision"
                            name="settings[company_vision]"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                        >{{ old('company_vision') ?? ($settings['company_vision'] ?? '') }}</textarea>
                        @error('company_vision')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-full">
                        <label
                            for="company_offerings"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Company Offerings
                        </label>
                        <textarea
                            rows="4"
                            type="text"
                            id="company_offerings"
                            name="settings[company_offerings]"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                        >{{ old('company_offerings') ?? ($settings['company_offerings'] ?? '') }}</textarea>
                        @error('company_offerings')
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
