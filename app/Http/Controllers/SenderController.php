<?php

namespace App\Http\Controllers;

use App\Models\Order;

class SenderController extends Controller
{
    public function index()
    {
        $senders = Order::select('sender_name', 'sender_phone', 'sender_address', 'sender_city')
            ->distinct('sender_phone')
            ->groupBy('sender_phone', 'sender_name', 'sender_address', 'sender_city')
            ->orderBy('sender_name')
            ->paginate(10);

        return view('admin.senders.index', compact('senders'));
    }
}
