@extends('layouts.admin')

@section('content')
<h2 class="page-title">🏷️ CRUD Kategori</h2>

<style>
  .category-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;
    white-space: nowrap;
  }

  .category-actions form {
    margin: 0;
  }

  .category-actions .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }
</style>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card p-4">
      <h5 style="font-weight: 700; margin-bottom: 20px;">➕ Tambah Kategori</h5>
      <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label fw-600">Nama Kategori</label>
          <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Ketik nama kategori"
            required
          >
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
          <label class="form-label fw-600">Deskripsi</label>
          <textarea
            name="description"
            rows="4"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Tulis deskripsi kategori"
          >{{ old('description') }}</textarea>
          @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <table class="table table-hover align-middle">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th class="text-nowrap">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $c)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><strong>{{ $c->name }}</strong></td>
              <td>{{ $c->description ?: '-' }}</td>
              <td class="text-nowrap">
                <div class="category-actions">
                  <a href="{{ route('admin.categories.show', $c) }}" class="btn btn-sm btn-info text-white">
                    <i class="bi bi-eye"></i> Detail
                  </a>
                  <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-warning text-dark">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                      <i class="bi bi-trash"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted p-4">Belum ada kategori</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
