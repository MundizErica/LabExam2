<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('order.items.rice');
        return view('payments.show', compact('payment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id'       => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,gcash,bank_transfer',
        ]);

        $payment = Payment::where('order_id', $request->order_id)->firstOrFail();
        $payment->update([
            'payment_method' => $request->payment_method,
            'status'         => 'paid',
            'paid_at'        => Carbon::now(),
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment processed successfully.');
    }

    public function markPaid(Payment $payment)
    {
        $payment->update([
            'status'  => 'paid',
            'paid_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Payment marked as paid.');
    }

    public function markUnpaid(Payment $payment)
    {
        $payment->update([
            'status'  => 'unpaid',
            'paid_at' => null,
        ]);

        return back()->with('success', 'Payment marked as unpaid.');
    }
}
