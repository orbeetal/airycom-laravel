<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product List') }}
            </h2>
            <a
                href="{{ route('dashboard.products.create') }}"
                class="px-4 py-1 border rounded-lg cursor-pointer border-brand-primary text-brand-primary bg-white hover:text-white hover:bg-brand-primary"
            >
                New Product
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
                            <th class="text-left">Category</th>
                            <th class="text-left">Product Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="*:px-3 *:py-3 hover:bg-gray-100 {{ request('product') == $product->id ? 'bg-brand-secondary/15' : '' }}">
                            <td class="text-center">
                                {{ $products->firstItem() + $loop->index }}
                            </td>
                            <td class="text-left">
                                {{ $product->category->name ?? '' }}
                            </td>
                            <td class="text-left">
                                {{ $product->name }}
                            </td>
                            <td class="text-center">
                                {{-- <a href="{{ route('dashboard.products.show', $product->id) }}">Show</a> --}}
                                <a class="px-4 text-sm py-1 rounded-lg bg-sky-500 text-white" href="{{ route('dashboard.products.edit', $product->id) }}">Edit</a>
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
