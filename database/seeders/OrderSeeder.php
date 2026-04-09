<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\TrackingLog;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::create([
            'resi' => 'JP1234567890',
            'sender_name' => 'Budi Santoso',
            'sender_phone' => '08123456789',
            'sender_address' => 'Jl. Merdeka No. 10',
            'sender_province' => 'Jawa Barat',
            'sender_city' => 'Bandung',
            'sender_district' => 'Sumur Bandung',
            'sender_village' => 'Braga',
            'sender_postal_code' => '40111',
            'receiver_name' => 'Andi Wijaya',
            'receiver_phone' => '08987654321',
            'receiver_address' => 'Jl. Thamrin No. 5',
            'receiver_province' => 'DKI Jakarta',
            'receiver_city' => 'Jakarta Pusat',
            'receiver_district' => 'Gambir',
            'receiver_village' => 'Gambir',
            'receiver_postal_code' => '10110',
            'weight' => 2.5,
            'reff_no' => 'REFF-00350',
            'koli' => 333,
            'price_per_kg' => 10000,
            'total_shipping' => 25000,
            'payment_method' => 'Cash',
            'payment_status' => 'Lunas',
            'billing_notes' => 'Pembayaran tunai saat pick up',
            'current_status' => 'Delivered',
            'pod_receiver_name' => 'Andi Wijaya',
        ]);

        $baseTime = Carbon::now()->subDays(2);

        $logs = [
            ['status' => 'Pending', 'location' => 'Bandung', 'description' => 'Order telah dibuat', 'logged_at' => $baseTime, 'updated_by' => 'Sistem'],
            ['status' => 'Picked Up', 'location' => 'Bandung', 'description' => 'Kurir telah mengambil paket dari pengirim', 'logged_at' => $baseTime->copy()->addHours(5), 'updated_by' => 'Kurir Budi'],
            ['status' => 'At Drop Point', 'location' => 'DP Bandung Kota', 'description' => 'Paket telah tiba di Drop Point Bandung', 'logged_at' => $baseTime->copy()->addHours(12), 'updated_by' => 'Admin DP'],
            ['status' => 'In Transit', 'location' => 'Transit Center Bandung', 'description' => 'Paket berangkat dari Transit Center Bandung menuju Jakarta', 'logged_at' => $baseTime->copy()->addHours(19), 'updated_by' => 'Admin Hub'],
            ['status' => 'Arrived at Gateway', 'location' => 'Gateway Jakarta', 'description' => 'Paket telah tiba di Gateway Jakarta', 'logged_at' => $baseTime->copy()->addHours(29), 'updated_by' => 'Admin Gateway'],
            ['status' => 'Out for Delivery', 'location' => 'DP Jakarta Pusat', 'description' => 'Paket sedang dibawa oleh kurir [Budi] menuju alamat Anda', 'logged_at' => $baseTime->copy()->addHours(43), 'updated_by' => 'Kurir Budi'],
            ['status' => 'Delivered', 'location' => 'Jakarta Pusat', 'description' => 'Paket telah diterima oleh [Andi]', 'logged_at' => $baseTime->copy()->addHours(46), 'updated_by' => 'Kurir Budi'],
        ];

        foreach ($logs as $log) {
            TrackingLog::create(array_merge($log, ['order_id' => $order->id]));
        }

        // Second order — still in transit
        $order2 = Order::create([
            'resi' => 'JP9876543210',
            'sender_name' => 'Siti Rahayu',
            'sender_phone' => '08112233445',
            'sender_address' => 'Jl. Asia Afrika No. 25',
            'sender_province' => 'Jawa Barat',
            'sender_city' => 'Bandung',
            'sender_district' => 'Lengkong',
            'sender_village' => 'Burangrang',
            'sender_postal_code' => '40262',
            'receiver_name' => 'Dewi Lestari',
            'receiver_phone' => '08556677889',
            'receiver_address' => 'Jl. Pemuda No. 15',
            'receiver_province' => 'Jawa Timur',
            'receiver_city' => 'Surabaya',
            'receiver_district' => 'Genteng',
            'receiver_village' => 'Genteng',
            'receiver_postal_code' => '60275',
            'weight' => 5.0,
            'reff_no' => 'REFF-00351',
            'koli' => 2,
            'price_per_kg' => 12000,
            'total_shipping' => 60000,
            'payment_method' => 'Tagihan',
            'payment_status' => 'Tagihan',
            'billing_notes' => 'Tagihan ke PT. Maju Jaya',
            'current_status' => 'In Transit',
        ]);

        $base2 = Carbon::now()->subDay();

        $logs2 = [
            ['status' => 'Pending', 'location' => 'Bandung', 'description' => 'Order telah dibuat', 'logged_at' => $base2, 'updated_by' => 'Sistem'],
            ['status' => 'Picked Up', 'location' => 'Bandung', 'description' => 'Kurir telah mengambil paket dari pengirim', 'logged_at' => $base2->copy()->addHours(3), 'updated_by' => 'Kurir Ahmad'],
            ['status' => 'At Drop Point', 'location' => 'DP Bandung Selatan', 'description' => 'Paket telah tiba di Drop Point Bandung Selatan', 'logged_at' => $base2->copy()->addHours(6), 'updated_by' => 'Admin DP'],
            ['status' => 'In Transit', 'location' => 'Transit Center Bandung', 'description' => 'Paket berangkat dari Transit Center Bandung menuju Surabaya', 'logged_at' => $base2->copy()->addHours(10), 'updated_by' => 'Admin Hub'],
        ];

        foreach ($logs2 as $log) {
            TrackingLog::create(array_merge($log, ['order_id' => $order2->id]));
        }
    }
}
