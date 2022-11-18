<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        \Log::info("Url", $request->all());
    }
}
