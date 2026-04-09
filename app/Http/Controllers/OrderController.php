<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Province;
use App\Models\TrackingLog;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        return view('admin.orders.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:20',
            'sender_address' => 'required|string',
            'sender_province' => 'required|string',
            'sender_city' => 'required|string',
            'sender_district' => 'required|string',
            'sender_village' => 'required|string',
            'sender_postal_code' => 'required|string|max:10',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string',
            'receiver_province' => 'required|string',
            'receiver_city' => 'required|string',
            'receiver_district' => 'required|string',
            'receiver_village' => 'required|string',
            'receiver_postal_code' => 'required|string|max:10',
            'weight' => 'required|numeric|min:0.1',
            'length' => 'nullable|integer|min:1',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'reff_no' => 'nullable|string|max:50',
            'koli' => 'required|integer|min:1',
            'price_per_kg' => 'required|integer|min:0',
            'payment_method' => 'required|in:Cash,Tagihan',
        ]);

        $divisor = 4000;
        $volumeWeight = 0;
        
        if (!empty($validated['length']) && !empty($validated['width']) && !empty($validated['height'])) {
            $volumeWeight = (($validated['length'] * $validated['width'] * $validated['height']) / $divisor) * $validated['koli'];
        }
        
        $chargeableWeight = max($validated['weight'], $volumeWeight);

        $validated['resi'] = Order::generateResi();
        $validated['total_shipping'] = $chargeableWeight * $validated['price_per_kg'];
        $validated['current_status'] = 'Pending';
        $validated['payment_status'] = $validated['payment_method'] === 'Cash' ? 'Lunas' : 'Tagihan';

        $order = Order::create($validated);

        TrackingLog::create([
            'order_id' => $order->id,
            'status' => 'Pending',
            'location' => 'Sistem',
            'description' => 'Order telah dibuat',
            'logged_at' => now(),
            'updated_by' => 'Sistem',
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order berhasil dibuat!');
    }

    public function show(Order $order)
    {
        $order->load(['trackingLogs' => fn($q) => $q->orderBy('logged_at', 'asc')]);
        return view('admin.orders.show', compact('order'));
    }
}
