@extends('layouts.peminjam')

@section('page_title', 'Riwayat Peminjaman')
@section('page_subtitle', 'Melihat seluruh riwayat pengajuan dan status peminjaman alat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted">Lihat semua pengajuan peminjaman, status proses, dan detail alat yang pernah Anda ajukan.</div>
  <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary">
    Kembali ke Menu
  </a>
</div>

<div class="card panel-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Alat</th>
            <th class="px-4 py-3">Jumlah</th>
            <th class="px-4 py-3">Tanggal Pinjam</th>
            <th class="px-4 py-3">Batas Kembali</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Catatan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            <tr>
              <td class="px-4 py-3">{{ $loans->firstItem() + $loop->index }}</td>
              <td class="px-4 py-3">{{ $loan->device->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->quantity ?? 1 }} unit</td>
              <td class="px-4 py-3">{{ $loan->start_date }}</td>
              <td class="px-4 py-3">{{ $loan->end_date ?? '-' }}</td>
              <td class="px-4 py-3">
                <span class="badge text-bg-{{ $loan->statusBadgeClass() }}">
                  {{ $loan->statusLabel() }}
                </span>
              </td>
              <td class="px-4 py-3" style="white-space: pre-line;">{{ $loan->note ?: '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-5">Belum ada riwayat peminjaman yang bisa ditampilkan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3">
  {{ $loans->links() }}
</div>
@endsection
