@extends('layouts.peminjam')

@section('page_title', 'Detail Riwayat Pengembalian')
@section('page_subtitle', 'Melihat detail pinjaman dan pengembalian alat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="text-muted">Halaman ini hanya untuk melihat riwayat. Pengembalian alat diproses oleh petugas atau admin.</div>
  <a href="{{ route('peminjam.returns') }}" class="btn btn-outline-secondary">
    Kembali
  </a>
</div>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card panel-card">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Data Peminjaman</h5>
        <div class="mb-3">
          <div class="text-muted small">ID Peminjaman</div>
          <div class="fw-semibold">#{{ $loan->id }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Nama Alat</div>
          <div class="fw-semibold">{{ $loan->device->name ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Jumlah Dipinjam</div>
          <div class="fw-semibold">{{ $loan->quantity ?? 1 }} unit</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Kategori</div>
          <div class="fw-semibold">{{ $loan->device->category->name ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Tanggal Pinjam</div>
          <div class="fw-semibold">{{ $loan->start_date }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Batas Kembali</div>
          <div class="fw-semibold">{{ $loan->end_date ?? '-' }}</div>
        </div>
        <div>
          <div class="text-muted small">Status</div>
          <div class="fw-semibold">
            <span class="badge text-bg-{{ $loan->statusBadgeClass() }}">
              {{ $loan->statusLabel() }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card panel-card">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Detail Pengembalian</h5>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="text-muted small">Kondisi Barang</div>
            <div class="fw-semibold text-capitalize">{{ $loan->return_condition ?: '-' }}</div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small">Tanggal Pengembalian</div>
            <div class="fw-semibold">{{ optional($loan->returned_at)->format('d-m-Y H:i') ?? '-' }}</div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small">Denda</div>
            <div class="fw-semibold">Rp {{ number_format((float) ($loan->fine_amount ?? 0), 0, ',', '.') }}</div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small">Tipe Denda</div>
            <div class="fw-semibold">{{ $loan->fineTypeLabel() }}</div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small">Metode Pembayaran</div>
            <div class="fw-semibold">{{ $loan->paymentMethodLabel() }}</div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small">Estimasi Denda Keterlambatan</div>
            <div class="fw-semibold">Rp {{ number_format($automaticFineAmount, 0, ',', '.') }}</div>
            <div class="text-muted small">Terlambat {{ $lateDays }} hari</div>
          </div>
          <div class="col-12">
            <div class="text-muted small">Catatan</div>
            <div class="fw-semibold" style="white-space: pre-line;">{{ $loan->note ?: '-' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
