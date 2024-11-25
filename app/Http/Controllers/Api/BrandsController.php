<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\BrandResource;
use App\Models\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $geolocation = null;
//        if ($header = $request->header('CF-IPCountry')) {
//            $geolocation = $header;
//        } elseif ($request->has('CF-IPCountry')) {
//            $request = $request->all();
//            $geolocation = $request['CF-IPCountry'];
//        }
//
//        if ($geolocation === null) {
//            $brands = Brand::where(['geolocation' => $geolocation])->get();
//        } else {
//            $brands  = Brand::all();
//        }

        return BrandResource::collection(
            Brand::all()
        );
    }
}
