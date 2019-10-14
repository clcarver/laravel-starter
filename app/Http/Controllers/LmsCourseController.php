<?php

namespace App\Http\Controllers;


use App\Catalog;

class LmsCourseController extends Controller
{
    public function index()
    {

    }

    public function show($id)
    {
        return Catalog::where('parent_id', $id)->whereNotNull('reference_id')->with('reference')->get();
    }
}
