<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ReceiverController extends Controller
{
    public function index()
    {
        $receivers = Order::select('receiver_name', 'receiver_phone', 'receiver_address', 'receiver_city')
            ->distinct('receiver_phone')
            ->groupBy('receiver_phone', 'receiver_name', 'receiver_address', 'receiver_city')
            ->orderBy('receiver_name')
            ->paginate(10);

        return view('admin.receivers.index', compact('receivers'));
    }
}
