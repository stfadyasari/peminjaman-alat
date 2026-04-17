<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Loan;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = Loan::with(['user', 'device'])
            ->where('status', 'returned')
            ->latest()
            ->paginate(20);

        return view('admin.returns.index', compact('returns'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $devices = Device::orderBy('name')->get();

        return view('admin.returns.create', compact('users', 'devices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'returned_at' => 'required|date',
            'return_condition' => 'nullable|in:baik,rusak ringan,rusak berat,hilang',
            'fine_type' => 'required|in:auto_late,manual_damage',
            'manual_fine_amount' => 'nullable|required_if:fine_type,manual_damage|numeric|min:0',
            'manual_fine_note' => 'nullable|string',
            'payment_method' => 'required|in:none,tunai,qris',
            'note' => 'nullable|string',
        ]);

        $payload = $this->buildReturnPayload($data);
        $return = Loan::create($payload);

        $device = Device::find($payload['device_id']);
        $device?->applyReturnCondition($return->return_condition, (int) ($return->quantity ?? 1));
        $device?->refreshInventoryStatus();
        ActivityLogger::log('return.create', 'Menambahkan data pengembalian #'.$return->id.' untuk alat #'.$payload['device_id']);

        return redirect()
            ->route('admin.returns.index')
            ->with('success', 'Data pengembalian berhasil ditambahkan.');
    }

    public function show(Loan $return)
    {
        abort_unless($return->status === 'returned', 404);
        $return->load(['user', 'device']);

        return view('admin.returns.show', compact('return'));
    }

    public function edit(Loan $return)
    {
        abort_unless($return->status === 'returned', 404);
        $users = User::orderBy('name')->get();
        $devices = Device::orderBy('name')->get();

        return view('admin.returns.edit', compact('return', 'users', 'devices'));
    }

    public function update(Request $request, Loan $return)
    {
        abort_unless($return->status === 'returned', 404);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'returned_at' => 'required|date',
            'return_condition' => 'nullable|in:baik,rusak ringan,rusak berat,hilang',
            'fine_type' => 'required|in:auto_late,manual_damage',
            'manual_fine_amount' => 'nullable|required_if:fine_type,manual_damage|numeric|min:0',
            'manual_fine_note' => 'nullable|string',
            'payment_method' => 'required|in:none,tunai,qris',
            'note' => 'nullable|string',
        ]);

        $previousDevice = Device::find($return->device_id);
        $previousDevice?->applyReturnCondition($return->return_condition, (int) ($return->quantity ?? 1), true);
        $previousDevice?->refreshInventoryStatus();

        $payload = $this->buildReturnPayload($data);
        $return->update($payload);

        $device = Device::find($payload['device_id']);
        $device?->applyReturnCondition($return->return_condition, (int) ($return->quantity ?? 1));
        $device?->refreshInventoryStatus();
        ActivityLogger::log('return.update', 'Mengubah data pengembalian #'.$return->id.' untuk alat #'.$payload['device_id']);

        return redirect()
            ->route('admin.returns.index')
            ->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy(Loan $return)
    {
        abort_unless($return->status === 'returned', 404);

        $deviceId = $return->device_id;
        $returnId = $return->id;
        $device = Device::find($deviceId);
        $device?->applyReturnCondition($return->return_condition, (int) ($return->quantity ?? 1), true);
        $device?->refreshInventoryStatus();
        $return->delete();
        ActivityLogger::log('return.delete', 'Menghapus data pengembalian #'.$returnId.' untuk alat #'.$deviceId);

        return back()->with('success', 'Data pengembalian berhasil dihapus.');
    }

    protected function buildReturnPayload(array $data): array
    {
        $returnedAt = Carbon::parse($data['returned_at']);
        $referenceLoan = new Loan([
            'end_date' => $data['end_date'] ?? null,
            'returned_at' => $returnedAt,
        ]);

        $fineAmount = $data['fine_type'] === 'auto_late'
            ? $referenceLoan->calculateAutomaticFine($returnedAt)
            : (float) ($data['manual_fine_amount'] ?? 0);

        $noteParts = [];

        if ($data['fine_type'] === 'auto_late') {
            $noteParts[] = 'Denda otomatis keterlambatan: '.$referenceLoan->calculateAutomaticFineUnits($returnedAt).' hari x Rp 2.000';
        } else {
            $damageNote = trim((string) ($data['manual_fine_note'] ?? ''));
            $noteParts[] = 'Denda manual kerusakan: Rp '.number_format($fineAmount, 0, ',', '.').($damageNote !== '' ? ' - '.$damageNote : '');
        }

        $adminNote = trim((string) ($data['note'] ?? ''));
        if ($adminNote !== '') {
            $noteParts[] = 'Catatan admin: '.$adminNote;
        }

        unset($data['fine_type'], $data['manual_fine_amount'], $data['manual_fine_note']);

        $data['status'] = 'returned';
        $data['fine_amount'] = $fineAmount;
        $data['note'] = implode("\n", $noteParts);

        return $data;
    }
}
