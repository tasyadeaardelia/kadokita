<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\Courier;
use App\Models\Province;
use App\Models\City;

class LocationsController extends Controller
{
    public function getCities($id) {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');
        return json_encode($city);
    }
}
