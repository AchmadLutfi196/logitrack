<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_tracking_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/tracking');

        $response->assertStatus(200);
    }

    public function test_admin_can_search_tracking_by_resi(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $response = $this->actingAs($user)->post('/admin/tracking/search', [
            'resi' => $order->resi,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('admin.tracking.show');
        $response->assertSee($order->resi);
    }

    public function test_admin_cannot_search_invalid_resi(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/tracking/search', [
            'resi' => 'INVALID_RESI_TEST',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_admin_can_view_tracking_details(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $response = $this->actingAs($user)->get("/admin/tracking/{$order->id}");

        $response->assertStatus(200);
        $response->assertSee($order->resi);
    }
}
