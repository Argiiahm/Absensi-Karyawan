<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        // Eager load attendances count per office to avoid N+1
        $offices = Office::withCount('attendances')
            ->latest()
            ->paginate(10);

        return view('components.features.admin.offices.index', compact('offices'));
    }

    public function create()
    {
        return view('components.features.admin.offices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'latitude'   => ['required', 'numeric', 'between:-90,90'],
            'longitude'  => ['required', 'numeric', 'between:-180,180'],
            'radius'     => ['required', 'integer', 'min:10', 'max:1000'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i'],
        ]);

        Office::create($data);

        return redirect('/admin/offices')
            ->with('success', 'Lokasi kantor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $office = Office::findOrFail($id);
        return view('components.features.admin.offices.edit', compact('office'));
    }

    public function update(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'latitude'   => ['required', 'numeric', 'between:-90,90'],
            'longitude'  => ['required', 'numeric', 'between:-180,180'],
            'radius'     => ['required', 'integer', 'min:10', 'max:1000'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i'],
        ]);

        $office->update($data);

        return redirect('/admin/offices')
            ->with('success', 'Data kantor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return redirect('/admin/offices')
            ->with('success', 'Kantor berhasil dihapus.');
    }
}
