<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the intro page.
     *
     * @return Renderable
     */
    public function intro()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('intro');
    }
}
