<?php

namespace App\Http\Controllers;


class WellcomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('upload');
    }
}
