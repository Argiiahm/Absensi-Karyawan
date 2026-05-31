<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $leaves = Leave::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('components.features.employes.leaves.index', compact('user', 'leaves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sakit,izin,cuti',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:5',
            'attachment' => 'nullable|file|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'type.required' => 'Tipe izin harus dipilih.',
            'type.in' => 'Tipe izin tidak valid.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'end_date.date' => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'reason.required' => 'Alasan izin harus diisi.',
            'reason.min' => 'Alasan harus minimal 5 karakter.',
            'attachment.image' => 'File harus berupa gambar atau PDF.',
            'attachment.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, pdf.',
            'attachment.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'leave_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('leaves', $filename, 'public');
            $attachmentPath = '/storage/' . $path;
        }

        Leave::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permohonan izin/cuti berhasil diajukan.');
    }
}
