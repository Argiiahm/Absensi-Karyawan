<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('components.features.auth.login');
    }

    public function register()
    {
        return view('components.features.auth.register');
    }

    public function forgotPassword()
    {
        return view('components.features.auth.forgot-password');
    }

    public function resetPassword()
    {
        return view('components.features.auth.reset-password');
    }
}
