<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return Inertia::render('Welcome');
        }

        return redirect()->route('login.show');
    }
}
