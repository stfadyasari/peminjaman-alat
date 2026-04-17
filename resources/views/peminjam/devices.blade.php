@extends('layouts.peminjam')

@section('page_title', 'Daftar Alat Tersedia')
@section('page_subtitle', 'Melihat daftar alat yang tersedia untuk dipinjam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted">Pilih alat yang tersedia untuk diajukan peminjamannya.</div>
  <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu
  </a>
</div>

<div class="row g-4">
  @forelse($devices as $device)
    <div class="col-md-6 col-xl-4">
      <div class="card panel-card h-100">
        @if($device->image)
          <img src="{{ asset('storage/'.$device->image) }}" alt="{{ $device->name }}" style="height: 220px; object-fit: cover;" class="card-img-top">
        @endif
        <div class="card-body">
          <h5 class="fw-bold">{{ $device->name }}</h5>
          <p class="mb-2 text-muted">Kategori: {{ optional($device->category)->name ?? '-' }}</p>
          <p class="mb-1">Total stok: <strong>{{ $device->stock }}</strong></p>
          <p class="mb-1">Kondisi baik: <strong>{{ $device->good_stock }}</strong></p>
          <p class="mb-1">Rusak ringan: <strong>{{ $device->minor_damage_stock }}</strong></p>
          <p class="mb-1">Rusak berat: <strong>{{ $device->major_damage_stock }}</strong></p>
          <p class="mb-3">Tersedia: <strong>{{ $device->available_stock }}</strong></p>
          <p class="mb-3">
            Status:
            <span class="badge {{ $device->available_stock > 0 ? 'text-bg-success' : 'text-bg-secondary' }}">
              {{ $device->available_stock > 0 ? 'Tersedia' : 'Tidak tersedia' }}
            </span>
          </p>
          <a href="{{ route('peminjam.loans.create') }}" class="btn btn-primary">Ajukan Peminjaman</a>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="card panel-card">
        <div class="card-body text-center text-muted py-5">Belum ada alat yang tersedia.</div>
      </div>
    </div>
  @endforelse
</div>

<div class="mt-3">
  {{ $devices->links() }}
</div>
@endsection
