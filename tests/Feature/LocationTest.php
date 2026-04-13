<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_cities_by_province(): void
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        City::create(['province_id' => $province->id, 'name' => 'Bandung']);

        $response = $this->get("/api/locations/cities/{$province->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Bandung']);
    }

    public function test_can_get_districts_by_city(): void
    {
        // For testing, Controller queries using City name, but actually wait, LocationController needs checks. Let's assume it queries by name.
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        District::create(['city_id' => $city->id, 'name' => 'Coblong']);

        $response = $this->get("/api/locations/districts/{$city->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Coblong']);
    }

    public function test_can_get_villages_by_district(): void
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        $district = District::create(['city_id' => $city->id, 'name' => 'Coblong']);
        Village::create(['district_id' => $district->id, 'name' => 'Dago']);

        $response = $this->get("/api/locations/villages/{$district->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Dago']);
    }
}
