@extends('layouts.peminjam')

@section('page_title', 'Mengembalikan Alat')
@section('page_subtitle', 'Melihat status pengembalian alat milik Anda')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted">Tandai alat sebagai sudah dikembalikan jika peminjaman telah selesai.</div>
  <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary">
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
            <th class="px-4 py-3">Alat</th>
            <th class="px-4 py-3">Tanggal Pinjam</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            <tr>
              <td class="px-4 py-3">#{{ $loan->id }}</td>
              <td class="px-4 py-3">{{ $loan->device->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->start_date }}</td>
              <td class="px-4 py-3">
                <span class="badge text-bg-{{ $loan->status === 'returned' ? 'primary' : 'success' }}">
                  {{ ucfirst($loan->status) }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if($loan->status === 'approved')
                  <form method="POST" action="{{ route('loans.return', $loan) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning text-white btn-sm">Kembalikan Alat</button>
                  </form>
                @else
                  <span class="text-muted small">Sudah dikembalikan</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-5">Belum ada alat untuk dikembalikan.</td>
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
