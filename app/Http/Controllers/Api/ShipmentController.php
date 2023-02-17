<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function create(Request $request){
        dd($request->all());
        return response()->json(['succes' => 'Shipments are created'], 201);
    }
}
