@extends('layouts.peminjam')

@section('page_title', 'Ajukan Peminjaman')
@section('page_subtitle', 'Mengisi formulir peminjaman alat')

@section('content')
@php
  $today = now()->toDateString();
@endphp
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted">Isi formulir berikut lalu kirim pengajuan peminjaman.</div>
  <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu
  </a>
</div>

<div class="card panel-card">
  <div class="card-body p-4">
    <form method="POST" action="{{ route('loans.store') }}">
      @csrf
      <div class="mb-4">
        <label for="device_id" class="form-label">Pilih Alat</label>
        <select name="device_id" id="device_id" class="form-select @error('device_id') is-invalid @enderror" required>
          <option value="">Pilih alat</option>
          @foreach($devices as $device)
            <option
              value="{{ $device->id }}"
              data-name="{{ $device->name }}"
              data-category="{{ optional($device->category)->name ?? '-' }}"
              data-available="{{ $device->available_stock }}"
              data-good="{{ $device->good_stock }}"
              data-minor="{{ $device->minor_damage_stock }}"
              data-major="{{ $device->major_damage_stock }}"
              {{ (string) old('device_id') === (string) $device->id ? 'selected' : '' }}
            >
              {{ $device->name }} - {{ optional($device->category)->name ?? '-' }}
            </option>
          @endforeach
        </select>
        @error('device_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="row g-3 mb-3" id="device-stock-summary">
        <div class="col-md-3">
          <div class="border rounded-3 p-3 h-100 bg-light">
            <div class="small text-muted">Stok Tersedia</div>
            <div class="fs-4 fw-bold" data-role="available">0</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="border rounded-3 p-3 h-100 bg-light">
            <div class="small text-muted">Kondisi Baik</div>
            <div class="fs-4 fw-bold text-success" data-role="good">0</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="border rounded-3 p-3 h-100 bg-light">
            <div class="small text-muted">Rusak Ringan</div>
            <div class="fs-4 fw-bold text-warning" data-role="minor">0</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="border rounded-3 p-3 h-100 bg-light">
            <div class="small text-muted">Rusak Berat</div>
            <div class="fs-4 fw-bold text-danger" data-role="major">0</div>
          </div>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-md-4">
          <label for="quantity" class="form-label">Jumlah Pinjam</label>
          <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" class="form-control @error('quantity') is-invalid @enderror" required>
          <div class="form-text">Maksimal sesuai stok tersedia.</div>
          @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
          <label for="start_date" class="form-label">Tanggal Mulai</label>
          <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" min="{{ $today }}" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label for="end_date" class="form-label">Tanggal Selesai</label>
          <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ old('start_date', $today) }}" class="form-control">
        </div>
      </div>

      <div class="mt-3">
        <label for="note" class="form-label">Catatan</label>
        <textarea name="note" id="note" rows="4" class="form-control" placeholder="Catatan tambahan jika ada">{{ old('note') }}</textarea>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
        <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Menu</a>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('device_id');
    const quantityInput = document.getElementById('quantity');
    const summary = document.getElementById('device-stock-summary');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    function updateDeviceSummary() {
      const option = select.options[select.selectedIndex];
      const available = Number(option?.dataset.available || 0);
      const good = Number(option?.dataset.good || 0);
      const minor = Number(option?.dataset.minor || 0);
      const major = Number(option?.dataset.major || 0);

      summary.querySelector('[data-role="available"]').textContent = available;
      summary.querySelector('[data-role="good"]').textContent = good;
      summary.querySelector('[data-role="minor"]').textContent = minor;
      summary.querySelector('[data-role="major"]').textContent = major;

      quantityInput.max = available > 0 ? available : 1;
      if (Number(quantityInput.value || 0) > available && available > 0) {
        quantityInput.value = available;
      }
    }

    function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');

      return `${year}-${month}-${day}`;
    }

    function syncEndDate() {
      if (!startDateInput.value) {
        endDateInput.min = '{{ $today }}';
        return;
      }

      const startDate = new Date(startDateInput.value + 'T00:00:00');

      if (Number.isNaN(startDate.getTime())) {
        endDateInput.min = '{{ $today }}';
        return;
      }

      startDate.setDate(startDate.getDate() + 1);
      const nextDate = formatDate(startDate);

      endDateInput.min = nextDate;

      if (!endDateInput.value || endDateInput.value < nextDate) {
        endDateInput.value = nextDate;
      }
    }

    select.addEventListener('change', updateDeviceSummary);
    startDateInput.addEventListener('change', syncEndDate);
    updateDeviceSummary();
    syncEndDate();
  });
</script>
@endsection
