<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::with(['user', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('components.features.admin.submissions.index', compact('submissions'));
    }

    public function approve($id)
    {
        $submission = Submission::findOrFail($id);

        $submission->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Pengajuan/Laporan berhasil disetujui (ACC).');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:3',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 3 karakter.',
        ]);

        $submission = Submission::findOrFail($id);

        $submission->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Pengajuan/Laporan berhasil ditolak.');
    }
}
