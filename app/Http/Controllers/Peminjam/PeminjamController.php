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

        return view('peminjam.dashboard', [
            'availableCount' => Device::where('status', 'available')->count(),
            'loanCount' => Loan::where('user_id', $userId)->count(),
            'activeReturnCount' => Loan::where('user_id', $userId)->where('status', 'approved')->count(),
        ]);
    }

    public function devices()
    {
        $devices = Device::with('category')
            ->where('status', 'available')
            ->paginate(12);

        return view('peminjam.devices', compact('devices'));
    }

    public function createLoan()
    {
        $devices = Device::with('category')
            ->where('status', 'available')
            ->get();

        return view('peminjam.create-loan', compact('devices'));
    }

    public function returns()
    {
        $loans = Loan::with('device')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'returned'])
            ->latest()
            ->paginate(10);

        return view('peminjam.returns', compact('loans'));
    }
}
