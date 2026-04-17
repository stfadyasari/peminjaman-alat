@extends('layouts.admin')

@section('content')
<h2 class="page-title">➕ Tambah Alat Baru</h2>

<div class="row">
  <div class="col-md-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.devices.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
          <label class="form-label fw-600">Nama Alat</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Kategori</label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ (string) old('category_id') === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
          @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Total Stok</label>
          <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" class="form-control @error('stock') is-invalid @enderror" required>
          <small class="text-muted">Harus sama dengan jumlah stok baik, rusak ringan, dan rusak berat.</small>
          @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-600">Stok Baik</label>
            <input type="number" min="0" name="good_stock" value="{{ old('good_stock', 0) }}" class="form-control @error('good_stock') is-invalid @enderror" required>
            @error('good_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-600">Rusak Ringan</label>
            <input type="number" min="0" name="minor_damage_stock" value="{{ old('minor_damage_stock', 0) }}" class="form-control @error('minor_damage_stock') is-invalid @enderror" required>
            @error('minor_damage_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-600">Rusak Berat</label>
            <input type="number" min="0" name="major_damage_stock" value="{{ old('major_damage_stock', 0) }}" class="form-control @error('major_damage_stock') is-invalid @enderror" required>
            @error('major_damage_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Gambar Alat</label>
          <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control @error('image') is-invalid @enderror">
          <small class="text-muted">Format: JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
          @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Simpan
          </button>
          <a href="{{ route('admin.devices.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
