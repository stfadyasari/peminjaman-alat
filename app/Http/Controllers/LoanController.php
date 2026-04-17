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
        $devices = Device::withActiveLoansCount()
            ->havingRaw('(good_stock - COALESCE(active_loans_quantity, 0)) > 0')
            ->get();
        return view('loans.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id'=>'required|exists:devices,id',
            'quantity' => 'required|integer|min:1',
            'start_date'=>'required|date|after_or_equal:today',
            'end_date'=>'nullable|date|after_or_equal:start_date',
            'note'=>'nullable',
        ]);
        $data['user_id'] = Auth::id();
        $device = Device::withActiveLoansCount()->findOrFail($data['device_id']);

        if ($data['quantity'] > $device->available_stock) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => 'Jumlah pinjam melebihi stok tersedia.']);
        }

        $loan = Loan::create($data);
        $device->refreshInventoryStatus();
        ActivityLogger::log(
            'loan.create',
            'Membuat pengajuan peminjaman #'.$loan->id.' untuk alat #'.$device->id.' ('.$device->name.') sebanyak '.$loan->quantity.' unit'
        );
        return redirect()->route('peminjam.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function approve(Loan $loan)
    {
        $this->ensureOfficerAccess();

        $loan->status = 'approved';
        $loan->save();
        $device = $loan->device;
        $device->refreshInventoryStatus();
        ActivityLogger::log('loan.approve', 'Menyetujui peminjaman #'.$loan->id.' alat #'.$device->id.' ('.$device->name.') sebanyak '.$loan->quantity.' unit');
        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Loan $loan)
    {
        $this->ensureOfficerAccess();

        $loan->status = 'rejected';
        $loan->save();
        $device = $loan->device;
        $device->refreshInventoryStatus();
        ActivityLogger::log('loan.reject', 'Menolak peminjaman #'.$loan->id.' alat #'.$device->id.' ('.$device->name.') sebanyak '.$loan->quantity.' unit');
        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function returnForm(Loan $loan)
    {
        $this->ensureReturnAccess($loan);

        $loan->load(['device.category', 'user']);

        if (Auth::user()?->role === 'peminjam') {
            abort_unless(in_array($loan->status, ['approved', 'returned'], true), 404);

            $lateDays = $loan->calculateAutomaticFineUnits();
            $automaticFineAmount = $loan->calculateAutomaticFine();

            return view('peminjam.return-detail', compact('loan', 'lateDays', 'automaticFineAmount'));
        }

        abort_unless($loan->status === 'approved', 404);

        $lateDays = $loan->calculateAutomaticFineUnits();
        $automaticFineAmount = $loan->calculateAutomaticFine();

        return view('petugas.return-form', compact('loan', 'lateDays', 'automaticFineAmount'));
    }

    public function paymentForm(Loan $loan)
    {
        $this->ensureOfficerAccess();

        abort_unless($loan->status === 'returned', 404);
        abort_unless((float) ($loan->fine_amount ?? 0) > 0, 404);
        abort_if($loan->payment_method && $loan->payment_method !== 'none', 404, 'Denda sudah lunas.');

        $loan->load(['device.category', 'user']);

        return view('petugas.payment-form', compact('loan'));
    }

    public function markReturned(Loan $loan)
    {
        $this->ensureReturnAccess($loan);

        if (Auth::user()?->role === 'peminjam') {
            abort(403, 'Peminjam tidak dapat mengembalikan alat.');
        } else {
            abort_unless(in_array(Auth::user()?->role, ['admin', 'petugas'], true), 403, 'Unauthorized');
            abort_unless($loan->status === 'approved', 404);

            $data = request()->validate([
                'return_condition' => 'required|in:baik,rusak ringan,rusak berat,hilang',
                'fine_type' => 'required|in:auto_late,manual_damage',
                'manual_fine_amount' => 'nullable|required_if:fine_type,manual_damage|numeric|min:0',
                'manual_fine_note' => 'nullable|string',
                'payment_method' => 'required|in:none,tunai,qris',
                'note' => 'nullable|string',
            ]);

            $loan->return_condition = $data['return_condition'];

            $lateDays = $loan->calculateAutomaticFineUnits();
            $fineAmount = $data['fine_type'] === 'auto_late'
                ? $lateDays * 2000
                : (float) ($data['manual_fine_amount'] ?? 0);

            $noteParts = [];

            if (!empty($loan->note)) {
                $noteParts[] = trim((string) $loan->note);
            }

            if ($data['fine_type'] === 'auto_late') {
                $noteParts[] = 'Denda otomatis keterlambatan: '.$lateDays.' hari x Rp 2.000';
            } else {
                $damageNote = trim((string) ($data['manual_fine_note'] ?? ''));
                $noteParts[] = 'Denda manual kerusakan: Rp '.number_format($fineAmount, 0, ',', '.').($damageNote !== '' ? ' - '.$damageNote : '');
            }

            $officerNote = trim((string) ($data['note'] ?? ''));
            if ($officerNote !== '') {
                $noteParts[] = 'Catatan petugas: '.$officerNote;
            }

            $loan->fine_amount = $fineAmount;
            $loan->payment_method = $data['payment_method'];
            $loan->note = implode("\n", $noteParts);
        }

        $loan->status = 'returned';
        $loan->returned_at = now();
        $loan->save();
        $device = $loan->device;
        $device->applyReturnCondition($loan->return_condition, (int) $loan->quantity);
        $device->refreshInventoryStatus();
        ActivityLogger::log('loan.return', 'Menandai pengembalian peminjaman #'.$loan->id.' alat #'.$device->id.' ('.$device->name.') sebanyak '.$loan->quantity.' unit');

        if (Auth::user()?->role === 'peminjam') {
            return redirect()
                ->route('peminjam.returns')
                ->with('success', 'Pengembalian alat berhasil dikirim.');
        }

        if (Auth::user()?->role === 'petugas') {
            return redirect()
                ->route('petugas.returns')
                ->with('success', 'Pengembalian alat berhasil disimpan.');
        }

        return back()->with('success', 'Status pengembalian berhasil diperbarui.');
    }

    public function settlePayment(Request $request, Loan $loan)
    {
        $this->ensureOfficerAccess();

        abort_unless($loan->status === 'returned', 404);
        abort_unless((float) ($loan->fine_amount ?? 0) > 0, 404);

        $data = $request->validate([
            'payment_method' => 'required|in:tunai,qris',
            'note' => 'nullable|string',
        ]);

        $noteParts = [];

        if (!empty($loan->note)) {
            $noteParts[] = trim((string) $loan->note);
        }

        $settlementNote = trim((string) ($data['note'] ?? ''));
        $noteParts[] = 'Pelunasan denda oleh petugas via '.$data['payment_method'].($settlementNote !== '' ? ' - '.$settlementNote : '');

        $loan->payment_method = $data['payment_method'];
        $loan->note = implode("\n", $noteParts);
        $loan->save();

        ActivityLogger::log('loan.settle_payment', 'Melunasi denda peminjaman #'.$loan->id.' alat #'.$loan->device_id.' via '.$data['payment_method']);

        return redirect()
            ->route('petugas.returns')
            ->with('success', 'Pelunasan denda berhasil disimpan.');
    }
}
