@extends('layouts.admin')

@section('content')
<h2 class="page-title">Detail Kategori</h2>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card p-4 h-100">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <p class="text-muted mb-1">Kategori</p>
          <h4 style="font-weight: 700; margin-bottom: 0;">{{ $category->name }}</h4>
        </div>
        <span class="badge bg-primary">{{ $category->devices->count() }} alat</span>
      </div>

      <div class="mb-3">
        <div class="text-muted small mb-1">Deskripsi</div>
        <div>{{ $category->description ?: 'Belum ada deskripsi kategori.' }}</div>
      </div>

      <div class="mb-4">
        <div class="text-muted small mb-1">Dibuat</div>
        <div>{{ $category->created_at?->format('d M Y H:i') }}</div>
      </div>

      <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning text-dark">
          <i class="bi bi-pencil-square"></i> Edit
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card p-4">
      <h5 style="font-weight: 700; margin-bottom: 20px;">Daftar Alat Dalam Kategori</h5>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Nama Alat</th>
              <th>Stok Tersedia</th>
              <th>Baik</th>
              <th>Rusak Ringan</th>
              <th>Rusak Berat</th>
            </tr>
          </thead>
          <tbody>
            @forelse($category->devices as $device)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $device->name }}</td>
              <td>{{ $device->available_stock }}</td>
              <td>{{ $device->good_stock }}</td>
              <td>{{ $device->minor_damage_stock }}</td>
              <td>{{ $device->major_damage_stock }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted p-4">Belum ada alat di kategori ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
