@extends('layouts.petugas')

@section('page_title', 'Setujui Peminjaman')
@section('page_subtitle', 'Menyetujui atau menolak pengajuan peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted">Pilih pengajuan dengan status pending untuk diproses.</div>
  <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu
  </a>
</div>

<div class="card panel-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Peminjam</th>
            <th class="px-4 py-3">Alat</th>
            <th class="px-4 py-3">Periode</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            <tr>
              <td class="px-4 py-3">#{{ $loan->id }}</td>
              <td class="px-4 py-3">{{ $loan->user->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->device->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->start_date }} s/d {{ $loan->end_date ?? '-' }}</td>
              <td class="px-4 py-3">
                <span class="badge text-bg-{{ $loan->status === 'pending' ? 'warning' : ($loan->status === 'approved' ? 'success' : 'danger') }}">
                  {{ ucfirst($loan->status) }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if($loan->status === 'pending')
                  <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('loans.approve', $loan) }}">
                      @csrf
                      <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('loans.reject', $loan) }}">
                      @csrf
                      <button type="submit" class="btn btn-outline-danger btn-sm">Tolak</button>
                    </form>
                  </div>
                @else
                  <span class="text-muted small">Sudah diproses</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-5">Belum ada data peminjaman.</td>
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
