@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="page-title mb-0">Detail Pengembalian</h2>
  <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

<div class="card p-4">
  <div class="row g-3">
    <div class="col-md-6">
      <div class="text-muted small">ID Pengembalian</div>
      <div class="fw-semibold">#{{ $return->id }}</div>
    </div>
    <div class="col-md-6">
      <div class="text-muted small">Peminjam</div>
      <div class="fw-semibold">{{ $return->user->name ?? '-' }}</div>
    </div>
    <div class="col-md-6">
      <div class="text-muted small">Alat</div>
      <div class="fw-semibold">{{ $return->device->name ?? '-' }}</div>
    </div>
    <div class="col-md-6">
      <div class="text-muted small">Periode Pinjam</div>
      <div class="fw-semibold">{{ $return->start_date }} s/d {{ $return->end_date ?? '-' }}</div>
    </div>
    <div class="col-md-6">
      <div class="text-muted small">Tanggal Pengembalian</div>
      <div class="fw-semibold">{{ $return->returned_at ? \Carbon\Carbon::parse($return->returned_at)->format('d-m-Y H:i') : '-' }}</div>
    </div>
    <div class="col-12">
      <div class="text-muted small">Catatan</div>
      <div class="fw-semibold">{{ $return->note ?: '-' }}</div>
    </div>
  </div>
</div>
@endsection
