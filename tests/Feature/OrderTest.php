<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_create_order_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/orders/create');

        $response->assertStatus(200);
        $response->assertSee('Buat Order');
    }

    public function test_guest_cannot_view_create_order_page(): void
    {
        $response = $this->get('/admin/orders/create');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_create_order(): void
    {
        $user = User::factory()->create();

        $orderData = [
            'sender_name' => 'John Doe',
            'sender_phone' => '081234567890',
            'sender_address' => 'Jl. Test No 1',
            'sender_province' => 'Jawa Barat',
            'sender_city' => 'Bandung',
            'sender_district' => 'Coblong',
            'sender_village' => 'Dago',
            'sender_postal_code' => '40135',
            'receiver_name' => 'Jane Doe',
            'receiver_phone' => '089876543210',
            'receiver_address' => 'Jl. Test No 2',
            'receiver_province' => 'DKI Jakarta',
            'receiver_city' => 'Jakarta Selatan',
            'receiver_district' => 'Kebayoran Baru',
            'receiver_village' => 'Melawai',
            'receiver_postal_code' => '12160',
            'weight' => 5,
            'koli' => 1,
            'price_per_kg' => 10000,
            'payment_method' => 'Cash',
        ];

        $response = $this->actingAs($user)->post('/admin/orders', $orderData);

        $this->assertDatabaseHas('orders', [
            'sender_name' => 'John Doe',
            'receiver_name' => 'Jane Doe',
            'total_shipping' => 50000,
        ]);

        $order = Order::latest()->first();
        $response->assertRedirect(route('admin.orders.show', $order));

        $this->assertDatabaseHas('tracking_logs', [
            'order_id' => $order->id,
            'status' => 'Pending',
        ]);
    }

    public function test_admin_can_view_order_details(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $response = $this->actingAs($user)->get("/admin/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertSee($order->resi);
    }
}
