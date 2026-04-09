<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $query = Order::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('resi', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('receiver_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        return view('admin.billing.index', compact('orders', 'search'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:Lunas,Tagihan',
            'billing_notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pembayaran berhasil diupdate!');
    }
}
