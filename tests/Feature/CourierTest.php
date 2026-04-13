<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourierTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_courier_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/courier');

        $response->assertStatus(200);
    }

    public function test_admin_can_update_tracking_log(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $response = $this->actingAs($user)->post("/admin/courier/{$order->id}/log", [
            'status' => 'In Transit',
            'location' => 'Jakarta Raya',
            'description' => 'Paket sedang dalam perjalanan',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tracking_logs', [
            'order_id' => $order->id,
            'status' => 'In Transit',
            'location' => 'Jakarta Raya',
        ]);
        
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'current_status' => 'In Transit',
        ]);
    }

    public function test_admin_can_upload_pod(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $order = Order::factory()->create();
        $photo = UploadedFile::fake()->image('pod.jpg');

        $response = $this->actingAs($user)->post("/admin/courier/{$order->id}/log", [
            'status' => 'Delivered',
            'location' => 'Penerima',
            'description' => 'Paket diterima oleh keluarga',
            'image' => $photo,
        ]);

        $response->assertRedirect();

        $order->refresh();
        $this->assertEquals($order->receiver_name, $order->pod_receiver_name);
        $this->assertEquals('Delivered', $order->current_status);
        
        $this->assertDatabaseHas('tracking_logs', [
            'order_id' => $order->id,
            'status' => 'Delivered',
        ]);
        
        $log = \App\Models\TrackingLog::where('order_id', $order->id)->where('status', 'Delivered')->first();
        $this->assertNotNull($log->image);
    }
}
