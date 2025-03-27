<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Banner List") }}
            </h2>
            <a
                href="{{ route('dashboard.banners.create') }}"
                class="px-4 py-1 border rounded-lg cursor-pointer border-brand-primary text-brand-primary bg-white hover:text-white hover:bg-brand-primary"
            >
                New Banner
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 overflow-x-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg min-w-max">
                <table class="w-full table table-auto">
                    <thead>
                        <tr class="*:px-3 *:py-2 bg-gray-200">
                            <th class="text-center">SL</th>
                            <th class="text-center">Page</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banners as $banner)
                        <tr
                            class="*:px-3 *:py-3 hover:bg-gray-100 {{ request('banner') == $banner->id ? 'bg-brand-primary/15' : '' }}"
                        >
                            <td class="text-center">
                                {{ $banners->firstItem() + $loop->index }}
                            </td>
                            <td class="text-center">
                                <div class="capitalize">{{ $banner->page }} Page</div>
                            </td>
                            <td class="text-center">
                                <x-image-preview 
                                    :src="route('banners.streamImage', $banner->id)"
                                    width="w-60 md:w-96"
                                    ratio="aspect-[16/5]"
                                />
                            </td>
                            <td class="text-center">
                                <div class="{{ $banner->status ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $banner->status ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            <td class="text-center">
                                {{--
                                <a
                                    href="{{ route('dashboard.banners.show', $banner->id) }}"
                                >
                                    Show
                                </a>
                                --}}
                                <a
                                    class="px-4 text-sm py-1 rounded-lg bg-sky-500 text-white"
                                    href="{{ route('dashboard.banners.edit', $banner->id) }}"
                                    >Edit</a
                                >
                            </td>
                        </tr>
                        @empty
                        <tr class="*:px-3 *:py-2">
                            <td colspan="100">
                                <div
                                    class="text-red-600 text-xl py-8 text-center"
                                >
                                    No data found!
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $banners->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
