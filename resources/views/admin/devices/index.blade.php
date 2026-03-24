@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="page-title">💻 CRUD Alat</h2>
  <a href="{{ route('admin.devices.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Tambah Alat
  </a>
</div>

<div class="card p-4">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Serial</th>
          <th>Kategori</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($devices as $d)
        <tr>
          <td>#{{ $d->id }}</td>
          <td><strong>{{ $d->name }}</strong></td>
          <td><code>{{ $d->serial_number ?? '-' }}</code></td>
          <td>{{ optional($d->category)->name ?? '-' }}</td>
          <td>
            <span class="badge" style="background: 
              @if($d->status === 'available') #10b981
              @elseif($d->status === 'borrowed') #f59e0b
              @elseif($d->status === 'reserved') #3b82f6
              @else #ef4444 @endif;">
              {{ ucfirst($d->status) }}
            </span>
          </td>
          <td>
            <a href="{{ route('admin.devices.edit',$d) }}" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i> Edit
            </a>
            <form method="POST" action="{{ route('admin.devices.destroy',$d) }}" style="display:inline;" onsubmit="return confirm('Hapus alat ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted p-4">Belum ada alat</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4">
  {{ $devices->links() }}
</div>
@endsection
