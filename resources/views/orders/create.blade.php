@extends('layouts.app')

@section('title', 'New Order')
@section('page-title', 'Orders → Create New Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-semibold">Create New Order</h5>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="row g-3">
                <!-- Left: Order details -->
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header"><i class="bi bi-person me-2 text-muted"></i>Customer Information</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-500">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name"
                                       class="form-control @error('customer_name') is-invalid @enderror"
                                       value="{{ old('customer_name') }}" placeholder="Full name">
                                @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="form-label fw-500">Notes / Remarks</label>
                                <textarea name="notes" rows="2" class="form-control"
                                          placeholder="Special instructions...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-list-check me-2 text-muted"></i>Order Items</span>
                            <button type="button" class="btn btn-sm btn-outline-success" id="addItem">
                                <i class="bi bi-plus-lg me-1"></i> Add Item
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="itemsContainer">
                                <!-- Row template injected by JS -->
                            </div>
                            <div class="text-muted small mt-2" id="noItemsMsg">
                                Click "Add Item" to start adding rice products.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="col-lg-4">
                    <div class="card position-sticky" style="top:80px;">
                        <div class="card-header"><i class="bi bi-receipt me-2 text-muted"></i>Order Summary</div>
                        <div class="card-body">
                            <div id="summaryLines" class="mb-3" style="font-size:.88rem;">
                                <div class="text-muted text-center py-3">No items added yet</div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total</span>
                                <span class="fw-bold text-success fs-5" id="grandTotal">₱0.00</span>
                            </div>
                            <button type="submit" class="btn btn-brand w-100 mt-3">
                                <i class="bi bi-check2-circle me-2"></i>Place Order
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const riceData = @json($riceItems->keyBy('id'));
const riceOptions = @json($riceItems);
let itemCount = 0;

function buildOptions(selectedId = '') {
    return riceOptions.map(r =>
        `<option value="${r.id}" data-price="${r.price_per_kg}"
                 ${r.id == selectedId ? 'selected' : ''}>
             ${r.name} — ₱${parseFloat(r.price_per_kg).toFixed(2)}/kg (${r.stock_quantity} kg left)
         </option>`
    ).join('');
}

function addItemRow(riceId = '', qty = '') {
    itemCount++;
    const idx = itemCount - 1;
    document.getElementById('noItemsMsg').style.display = 'none';

    const row = document.createElement('div');
    row.className = 'item-row border rounded p-3 mb-2';
    row.dataset.idx = idx;
    row.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-500 mb-1">Rice Product</label>
                <select name="items[${idx}][rice_id]" class="form-select form-select-sm rice-select" required>
                    <option value="">– Select –</option>
                    ${buildOptions(riceId)}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-500 mb-1">Qty (kg)</label>
                <input type="number" name="items[${idx}][quantity]"
                       class="form-control form-control-sm qty-input"
                       min="0.1" step="0.1" value="${qty}" placeholder="0.0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-500 mb-1">Subtotal</label>
                <div class="form-control form-control-sm bg-light subtotal-display text-success fw-semibold">₱0.00</div>
            </div>
            <div class="col-md-1 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>`;

    document.getElementById('itemsContainer').appendChild(row);
    row.querySelector('.rice-select').addEventListener('change', recalculate);
    row.querySelector('.qty-input').addEventListener('input', recalculate);
    row.querySelector('.remove-item').addEventListener('click', () => {
        row.remove();
        checkEmpty();
        recalculate();
    });
    recalculate();
}

function checkEmpty() {
    const rows = document.querySelectorAll('.item-row');
    document.getElementById('noItemsMsg').style.display = rows.length === 0 ? 'block' : 'none';
}

function recalculate() {
    const rows = document.querySelectorAll('.item-row');
    let grand = 0;
    const lines = [];

    rows.forEach(row => {
        const sel  = row.querySelector('.rice-select');
        const qty  = parseFloat(row.querySelector('.qty-input').value) || 0;
        const opt  = sel.options[sel.selectedIndex];
        const price = opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;
        const sub  = qty * price;
        grand += sub;
        row.querySelector('.subtotal-display').textContent = '₱' + sub.toFixed(2);
        if (opt && opt.value) {
            lines.push(`<div class="d-flex justify-content-between mb-1">
                <span class="text-muted">${opt.text.split('—')[0].trim()} × ${qty} kg</span>
                <span>₱${sub.toFixed(2)}</span>
            </div>`);
        }
    });

    document.getElementById('grandTotal').textContent = '₱' + grand.toFixed(2);
    document.getElementById('summaryLines').innerHTML = lines.length
        ? lines.join('')
        : '<div class="text-muted text-center py-3">No items added yet</div>';
}

document.getElementById('addItem').addEventListener('click', () => addItemRow());
addItemRow(); // start with one row
</script>
@endpush
