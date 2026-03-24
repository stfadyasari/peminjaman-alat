<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Loan;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

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
            'note' => 'nullable|string',
        ]);

        $data['status'] = 'returned';
        $return = Loan::create($data);

        Device::where('id', $data['device_id'])->update(['status' => 'available']);
        ActivityLogger::log('return.create', 'Menambahkan data pengembalian #'.$return->id.' untuk alat #'.$data['device_id']);

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
            'note' => 'nullable|string',
        ]);

        $data['status'] = 'returned';
        $return->update($data);

        Device::where('id', $data['device_id'])->update(['status' => 'available']);
        ActivityLogger::log('return.update', 'Mengubah data pengembalian #'.$return->id.' untuk alat #'.$data['device_id']);

        return redirect()
            ->route('admin.returns.index')
            ->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy(Loan $return)
    {
        abort_unless($return->status === 'returned', 404);

        $deviceId = $return->device_id;
        $returnId = $return->id;
        $return->delete();
        Device::where('id', $deviceId)->update(['status' => 'available']);
        ActivityLogger::log('return.delete', 'Menghapus data pengembalian #'.$returnId.' untuk alat #'.$deviceId);

        return back()->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
