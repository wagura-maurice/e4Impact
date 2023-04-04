<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $data['title'] = 'dashboard';
        $data['description'] = 'resource monitoring and evaluation';
        
        return view('backend.home', compact('data'));
    }
}
