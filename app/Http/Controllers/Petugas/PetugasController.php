<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Loan;

class PetugasController extends Controller
{
    public function dashboard()
    {
        return view('petugas.dashboard', [
            'pendingCount' => Loan::where('status', 'pending')->count(),
            'approvedCount' => Loan::where('status', 'approved')->count(),
            'returnedCount' => Loan::where('status', 'returned')->count(),
        ]);
    }

    public function approvals()
    {
        $loans = Loan::with(['user', 'device'])
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->latest()
            ->paginate(15);

        return view('petugas.approvals', compact('loans'));
    }

    public function returns()
    {
        $loans = Loan::with(['user', 'device'])
            ->whereIn('status', ['approved', 'returned'])
            ->latest()
            ->paginate(15);

        return view('petugas.returns', compact('loans'));
    }

    public function report()
    {
        $loans = Loan::with(['user', 'device'])->latest()->get();

        return view('petugas.report', [
            'loans' => $loans,
            'pendingCount' => $loans->where('status', 'pending')->count(),
            'approvedCount' => $loans->where('status', 'approved')->count(),
            'returnedCount' => $loans->where('status', 'returned')->count(),
            'rejectedCount' => $loans->where('status', 'rejected')->count(),
        ]);
    }
}
