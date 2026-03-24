@extends('layouts.peminjam')

@section('page_title', 'Ajukan Peminjaman')
@section('page_subtitle', 'Mengisi formulir peminjaman alat')

@section('content')
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
      <div class="mb-3">
        <label for="device_id" class="form-label">Pilih Alat</label>
        <select name="device_id" id="device_id" class="form-select" required>
          <option value="">Pilih alat</option>
          @foreach($devices as $device)
            <option value="{{ $device->id }}">{{ $device->name }} - {{ optional($device->category)->name ?? '-' }}</option>
          @endforeach
        </select>
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <label for="start_date" class="form-label">Tanggal Mulai</label>
          <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="end_date" class="form-label">Tanggal Selesai</label>
          <input type="date" name="end_date" id="end_date" class="form-control">
        </div>
      </div>

      <div class="mt-3">
        <label for="note" class="form-label">Catatan</label>
        <textarea name="note" id="note" rows="4" class="form-control" placeholder="Catatan tambahan jika ada"></textarea>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
        <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Menu</a>
      </div>
    </form>
  </div>
</div>
@endsection
