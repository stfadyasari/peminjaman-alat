@extends('layouts.admin')

@section('content')
<h2 class="page-title">➕ Tambah Alat Baru</h2>

<div class="row">
  <div class="col-md-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.devices.store') }}">
        @csrf
        
        <div class="mb-3">
          <label class="form-label fw-600">Nama Alat</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Nomor Serial</label>
          <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror">
          @error('serial_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Kategori</label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
          </select>
          @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Kondisi</label>
          <textarea name="condition" class="form-control @error('condition') is-invalid @enderror" rows="3"></textarea>
          @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
