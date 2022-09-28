<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Direct Login Page
    public function loginPage() {
        return view('login');
    }

    // Direct Register Page
    public function registerPage() {
        return view('register');
    }

    // Dashboard
    public function dashboard() {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('category#list');
        }
        return redirect()->route('user#home');
    }
}
