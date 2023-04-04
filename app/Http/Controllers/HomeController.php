<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        $data             = new stdClass;
        $data->breadcrumb = (object) [
            'title'       => __('dashboard'),
            'description' => __('A dashboard is a visual representation of data and information that provides a quick and easy way to understand key performance indicators (KPIs) and track progress towards goals.'),
            'route'       => implode(' ', explode('.', Route::currentRouteName())),
            'new'         => [
                // 'route' => route('project.catalog.create'),
                // 'title' => 'new project'
            ]
        ];
        
        return view('backend.home', compact('data'));
    }
}
