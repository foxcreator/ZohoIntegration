<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        if (!session('access_token')) {
            return redirect()->route('zoho');
        }
        return view('vue.index');
    }
}
