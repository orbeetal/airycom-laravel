<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog List') }}
            </h2>
            <a
                href="{{ route('dashboard.blogs.create') }}"
                class="px-4 py-1 border rounded-lg cursor-pointer border-brand-primary text-brand-primary bg-white hover:text-white hover:bg-brand-primary"
            >
                New Blog
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full table table-auto">
                    <thead>
                        <tr class="*:px-3 *:py-2 bg-gray-200">
                            <th class="text-center">SL</th>
                            <th class="text-left">Blog Title</th>
                            <th class="text-center">Is Active</th>
                            <th class="text-center">Published Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                        <tr class="*:px-3 *:py-3 hover:bg-gray-100 {{ request('blog') == $blog->id ? 'bg-brand-primary/15' : '' }}">
                            <td class="text-center">
                                {{ $blogs->firstItem() + $loop->index }}
                            </td>
                            <td class="text-left">
                                {{ $blog->title }}
                            </td>
                            <td class="text-center">
                                <div class="text-center {{ $blog->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $blog->is_active ? 'Yes' : 'No' }}
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $blog->published_at ? $blog->published_at->format('d M Y') : '-'}}
                            </td>
                            <td class="text-center">
                                <!-- <a href="{{ route('dashboard.blogs.show', $blog->id) }}">Show</a> -->
                                <a class="px-4 text-sm py-1 rounded-lg bg-sky-500 text-white" href="{{ route('dashboard.blogs.edit', $blog->id) }}">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr class="*:px-3 *:py-2">
                            <td colspan="100">
                                <div class="text-red-600 text-xl py-8 text-center">No data found!</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
