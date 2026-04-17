@extends('layouts.admin')

@section('content')
<h2 class="page-title">✏️ Edit Alat</h2>

<div class="row">
  <div class="col-md-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.devices.update',$device) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="mb-3">
          <label class="form-label fw-600">Nama Alat</label>
          <input type="text" name="name" value="{{ $device->name }}" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Kategori</label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ (string) old('category_id', $device->category_id) === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
          @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Total Stok</label>
          <input type="number" min="0" name="stock" value="{{ old('stock', $device->stock) }}" class="form-control @error('stock') is-invalid @enderror" required>
          <small class="text-muted">Harus sama dengan jumlah stok baik, rusak ringan, dan rusak berat.</small>
          @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-600">Stok Baik</label>
            <input type="number" min="0" name="good_stock" value="{{ old('good_stock', $device->good_stock) }}" class="form-control @error('good_stock') is-invalid @enderror" required>
            @error('good_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-600">Rusak Ringan</label>
            <input type="number" min="0" name="minor_damage_stock" value="{{ old('minor_damage_stock', $device->minor_damage_stock) }}" class="form-control @error('minor_damage_stock') is-invalid @enderror" required>
            @error('minor_damage_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-600">Rusak Berat</label>
            <input type="number" min="0" name="major_damage_stock" value="{{ old('major_damage_stock', $device->major_damage_stock) }}" class="form-control @error('major_damage_stock') is-invalid @enderror" required>
            @error('major_damage_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Gambar Alat</label>
          <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control @error('image') is-invalid @enderror">
          <small class="text-muted">Upload gambar baru jika ingin mengganti gambar saat ini.</small>
          @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        @if($device->image)
          <div class="mb-3">
            <img src="{{ asset('storage/'.$device->image) }}" alt="{{ $device->name }}" style="width: 140px; height: 140px; object-fit: cover; border-radius: 12px;">
          </div>
        @endif

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Update
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
