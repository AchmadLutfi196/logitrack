<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TrackingLog;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $query = Order::with('trackingLogs');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('resi', 'like', "%{$search}%")
                  ->orWhere('receiver_name', 'like', "%{$search}%");
            });
        } else {
            $query->where('current_status', '!=', 'Delivered');
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        return view('admin.courier.index', compact('orders', 'search'));
    }

    public function updateLog(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tracking-images', 'public');
        }

        TrackingLog::create([
            'order_id' => $order->id,
            'status' => $validated['status'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'logged_at' => now(),
            'updated_by' => 'Kurir',
            'image' => $imagePath,
        ]);

        $order->update(['current_status' => $validated['status']]);

        if ($validated['status'] === 'Delivered') {
            $order->update(['pod_receiver_name' => $order->receiver_name]);
        }

        return back()->with('success', 'Status pengiriman berhasil diupdate!');
    }
}
