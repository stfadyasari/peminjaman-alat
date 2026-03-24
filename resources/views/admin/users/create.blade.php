@extends('layouts.admin')

@section('content')
<h2 class="page-title">➕ Tambah User Baru</h2>

<div class="row">
  <div class="col-md-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        
        <div class="mb-3">
          <label class="form-label fw-600">Nama</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Password</label>
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
          @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Role</label>
          <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="">Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="peminjam">Peminjam</option>
          </select>
          @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Simpan
          </button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
