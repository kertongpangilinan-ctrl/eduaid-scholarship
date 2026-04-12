<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function requirements()
    {
        return view('requirements');
    }
    
    public function faq()
    {
        return view('faq');
    }
    
    public function contact()
    {
        return view('contact');
    }
}
