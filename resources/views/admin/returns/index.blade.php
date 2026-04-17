@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="page-title mb-1">Data Pengembalian</h2>
    <p class="text-muted mb-0">Tambah dan lihat data pengembalian.</p>
  </div>
  <a href="{{ route('admin.returns.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Tambah Pengembalian
  </a>
</div>

<div class="card p-4">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
        <tr>
          <th>ID</th>
          <th>Peminjam</th>
          <th>Alat</th>
          <th>Kondisi</th>
          <th>Denda</th>
          <th>Tipe Denda</th>
          <th>Periode</th>
          <th>Tanggal Kembali</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($returns as $item)
        <tr>
          <td>{{ $returns->firstItem() + $loop->index }}</td>
          <td>{{ $item->user->name ?? '-' }}</td>
          <td>{{ $item->device->name ?? '-' }}</td>
          <td class="text-capitalize">{{ $item->return_condition ?: '-' }}</td>
          <td>Rp {{ number_format((float) ($item->fine_amount ?? 0), 0, ',', '.') }}</td>
          <td>{{ $item->fineTypeLabel() }}</td>
          <td>{{ $item->start_date }} s/d {{ $item->end_date ?? '-' }}</td>
          <td>{{ $item->returned_at ? \Carbon\Carbon::parse($item->returned_at)->format('d-m-Y H:i') : '-' }}</td>
          <td>
            <a href="{{ route('admin.returns.show', $item) }}" class="btn btn-sm btn-info">
              <i class="bi bi-eye"></i> Lihat
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center text-muted p-4">Belum ada data pengembalian</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4">
  {{ $returns->links() }}
</div>
@endsection
