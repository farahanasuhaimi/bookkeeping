<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function storeLogin(Request $request)
    {
        // For now, we'll just redirect back to the login page.
        // In a real application, you would add authentication logic here.
        return redirect()->route('login');
    }

    public function storeRegister(Request $request)
    {
        // For now, we'll just redirect back to the register page.
        // In a real application, you would add user creation logic here.
        return redirect()->route('register');
    }
}
