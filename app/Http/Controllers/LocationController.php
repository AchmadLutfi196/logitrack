<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Village;

class LocationController extends Controller
{
    public function cities($provinceId)
    {
        return City::where('province_id', $provinceId)->orderBy('name')->get(['id', 'name']);
    }

    public function districts($cityId)
    {
        return District::where('city_id', $cityId)->orderBy('name')->get(['id', 'name']);
    }

    public function villages($districtId)
    {
        return Village::where('district_id', $districtId)->orderBy('name')->get(['id', 'name']);
    }
}
