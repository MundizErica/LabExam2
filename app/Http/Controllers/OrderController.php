<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.rice', 'payment'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $riceItems = Rice::where('stock_quantity', '>', 0)->get();
        return view('orders.create', compact('riceItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'     => 'required|string|max:100',
            'notes'             => 'nullable|string|max:500',
            'items'             => 'required|array|min:1',
            'items.*.rice_id'   => 'required|exists:rices,id',
            'items.*.quantity'  => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $itemsData   = [];

            foreach ($request->items as $item) {
                $rice     = Rice::findOrFail($item['rice_id']);
                $qty      = (float) $item['quantity'];
                $subtotal = $qty * $rice->price_per_kg;

                if ($rice->stock_quantity < $qty) {
                    throw new \Exception("Insufficient stock for {$rice->name}.");
                }

                $itemsData[]  = [
                    'rice_id'      => $rice->id,
                    'quantity_kg'  => $qty,
                    'price_per_kg' => $rice->price_per_kg,
                    'subtotal'     => $subtotal,
                ];
                $totalAmount += $subtotal;

                // Deduct stock
                $rice->decrement('stock_quantity', $qty);
            }

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'total_amount'  => $totalAmount,
                'status'        => 'pending',
                'notes'         => $request->notes,
            ]);

            foreach ($itemsData as $data) {
                $order->items()->create($data);
            }

            // Auto-create unpaid payment record
            Payment::create([
                'order_id'       => $order->id,
                'amount_paid'    => $totalAmount,
                'payment_method' => 'cash',
                'status'         => 'unpaid',
                'paid_at'        => null,
            ]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['items.rice', 'payment']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('items.rice');
        $riceItems = Rice::all();
        return view('orders.edit', compact('order', 'riceItems'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'status'        => 'required|in:pending,completed,cancelled',
            'notes'         => 'nullable|string|max:500',
        ]);

        $order->update($request->only('customer_name', 'status', 'notes'));

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order deleted.');
    }
}
