@extends('layouts.admin')

@section('content')
<h2 class="page-title">Ubah Pengembalian</h2>

<div class="row">
  <div class="col-md-8 col-lg-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.returns.update', $return) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Peminjam</label>
          <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
            <option value="">Pilih Peminjam</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id', $return->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
          </select>
          @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Alat</label>
          <select name="device_id" class="form-select @error('device_id') is-invalid @enderror" required>
            <option value="">Pilih Alat</option>
            @foreach($devices as $device)
              <option value="{{ $device->id }}" {{ old('device_id', $return->device_id) == $device->id ? 'selected' : '' }}>{{ $device->name }}</option>
            @endforeach
          </select>
          @error('device_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Mulai Pinjam</label>
          <input type="date" name="start_date" value="{{ old('start_date', $return->start_date) }}" class="form-control @error('start_date') is-invalid @enderror" required>
          @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Selesai Pinjam</label>
          <input type="date" name="end_date" value="{{ old('end_date', $return->end_date) }}" class="form-control @error('end_date') is-invalid @enderror">
          @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Pengembalian</label>
          <input
            type="datetime-local"
            name="returned_at"
            value="{{ old('returned_at', optional($return->returned_at)->format('Y-m-d\\TH:i')) }}"
            class="form-control @error('returned_at') is-invalid @enderror"
            required
          >
          @error('returned_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Kondisi Barang</label>
          <select name="return_condition" class="form-select @error('return_condition') is-invalid @enderror">
            <option value="">Pilih kondisi barang</option>
            <option value="baik" {{ old('return_condition', $return->return_condition) === 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="rusak ringan" {{ old('return_condition', $return->return_condition) === 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="rusak berat" {{ old('return_condition', $return->return_condition) === 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
            <option value="hilang" {{ old('return_condition', $return->return_condition) === 'hilang' ? 'selected' : '' }}>Hilang</option>
          </select>
          @error('return_condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label d-block">Tipe Denda</label>
          <div class="form-check border rounded-3 p-3 mb-2">
            <input class="form-check-input" type="radio" name="fine_type" id="fine_type_auto" value="auto_late" {{ old('fine_type', str_contains(strtolower((string) $return->note), 'denda otomatis keterlambatan') ? 'auto_late' : '') === 'auto_late' ? 'checked' : '' }}>
            <label class="form-check-label" for="fine_type_auto">Otomatis Keterlambatan</label>
          </div>
          <div class="form-check border rounded-3 p-3">
            <input class="form-check-input" type="radio" name="fine_type" id="fine_type_manual" value="manual_damage" {{ old('fine_type', str_contains(strtolower((string) $return->note), 'denda manual kerusakan') ? 'manual_damage' : 'manual_damage') === 'manual_damage' ? 'checked' : '' }}>
            <label class="form-check-label" for="fine_type_manual">Denda Kerusakan</label>
          </div>
          @error('fine_type')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        </div>

        <div id="automaticFineInfo" class="alert alert-info mb-3">
          Denda otomatis dihitung dari selisih `Tanggal Selesai Pinjam` dan `Tanggal Pengembalian` dengan tarif Rp 2.000 per hari.
        </div>

        <div id="manualFineFields" class="border rounded-3 p-3 mb-3" style="display: none;">
          <div class="mb-3">
            <label class="form-label">Nominal Denda Kerusakan</label>
            <input type="number" min="0" step="1000" name="manual_fine_amount" value="{{ old('manual_fine_amount', $return->fine_amount ?? 0) }}" class="form-control @error('manual_fine_amount') is-invalid @enderror">
            @error('manual_fine_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="form-label">Catatan Kerusakan</label>
            <textarea name="manual_fine_note" rows="3" class="form-control @error('manual_fine_note') is-invalid @enderror">{{ old('manual_fine_note') }}</textarea>
            @error('manual_fine_note')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Catatan</label>
          <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror">{{ old('note', $return->note) }}</textarea>
          @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Update
          </button>
          <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  (() => {
    const autoInput = document.getElementById('fine_type_auto');
    const manualInput = document.getElementById('fine_type_manual');
    const autoInfo = document.getElementById('automaticFineInfo');
    const manualFields = document.getElementById('manualFineFields');

    const syncFineFields = () => {
      const isManual = manualInput.checked;
      manualFields.style.display = isManual ? 'block' : 'none';
      autoInfo.style.display = isManual ? 'none' : 'block';
    };

    autoInput.addEventListener('change', syncFineFields);
    manualInput.addEventListener('change', syncFineFields);
    syncFineFields();
  })();
</script>
@endpush
