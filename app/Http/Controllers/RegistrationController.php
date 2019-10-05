<?php


namespace App\Http\Controllers;


use App\Registration;

class RegistrationController extends Controller
{
    public function show($code)
    {
        return Registration::where('activity_code', $code)->get();
    }
}
