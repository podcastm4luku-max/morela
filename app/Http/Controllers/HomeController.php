<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    } // Temporarily returning welcome or placeholder

    public function about()
    {
        return response('About Page Placeholder');
    }

    public function unidar()
    {
        return response('Unidar Page Placeholder');
    }

    public function map()
    {
        return response('Map Page Placeholder');
    }
}
