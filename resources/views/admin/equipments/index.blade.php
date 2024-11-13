<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Equipment List') }}
            </h2>
            <a
                href="{{ route('dashboard.equipments.create') }}"
                class="px-4 py-1 border rounded-lg cursor-pointer border-brand-primary text-brand-primary bg-white hover:text-white hover:bg-brand-primary"
            >
                New Equipment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="w-full table table-auto min-w-max">
                    <thead>
                        <tr class="*:px-3 *:py-2 bg-gray-200">
                            <th class="text-center">SL</th>
                            <th class="text-left">Category</th>
                            <th class="text-left">Equipment Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipments as $equipment)
                        <tr class="*:px-3 *:py-3 hover:bg-gray-100 {{ request('equipment') == $equipment->id ? 'bg-brand-secondary/15' : '' }}">
                            <td class="text-center">
                                {{ $equipments->firstItem() + $loop->index }}
                            </td>
                            <td class="text-left">
                                {{ $equipment->category->name ?? '' }}
                            </td>
                            <td class="text-left">
                                {{ $equipment->name }}
                            </td>
                            <td class="text-center">
                                {{-- <a href="{{ route('dashboard.equipments.show', $equipment->id) }}">Show</a> --}}
                                <a class="px-4 text-sm py-1 rounded-lg bg-sky-500 text-white" href="{{ route('dashboard.equipments.edit', $equipment->id) }}">Edit</a>
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
                {{ $equipments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
