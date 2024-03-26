<?php

namespace App\Http\Controllers;

class SpaController extends Controller
{
    public function index(): mixed
    {
        if (!cache('access_token')) {
            return redirect()->route('zoho.token');
        }
        return view('vue.index');
    }
}
