<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    public function country()
    {
        $data = Country::all();
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'List of Country',
            'data' => $data
        ];

        return response($response, 200);
    }

    public function province()
    {
        $data = Province::all();
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'List of Province',
            'data' => $data
        ];

        return response($response, 200);
    }

    public function regency($province_id)
    {
        $data = Regency::where('province_id', $province_id)->get();
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'List of Regency By Province ID',
            'data' => $data
        ];

        return response($response, 200);
    }
    
    public function district($regerency_id)
    {
        $data = District::where('regency_id', $regerency_id)->get();
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'List of District By Regerency ID',
            'data' => $data
        ];

        return response($response, 200);
    }
}
