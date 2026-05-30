<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('components.features.admin.employees.index');
    }

    public function create()
    {
        return view('components.features.admin.employees.create');
    }

    public function store(Request $request)
    {
        // Logic to store new employee
    }

    public function edit($id)
    {
        return view('components.features.admin.employees.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update employee details
    }

    public function destroy($id)
    {
        // Logic to delete/deactivate employee
    }
}
