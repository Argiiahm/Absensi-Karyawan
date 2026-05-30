<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('components.features.admin.attendances.index');
    }

    public function show($id)
    {
        return view('components.features.admin.attendances.show', compact('id'));
    }

    public function prayers()
    {
        return view('components.features.admin.attendances.prayers');
    }
}
