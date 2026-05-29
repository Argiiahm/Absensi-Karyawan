<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // profile
    public function profile()
    {
        return view('components.features.employes.profile.profile');
    }
}
