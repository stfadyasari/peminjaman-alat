<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Device;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    protected function ensureOfficerAccess(): void
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['admin', 'petugas'], true)) {
            abort(403, 'Unauthorized');
        }
    }

    protected function ensureReturnAccess(Loan $loan): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (in_array($user->role, ['admin', 'petugas'], true)) {
            return;
        }

        if ($user->role === 'peminjam' && (int) $loan->user_id === (int) $user->id) {
            return;
        }

        abort(403, 'Unauthorized');
    }

    public function index()
    {
        $user = Auth::user();
        if (request()->routeIs('admin.*')) {
            $loans = Loan::with(['user','device'])->latest()->paginate(20);
            return view('admin.loans.index', compact('loans'));
        }

        if ($user && $user->role === 'admin') {
            $loans = Loan::with(['user','device'])->paginate(20);
        } else if ($user && $user->role === 'petugas') {
            $loans = Loan::with(['user','device'])->paginate(20);
        } else {
            $loans = Loan::with('device')->where('user_id', $user->id)->paginate(20);
        }
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $devices = Device::where('status','available')->get();
        return view('loans.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id'=>'required|exists:devices,id',
            'start_date'=>'required|date',
            'end_date'=>'nullable|date|after_or_equal:start_date',
            'note'=>'nullable',
        ]);
        $data['user_id'] = Auth::id();
        $loan = Loan::create($data);
        $device = Device::find($data['device_id']);
        $device->status = 'reserved';
        $device->save();
        ActivityLogger::log(
            'loan.create',
            'Membuat pengajuan peminjaman #'.$loan->id.' untuk alat #'.$device->id.' ('.$device->name.')'
        );
        return redirect()->route('peminjam.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function approve(Loan $loan)
    {
        $this->ensureOfficerAccess();

        $loan->status = 'approved';
        $loan->save();
        $device = $loan->device;
        $device->status = 'borrowed';
        $device->save();
        ActivityLogger::log('loan.approve', 'Menyetujui peminjaman #'.$loan->id.' alat #'.$device->id.' ('.$device->name.')');
        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Loan $loan)
    {
        $this->ensureOfficerAccess();

        $loan->status = 'rejected';
        $loan->save();
        $device = $loan->device;
        $device->status = 'available';
        $device->save();
        ActivityLogger::log('loan.reject', 'Menolak peminjaman #'.$loan->id.' alat #'.$device->id.' ('.$device->name.')');
        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function markReturned(Loan $loan)
    {
        $this->ensureReturnAccess($loan);

        $loan->status = 'returned';
        $loan->returned_at = now();
        $loan->save();
        $device = $loan->device;
        $device->status = 'available';
        $device->save();
        ActivityLogger::log('loan.return', 'Menandai pengembalian peminjaman #'.$loan->id.' alat #'.$device->id.' ('.$device->name.')');
        return back()->with('success', 'Status pengembalian berhasil diperbarui.');
    }
}
