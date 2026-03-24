@extends('layouts.petugas')

@section('page_title', 'Cetak Laporan')
@section('page_subtitle', 'Mencetak laporan peminjaman dan pengembalian')

@push('styles')
<style>
  @media print {
    .sidebar,
    .topbar,
    .no-print {
      display: none !important;
    }
    .main-content,
    .content-wrap {
      padding: 0 !important;
      margin: 0 !important;
    }
    .panel-card {
      box-shadow: none !important;
    }
  }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 no-print">
  <div class="text-muted">Cetak laporan dari browser setelah data ditinjau.</div>
  <div class="d-flex gap-2">
    <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu
    </a>
    <button type="button" onclick="window.print()" class="btn btn-dark">
      <i class="bi bi-printer me-1"></i> Cetak Sekarang
    </button>
  </div>
</div>

<div class="card panel-card mb-4">
  <div class="card-body">
    <h4 class="fw-bold mb-3">Laporan Peminjaman Alat</h4>
    <p class="text-muted mb-4">Tanggal cetak: {{ now()->format('d-m-Y H:i') }}</p>

    <div class="row g-3">
      <div class="col-md-3">
        <div class="border rounded-3 p-3 h-100">
          <div class="text-muted small text-uppercase fw-semibold">Pending</div>
          <div class="fs-3 fw-bold text-warning">{{ $pendingCount }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="border rounded-3 p-3 h-100">
          <div class="text-muted small text-uppercase fw-semibold">Disetujui</div>
          <div class="fs-3 fw-bold text-success">{{ $approvedCount }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="border rounded-3 p-3 h-100">
          <div class="text-muted small text-uppercase fw-semibold">Dikembalikan</div>
          <div class="fs-3 fw-bold text-primary">{{ $returnedCount }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="border rounded-3 p-3 h-100">
          <div class="text-muted small text-uppercase fw-semibold">Ditolak</div>
          <div class="fs-3 fw-bold text-danger">{{ $rejectedCount }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card panel-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Peminjam</th>
            <th class="px-4 py-3">Alat</th>
            <th class="px-4 py-3">Tanggal Pinjam</th>
            <th class="px-4 py-3">Tanggal Kembali</th>
            <th class="px-4 py-3">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            <tr>
              <td class="px-4 py-3">#{{ $loan->id }}</td>
              <td class="px-4 py-3">{{ $loan->user->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->device->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->start_date }}</td>
              <td class="px-4 py-3">{{ $loan->returned_at ? $loan->returned_at->format('d-m-Y H:i') : ($loan->end_date ?? '-') }}</td>
              <td class="px-4 py-3">{{ ucfirst($loan->status) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-5">Belum ada data untuk dicetak.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
