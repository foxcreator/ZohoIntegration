<?php

namespace App\Http\Controllers\B2C;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealsController extends Controller
{
    public function store(Request $request)
    {
        return response()->json($request->all());
    }
}
