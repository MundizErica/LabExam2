<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $rice->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">Rice product details and management options.</p>
            </div>
            <a href="{{ route('rice.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Back to List</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-6 py-6 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H4zm7 2a1 1 0 011 1v1a1 1 0 11-2 0V6a1 1 0 011-1z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rice Product #{{ $rice->id }}</p>
                            <h3 class="text-2xl font-semibold text-gray-900">{{ $rice->name }}</h3>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Price per Kilogram</p>
                            <p class="mt-2 text-xl font-semibold text-emerald-700">₱{{ number_format($rice->price_per_kg, 2) }}</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Stock Quantity</p>
                            <p class="mt-2 text-xl font-semibold {{ $rice->stock_quantity_kg < 10 ? 'text-yellow-600' : 'text-gray-900' }}">{{ $rice->stock_quantity_kg }} kg</p>
                            @if($rice->stock_quantity_kg < 10)
                                <span class="mt-2 inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Low stock</span>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-2xl bg-gray-50 p-4">
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="mt-2 text-gray-900">{{ $rice->description ?? 'No description provided.' }}</p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Date Added</p>
                            <p class="mt-2 text-gray-900">{{ $rice->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Last Updated</p>
                            <p class="mt-2 text-gray-900">{{ $rice->updated_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('rice.edit', $rice) }}" class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit Item</a>
                        <form action="{{ route('rice.destroy', $rice) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete {{ $rice->name }}? This cannot be undone.')" class="inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
