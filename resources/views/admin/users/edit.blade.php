@extends('layouts.admin')

@section('content')
<h2 class="page-title">✏️ Edit User</h2>

<div class="row">
  <div class="col-md-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.users.update',$user) }}">
        @csrf @method('PUT')
        
        <div class="mb-3">
          <label class="form-label fw-600">Nama</label>
          <input type="text" name="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Email</label>
          <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" required>
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Password (kosongkan jika tidak ganti)</label>
          <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label fw-600">Role</label>
          <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="">Pilih Role</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
            <option value="peminjam" {{ $user->role === 'peminjam' ? 'selected' : '' }}>Peminjam</option>
          </select>
          @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Update
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
