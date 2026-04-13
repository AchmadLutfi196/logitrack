<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => 'New Admin',
            'email' => 'admin2@logitrack.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'admin2@logitrack.com',
        ]);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create();
        $userToUpdate = User::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($admin)->put("/admin/users/{$userToUpdate->id}", [
            'name' => 'New Name Updated',
            'email' => $userToUpdate->email, // keep email same
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'New Name Updated',
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create();
        $userToDelete = User::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/users/{$userToDelete->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }
}
