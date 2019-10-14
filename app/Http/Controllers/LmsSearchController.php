<?php

namespace App\Http\Controllers;


use App\Catalog;

class LmsSearchController extends Controller
{
    public function index()
    {
        return Catalog::where('activity_code', 'like', '%' . request('q') . '%')->take(20)->get();
    }
}
