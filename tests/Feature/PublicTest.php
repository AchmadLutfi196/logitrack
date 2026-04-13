<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\TrackingLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_can_track_order_with_valid_resi(): void
    {
        $order = Order::factory()->create();
        TrackingLog::factory()->create(['order_id' => $order->id]);

        $response = $this->post('/track', [
            'resi' => $order->resi,
        ]);

        $response->assertStatus(200);
        $response->assertSee($order->resi);
    }

    public function test_cannot_track_order_with_invalid_resi(): void
    {
        $response = $this->post('/track', [
            'resi' => 'INVALID_RESI_123',
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('resi', 'INVALID_RESI_123');
    }
}
