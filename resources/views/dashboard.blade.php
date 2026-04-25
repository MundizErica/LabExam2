<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Welcome back! Here is your current rice inventory and order summary.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('rice.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                    Manage Rice
                </a>
                <a href="{{ route('rice.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Rice Item
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="text-sm font-medium text-gray-500">Rice Items</div>
                        <div class="mt-4 flex items-baseline gap-3">
                            <span class="text-3xl font-semibold text-gray-900">{{ $stats['total_rice'] }}</span>
                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">Active</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="text-sm font-medium text-gray-500">Orders</div>
                        <div class="mt-4 flex items-baseline gap-3">
                            <span class="text-3xl font-semibold text-gray-900">{{ $stats['total_orders'] }}</span>
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-800">Total</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="text-sm font-medium text-gray-500">Paid Orders</div>
                        <div class="mt-4 flex items-baseline gap-3">
                            <span class="text-3xl font-semibold text-gray-900">{{ $stats['paid_orders'] }}</span>
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Paid</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="text-sm font-medium text-gray-500">Revenue</div>
                        <div class="mt-4 flex items-baseline gap-3">
                            <span class="text-3xl font-semibold text-gray-900">₱{{ number_format($stats['total_revenue'], 2) }}</span>
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">Earned</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 overflow-hidden rounded-lg bg-white shadow">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Recent Orders</h3>
                        <p class="mt-1 text-sm text-gray-500">Latest five orders with payment status.</p>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Order #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Customer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Items</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">#{{ $order->id }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $order->customer_name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $order->items->count() }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @if($order->payment?->status === 'paid')
                                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">Paid</span>
                                            @else
                                                <span class="inline-flex rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-800">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">No recent orders available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-base font-semibold text-gray-900">Inventory Alerts</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500">Rice items below 10 kg in stock.</div>
                            <div class="mt-4 flex items-center gap-4">
                                <span class="text-4xl font-semibold text-gray-900">{{ $stats['low_stock'] }}</span>
                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">Low stock</span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-base font-semibold text-gray-900">Payment Breakdown</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Paid orders</span>
                                <span class="font-semibold text-gray-900">{{ $stats['paid_orders'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Unpaid orders</span>
                                <span class="font-semibold text-gray-900">{{ $stats['unpaid_orders'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
