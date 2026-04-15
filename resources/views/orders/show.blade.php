@extends('layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Orders → Order Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-semibold">
                Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
            </h5>
            <span class="badge badge-{{ $order->status }} rounded-pill ms-1">{{ ucfirst($order->status) }}</span>
        </div>

        <!-- Customer Info -->
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-person me-2 text-muted"></i>Customer Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Customer Name</small>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Order Date</small>
                        <strong>{{ $order->created_at->format('F d, Y h:i A') }}</strong>
                    </div>
                    @if($order->notes)
                    <div class="col-12 mt-3">
                        <small class="text-muted d-block">Notes</small>
                        <span>{{ $order->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-list-check me-2 text-muted"></i>Order Items</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Rice Product</th>
                            <th>Qty (kg)</th>
                            <th>Price / kg</th>
                            <th class="pe-3 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="ps-3 fw-500">{{ $item->rice->name }}</td>
                            <td>{{ $item->quantity_kg }} kg</td>
                            <td>₱{{ number_format($item->price_per_kg, 2) }}</td>
                            <td class="pe-3 text-end fw-semibold text-success">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="border-top:2px solid #f0f0f0;">
                            <td colspan="3" class="ps-3 fw-bold text-end">Grand Total</td>
                            <td class="pe-3 text-end fw-bold text-success fs-6">₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-cash-coin me-2 text-muted"></i>Payment Status</div>
            <div class="card-body">
                @if($order->payment)
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <small class="text-muted d-block">Status</small>
                        <span class="badge rounded-pill badge-{{ $order->payment->status }} fs-6 px-3 py-2">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Method</small>
                        <strong>{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Amount</small>
                        <strong>₱{{ number_format($order->payment->amount_paid, 2) }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Paid At</small>
                        <strong>{{ $order->payment->paid_at ? $order->payment->paid_at->format('M d, Y h:i A') : '–' }}</strong>
                    </div>
                    <div>
                        @if($order->payment->status === 'unpaid')
                        <form action="{{ route('payments.markPaid', $order->payment) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">
                                <i class="bi bi-check2 me-1"></i> Mark as Paid
                            </button>
                        </form>
                        @else
                        <form action="{{ route('payments.markUnpaid', $order->payment) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Mark Unpaid
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @else
                <div class="text-muted small">No payment record found.</div>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit Order
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
