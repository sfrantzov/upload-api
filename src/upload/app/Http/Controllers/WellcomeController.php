<?php

namespace App\Http\Controllers;


class WellcomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('async');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function sync()
    {
        return view('upload');
    }
}
