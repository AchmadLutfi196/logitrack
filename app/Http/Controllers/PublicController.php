<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TrackingLog;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }

    public function track(Request $request)
    {
        $resi = $request->input('resi');
        $order = Order::with(['trackingLogs' => fn($q) => $q->orderBy('logged_at', 'asc')])
            ->where('resi', $resi)
            ->first();

        if ($request->ajax()) {
            if (!$order) {
                return response()->json(['found' => false]);
            }
            return response()->json([
                'found' => true,
                'html' => view('public._tracking_result', compact('order'))->render(),
            ]);
        }

        return view('public.landing', compact('order', 'resi'));
    }
}
