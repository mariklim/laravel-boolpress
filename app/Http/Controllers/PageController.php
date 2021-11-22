<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view("guest.welcome");
    }

    public function about()
    {
        return view("guest.about");
    }

    public function contact()
    {
        return view("guest.contact");
    }

    public function apiPosts()
    {
        return view("guest.api");
    }
}