<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $availableCount = Device::query()
            ->withActiveLoansCount()
            ->get()
            ->filter(fn (Device $device) => $device->available_stock > 0)
            ->count();

        return view('peminjam.dashboard', [
            'availableCount' => $availableCount,
            'loanCount' => Loan::where('user_id', $userId)->count(),
            'activeReturnCount' => Loan::where('user_id', $userId)->where('status', 'approved')->count(),
        ]);
    }

    public function devices()
    {
        $devices = Device::with('category')
            ->withActiveLoansCount()
            ->havingRaw('(good_stock - COALESCE(active_loans_quantity, 0)) > 0')
            ->paginate(12);

        return view('peminjam.devices', compact('devices'));
    }

    public function createLoan()
    {
        $devices = Device::with('category')
            ->withActiveLoansCount()
            ->havingRaw('(good_stock - COALESCE(active_loans_quantity, 0)) > 0')
            ->get();

        return view('peminjam.create-loan', compact('devices'));
    }

    public function returns()
    {
        $loans = Loan::with('device')
            ->where('user_id', Auth::id())
            ->where('status', 'returned')
            ->latest()
            ->paginate(10);

        return view('peminjam.returns', compact('loans'));
    }

    public function loanHistory()
    {
        $loans = Loan::with('device')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjam.loan-history', compact('loans'));
    }
}
