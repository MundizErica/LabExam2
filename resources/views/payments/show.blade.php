@extends('layouts.app')

@section('title', 'Payment Details')
@section('page-title', 'Payments → Payment Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-semibold">Payment Receipt</h5>
            <span class="badge badge-{{ $payment->status }} rounded-pill ms-1">{{ ucfirst($payment->status) }}</span>
        </div>

        <div class="card">
            <!-- Receipt Header -->
            <div class="card-body text-center border-bottom pb-3">
                <div style="width:56px;height:56px;background:#e8f5e9;border-radius:14px;
                            display:inline-flex;align-items:center;justify-content:center;margin-bottom:.7rem;">
                    <i class="bi bi-receipt text-success" style="font-size:1.6rem;"></i>
                </div>
                <h5 class="fw-bold mb-0">RiceSys</h5>
                <div class="text-muted small">Official Payment Record</div>
            </div>

            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Order Number</div>
                            <div class="fw-bold">#{{ str_pad($payment->order_id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Customer</div>
                            <div class="fw-bold">{{ $payment->order->customer_name }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Payment Method</div>
                            <div class="fw-bold">{{ ucfirst(str_replace('_',' ', $payment->payment_method)) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Date Paid</div>
                            <div class="fw-bold">
                                {{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : 'Not yet paid' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="mb-3">
                    <div class="fw-500 small text-muted mb-2">ORDER ITEMS</div>
                    @foreach($payment->order->items as $item)
                    <div class="d-flex justify-content-between py-2 border-bottom small">
                        <span class="text-muted">{{ $item->rice->name }} × {{ $item->quantity_kg }} kg @ ₱{{ number_format($item->price_per_kg, 2) }}/kg</span>
                        <span class="fw-semibold">₱{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-between pt-3 fw-bold">
                        <span>Total Amount</span>
                        <span class="text-success fs-5">₱{{ number_format($payment->amount_paid, 2) }}</span>
                    </div>
                </div>

                <!-- Action -->
                <div class="d-flex gap-2 mt-4">
                    @if($payment->status === 'unpaid')
                    <form action="{{ route('payments.markPaid', $payment) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-success">
                            <i class="bi bi-check2-circle me-1"></i> Mark as Paid
                        </button>
                    </form>
                    @else
                    <form action="{{ route('payments.markUnpaid', $payment) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-warning">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Mark as Unpaid
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
