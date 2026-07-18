<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreLocatorController extends Controller
{
    public function index()
    {
        return view('stores.locator');
    }

    public function apiStores()
    {
        $stores = \App\Models\Store::all();
        return response()->json($stores);
    }
}
