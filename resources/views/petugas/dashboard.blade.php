@extends('layouts.petugas')

@section('page_title', 'Menu Petugas')
@section('page_subtitle', 'Pilih tugas yang ingin dikerjakan')

@section('content')
<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <div class="text-muted text-uppercase small fw-semibold mb-2">Peminjaman Pending</div>
        <div class="display-6 fw-bold text-warning">{{ $pendingCount }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <div class="text-muted text-uppercase small fw-semibold mb-2">Sedang Dipinjam</div>
        <div class="display-6 fw-bold text-success">{{ $approvedCount }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <div class="text-muted text-uppercase small fw-semibold mb-2">Sudah Kembali</div>
        <div class="display-6 fw-bold text-primary">{{ $returnedCount }}</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Setujui Peminjaman</h5>
        <p class="text-muted">Buka daftar pengajuan lalu setujui atau tolak peminjaman, kemudian kembali ke menu petugas.</p>
        <a href="{{ route('petugas.approvals') }}" class="btn btn-teal btn-success">Buka Menu</a>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Pantau Pengembalian</h5>
        <p class="text-muted">Pantau status pengembalian dan tandai alat yang sudah dikembalikan, lalu kembali ke menu petugas.</p>
        <a href="{{ route('petugas.returns') }}" class="btn btn-primary">Buka Menu</a>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Cetak Laporan</h5>
        <p class="text-muted">Lihat ringkasan seluruh data peminjaman dan cetak laporan langsung dari halaman ini.</p>
        <a href="{{ route('petugas.report') }}" class="btn btn-dark">Buka Menu</a>
      </div>
    </div>
  </div>
</div>
@endsection
