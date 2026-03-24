@extends('layouts.peminjam')

@section('page_title', 'Menu Peminjam')
@section('page_subtitle', 'Pilih menu untuk melihat alat, mengajukan peminjaman, atau mengembalikan alat')

@section('content')
<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <div class="text-muted text-uppercase small fw-semibold mb-2">Alat Tersedia</div>
        <div class="display-6 fw-bold text-primary">{{ $availableCount }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <div class="text-muted text-uppercase small fw-semibold mb-2">Pengajuan Saya</div>
        <div class="display-6 fw-bold text-success">{{ $loanCount }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <div class="text-muted text-uppercase small fw-semibold mb-2">Perlu Dikembalikan</div>
        <div class="display-6 fw-bold text-warning">{{ $activeReturnCount }}</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Lihat Daftar Alat</h5>
        <p class="text-muted">Melihat daftar alat yang tersedia lalu kembali ke menu peminjam.</p>
        <a href="{{ route('peminjam.devices') }}" class="btn btn-primary">Buka Menu</a>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Ajukan Peminjaman</h5>
        <p class="text-muted">Pilih alat yang tersedia, isi tanggal pinjam, kirim pengajuan, lalu kembali ke menu.</p>
        <a href="{{ route('peminjam.loans.create') }}" class="btn btn-success">Buka Menu</a>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Mengembalikan Alat</h5>
        <p class="text-muted">Lihat alat yang sedang dipinjam, tandai pengembalian, lalu kembali ke menu.</p>
        <a href="{{ route('peminjam.returns') }}" class="btn btn-warning text-white">Buka Menu</a>
      </div>
    </div>
  </div>
</div>
@endsection
