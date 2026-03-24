@extends('layouts.admin')

@section('content')
<h2 class="page-title">Ubah Pengembalian</h2>

<div class="row">
  <div class="col-md-8 col-lg-6">
    <div class="card p-4">
      <form method="POST" action="{{ route('admin.returns.update', $return) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Peminjam</label>
          <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
            <option value="">Pilih Peminjam</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id', $return->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
          </select>
          @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Alat</label>
          <select name="device_id" class="form-select @error('device_id') is-invalid @enderror" required>
            <option value="">Pilih Alat</option>
            @foreach($devices as $device)
              <option value="{{ $device->id }}" {{ old('device_id', $return->device_id) == $device->id ? 'selected' : '' }}>{{ $device->name }}</option>
            @endforeach
          </select>
          @error('device_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Mulai Pinjam</label>
          <input type="date" name="start_date" value="{{ old('start_date', $return->start_date) }}" class="form-control @error('start_date') is-invalid @enderror" required>
          @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Selesai Pinjam</label>
          <input type="date" name="end_date" value="{{ old('end_date', $return->end_date) }}" class="form-control @error('end_date') is-invalid @enderror">
          @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Pengembalian</label>
          <input
            type="datetime-local"
            name="returned_at"
            value="{{ old('returned_at', optional($return->returned_at)->format('Y-m-d\\TH:i')) }}"
            class="form-control @error('returned_at') is-invalid @enderror"
            required
          >
          @error('returned_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Catatan</label>
          <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror">{{ old('note', $return->note) }}</textarea>
          @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Update
          </button>
          <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
