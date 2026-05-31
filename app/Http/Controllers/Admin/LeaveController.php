<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with(['user', 'approver']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search name if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('components.features.admin.leaves.index', compact('leaves'));
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Permohonan izin/cuti berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:3',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 3 karakter.',
        ]);

        $leave = Leave::findOrFail($id);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Permohonan izin/cuti berhasil ditolak.');
    }
}
