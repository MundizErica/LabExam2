<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Rice Item') }}</h2>
                <p class="mt-1 text-sm text-gray-500">Update rice details and stock information.</p>
            </div>
            <a href="{{ route('rice.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Back to List</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-6 py-6">
                    <form action="{{ route('rice.update', $rice) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rice Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $rice->name) }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror" />
                                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Price per Kilogram (₱) <span class="text-red-500">*</span></label>
                                    <input type="number" name="price_per_kg" step="0.01" min="0" value="{{ old('price_per_kg', $rice->price_per_kg) }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('price_per_kg') border-red-500 @enderror" />
                                    @error('price_per_kg')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Stock Quantity (kg) <span class="text-red-500">*</span></label>
                                    <input type="number" name="stock_quantity_kg" step="0.01" min="0" value="{{ old('stock_quantity_kg', $rice->stock_quantity_kg) }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('stock_quantity_kg') border-red-500 @enderror" />
                                    @error('stock_quantity_kg')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $rice->description) }}</textarea>
                                @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('rice.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Cancel</a>
                            <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Update Rice Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
