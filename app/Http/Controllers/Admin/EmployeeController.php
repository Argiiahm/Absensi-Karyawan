<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        // Paginate non-admin users. Eager load attendance count to avoid N+1.
        $employees = User::where('role', '!=', 'admin')
            ->withCount('attendances')
            ->latest()
            ->paginate(15);

        return view('components.features.admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('components.features.admin.employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'role'                  => ['required', 'in:karyawan,admin'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        return redirect('/admin/employees')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('components.features.admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'role'     => ['required', 'in:karyawan,admin'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $employee->name  = $data['name'];
        $employee->email = $data['email'];
        $employee->role  = $data['role'];

        if (!empty($data['password'])) {
            $employee->password = Hash::make($data['password']);
        }

        $employee->save();

        return redirect('/admin/employees')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect('/admin/employees')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
