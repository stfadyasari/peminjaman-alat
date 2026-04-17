@extends('layouts.peminjam')

@section('page_title', 'Menu Peminjam')
@section('page_subtitle', 'Pilih menu untuk melihat alat, mengajukan peminjaman, serta membuka riwayat Anda')

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
        <div class="text-muted text-uppercase small fw-semibold mb-2">Pinjaman Aktif</div>
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
        <h5 class="fw-bold">Riwayat Peminjaman</h5>
        <p class="text-muted">Lihat seluruh pengajuan peminjaman Anda beserta status prosesnya.</p>
        <a href="{{ route('peminjam.loans.history') }}" class="btn btn-warning text-white">Buka Menu</a>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card panel-card h-100">
      <div class="card-body">
        <h5 class="fw-bold">Riwayat Pengembalian</h5>
        <p class="text-muted">Lihat detail pengembalian, denda, dan status pelunasan dari alat yang sudah kembali.</p>
        <a href="{{ route('peminjam.returns') }}" class="btn btn-outline-primary">Buka Menu</a>
      </div>
    </div>
  </div>
</div>
@endsection
