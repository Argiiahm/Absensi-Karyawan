<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('components.features.admin.informations.index', compact('announcements'));
    }

    public function create()
    {
        return view('components.features.admin.informations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200|min:3',
            'content' => 'required|string|min:10',
            'attachment' => 'nullable|file|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'title.min' => 'Judul minimal 3 karakter.',
            'title.max' => 'Judul maksimal 200 karakter.',
            'content.required' => 'Konten pengumuman wajib diisi.',
            'content.min' => 'Konten minimal 10 karakter.',
            'attachment.image' => 'File harus berupa gambar atau PDF.',
            'attachment.mimes' => 'Format yang diperbolehkan: jpeg, png, jpg, pdf.',
            'attachment.max' => 'Ukuran file maksimal adalah 2MB.',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'ann_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('announcements', $filename, 'public');
            $attachmentPath = '/storage/' . $path;
        }

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'attachment_path' => $attachmentPath,
            'created_by' => Auth::id(),
        ]);

        return redirect('/admin/informations')->with('success', 'Pengumuman baru berhasil dipublikasikan.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Delete file attachment if exists
        if ($announcement->attachment_path) {
            $relativePath = str_replace('/storage/', '', $announcement->attachment_path);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $announcement->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
