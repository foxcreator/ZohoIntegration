<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        if (!cache('access_token')) {
            return redirect()->route('zoho.token');
        }
        return view('vue.index');
    }
}
