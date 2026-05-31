<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $submissions = Submission::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('components.features.employes.submissions.index', compact('user', 'submissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150|min:3',
            'type' => 'required|in:pengajuan,laporan',
            'description' => 'required|string|min:10',
            'attachment' => 'nullable|file|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'title.required' => 'Judul pengajuan/laporan harus diisi.',
            'title.min' => 'Judul minimal harus 3 karakter.',
            'title.max' => 'Judul maksimal 150 karakter.',
            'type.required' => 'Tipe pengajuan harus dipilih.',
            'type.in' => 'Tipe pengajuan tidak valid.',
            'description.required' => 'Keterangan/deskripsi harus diisi.',
            'description.min' => 'Keterangan harus minimal 10 karakter.',
            'attachment.image' => 'File harus berupa gambar atau PDF.',
            'attachment.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, pdf.',
            'attachment.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'sub_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('submissions', $filename, 'public');
            $attachmentPath = '/storage/' . $path;
        }

        Submission::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan/Laporan berhasil dikirim.');
    }
}
