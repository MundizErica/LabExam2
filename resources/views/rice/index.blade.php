<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Rice Inventory') }}</h2>
                <p class="mt-1 text-sm text-gray-500">View, add, edit, and delete rice items.</p>
            </div>
            <a href="{{ route('rice.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Add Rice Item</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-6 py-5 border-b border-gray-200 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Rice Products</h3>
                        <p class="mt-1 text-sm text-gray-500">Manage your rice inventory, stock, and pricing.</p>
                    </div>
                    <div class="text-sm text-gray-500">{{ $riceItems->total() }} items</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Rice Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Price / kg</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($riceItems as $rice)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $rice->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rice->name }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-emerald-700">₱{{ number_format($rice->price_per_kg, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        @if($rice->stock_quantity_kg < 10)
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">{{ $rice->stock_quantity_kg }} kg</span>
                                        @else
                                            <span class="text-gray-900">{{ $rice->stock_quantity_kg }} kg</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $rice->description ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('rice.show', $rice) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('rice.edit', $rice) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('rice.destroy', $rice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete {{ $rice->name }}?')" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">No rice items yet. <a href="{{ route('rice.create') }}" class="font-medium text-indigo-600 hover:text-indigo-900">Add one now</a>.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($riceItems->hasPages())
                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                        {{ $riceItems->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
