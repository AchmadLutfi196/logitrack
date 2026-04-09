<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('admin.tracking.index');
    }

    public function search(Request $request)
    {
        $resi = $request->input('resi');
        $order = Order::with(['trackingLogs' => fn($q) => $q->orderBy('logged_at', 'asc')])
            ->where('resi', $resi)
            ->first();

        if (!$order) {
            return back()->with('error', 'Resi tidak ditemukan');
        }

        return view('admin.tracking.show', compact('order'));
    }

    public function show(Order $order)
    {
        $order->load(['trackingLogs' => fn($q) => $q->orderBy('logged_at', 'asc')]);
        return view('admin.tracking.show', compact('order'));
    }
}
