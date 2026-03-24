@extends('layouts.petugas')

@section('page_title', 'Pantau Pengembalian')
@section('page_subtitle', 'Memantau status pengembalian alat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted">Lihat status pengembalian dan tandai yang sudah kembali.</div>
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
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Tanggal Kembali</th>
            <th class="px-4 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            <tr>
              <td class="px-4 py-3">#{{ $loan->id }}</td>
              <td class="px-4 py-3">{{ $loan->user->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->device->name ?? '-' }}</td>
              <td class="px-4 py-3">
                <span class="badge text-bg-{{ $loan->status === 'returned' ? 'primary' : 'success' }}">
                  {{ ucfirst($loan->status) }}
                </span>
              </td>
              <td class="px-4 py-3">{{ optional($loan->returned_at)->format('d-m-Y H:i') ?? '-' }}</td>
              <td class="px-4 py-3">
                @if($loan->status === 'approved')
                  <form method="POST" action="{{ route('loans.return', $loan) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Tandai Sudah Kembali</button>
                  </form>
                @else
                  <span class="text-muted small">Selesai</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-5">Belum ada data pengembalian.</td>
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
