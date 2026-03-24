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
        <div class="card-body">
          <h5 class="fw-bold">{{ $device->name }}</h5>
          <p class="mb-2 text-muted">Kategori: {{ optional($device->category)->name ?? '-' }}</p>
          <p class="mb-3">Status: <span class="badge text-bg-success">{{ ucfirst($device->status) }}</span></p>
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
