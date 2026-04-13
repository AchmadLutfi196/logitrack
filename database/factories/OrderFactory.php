<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resi' => \App\Models\Order::generateResi(),
            'sender_name' => $this->faker->name(),
            'sender_phone' => $this->faker->numerify('08##########'),
            'sender_address' => $this->faker->address(),
            'sender_province' => 'Jawa Barat',
            'sender_city' => 'Bandung',
            'sender_district' => 'Coblong',
            'sender_village' => 'Dago',
            'sender_postal_code' => '40135',
            'receiver_name' => $this->faker->name(),
            'receiver_phone' => $this->faker->numerify('08##########'),
            'receiver_address' => $this->faker->address(),
            'receiver_province' => 'DKI Jakarta',
            'receiver_city' => 'Jakarta Selatan',
            'receiver_district' => 'Kebayoran Baru',
            'receiver_village' => 'Melawai',
            'receiver_postal_code' => '12160',
            'weight' => $this->faker->randomFloat(2, 1, 10),
            'length' => $this->faker->numberBetween(10, 50),
            'width' => $this->faker->numberBetween(10, 50),
            'height' => $this->faker->numberBetween(10, 50),
            'reff_no' => $this->faker->optional()->word(),
            'koli' => 1,
            'price_per_kg' => 10000,
            'total_shipping' => 100000, // Roughly weight * price
            'payment_method' => 'Cash',
            'payment_status' => 'Lunas',
            'current_status' => 'Pending',
        ];
    }
}
