@extends('layouts.admin')

@section('content')
<h2 class="page-title">Edit Kategori</h2>

<div class="row">
  <div class="col-md-7 col-lg-6">
    <div class="card p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <h5 style="font-weight: 700; margin-bottom: 6px;">Perbarui Data Kategori</h5>
          <p class="text-muted mb-0">Kategori ini memiliki {{ $category->devices_count }} alat.</p>
        </div>
      </div>

      <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label fw-600">Nama Kategori</label>
          <input
            type="text"
            name="name"
            value="{{ old('name', $category->name) }}"
            class="form-control @error('name') is-invalid @enderror"
            required
          >
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Deskripsi</label>
          <textarea
            name="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Tulis deskripsi kategori"
          >{{ old('description', $category->description) }}</textarea>
          @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Update
          </button>
          <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info text-white">
            <i class="bi bi-eye"></i> Detail
          </a>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
