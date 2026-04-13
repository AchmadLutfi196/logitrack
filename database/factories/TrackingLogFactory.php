<?php

namespace Database\Factories;

use App\Models\TrackingLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackingLog>
 */
class TrackingLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'status' => $this->faker->randomElement(['Pending', 'In Transit', 'Delivered']),
            'location' => $this->faker->city(),
            'description' => $this->faker->sentence(),
            'logged_at' => now(),
            'updated_by' => $this->faker->name(),
        ];
    }
}
