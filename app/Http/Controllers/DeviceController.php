<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    protected function validateDevice(Request $request): array
    {
        $validator = validator($request->all(), [
            'name' => 'required',
            'stock' => 'required|integer|min:0',
            'good_stock' => 'required|integer|min:0',
            'minor_damage_stock' => 'required|integer|min:0',
            'major_damage_stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validator->after(function (Validator $validator) use ($request) {
            $stock = (int) $request->input('stock', 0);
            $goodStock = (int) $request->input('good_stock', 0);
            $minorDamageStock = (int) $request->input('minor_damage_stock', 0);
            $majorDamageStock = (int) $request->input('major_damage_stock', 0);
            $conditionStocks = $goodStock + $minorDamageStock + $majorDamageStock;

            if ($stock !== $conditionStocks) {
                $validator->errors()->add(
                    'stock',
                    'Total stok harus sama dengan jumlah stok baik, rusak ringan, dan rusak berat.'
                );
            }
        });

        return $validator->validate();
    }

    public function index()
    {
        if (!request()->routeIs('admin.*')) {
            $devices = Device::with('category')->withActiveLoansCount()->paginate(20);
            return view('devices.index', compact('devices'));
        }

        $devices = Device::with('category')->withActiveLoansCount()->paginate(20);
        return view('admin.devices.index', compact('devices'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.devices.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateDevice($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('devices', 'public');
        }

        $device = new Device($data);
        $device->syncInventoryAttributes();
        $device->save();
        ActivityLogger::log('device.create', 'Menambahkan alat #'.$device->id.' ('.$device->name.')');
        return redirect()->route('admin.devices.index');
    }

    public function edit(Device $device)
    {
        $categories = Category::all();

        return view('admin.devices.edit', compact('device','categories'));
    }

    public function update(Request $request, Device $device)
    {
        $data = $this->validateDevice($request);

        if ($request->hasFile('image')) {
            if ($device->image) {
                Storage::disk('public')->delete($device->image);
            }

            $data['image'] = $request->file('image')->store('devices', 'public');
        }

        $device->fill($data);
        $device->loadSum([
            'loans as active_loans_quantity' => function ($loanQuery) {
                $loanQuery->whereIn('status', ['pending', 'approved']);
            },
        ], 'quantity');
        $device->syncInventoryAttributes();
        $device->save();
        ActivityLogger::log('device.update', 'Mengubah alat #'.$device->id.' ('.$device->name.')');
        return redirect()->route('admin.devices.index');
    }

    public function destroy(Device $device)
    {
        $deviceId = $device->id;
        $deviceName = $device->name;

        if ($device->image) {
            Storage::disk('public')->delete($device->image);
        }

        $device->delete();
        ActivityLogger::log('device.delete', 'Menghapus alat #'.$deviceId.' ('.$deviceName.')');
        return back();
    }
}
