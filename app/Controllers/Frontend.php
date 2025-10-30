<?php

namespace App\Controllers;

class Frontend extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'active_page' => 'home'
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/home')
             . view('frontend/layouts/footer');
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'active_page' => 'about',
            'additional_css' => ['assets/css/about.css']
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/about')
             . view('frontend/layouts/footer', ['additional_js' => ['assets/js/about.js']]);
    }

    public function careers()
    {
        $data = [
            'title' => 'Careers',
            'active_page' => 'careers',
            'additional_css' => ['assets/css/careers.css']
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/careers')
             . view('frontend/layouts/footer');
    }

    public function connect()
    {
        $data = [
            'title' => 'Connect',
            'active_page' => 'connect'
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/connect')
             . view('frontend/layouts/footer', ['additional_js' => ['assets/js/connect.js']]);
    }
}
