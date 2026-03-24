@extends('layouts.admin')

@section('content')
<h2 class="page-title">🏷️ CRUD Kategori</h2>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card p-4">
      <h5 style="font-weight: 700; margin-bottom: 20px;">➕ Tambah Kategori</h5>
      <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label fw-600">Nama Kategori</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Laptop, Monitor" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-plus-circle"></i> Tambah
        </button>
      </form>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card p-4">
      <h5 style="font-weight: 700; margin-bottom: 20px;">📋 Daftar Kategori</h5>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Jumlah Alat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $c)
            <tr>
              <td>#{{ $c->id }}</td>
              <td><strong>{{ $c->name }}</strong></td>
              <td><span class="badge bg-secondary">{{ $c->devices->count() }} alat</span></td>
              <td>
                <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted p-4">Belum ada kategori</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
