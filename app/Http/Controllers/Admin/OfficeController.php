<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        return view('components.features.admin.offices.index');
    }

    public function create()
    {
        return view('components.features.admin.offices.create');
    }

    public function store(Request $request)
    {
        // Logic to store new office coordinates & radius
    }

    public function edit($id)
    {
        return view('components.features.admin.offices.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update office details
    }

    public function destroy($id)
    {
        // Logic to delete office
    }
}
