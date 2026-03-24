@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <h3 class="text-xl font-semibold text-gray-200 mb-4">Ajukan Peminjaman</h3>

  <form method="POST" action="{{ route('loans.store') }}" class="bg-white/5 shadow-sm rounded-lg p-6">
    @csrf
    <div class="mb-4">
      <label class="block text-sm text-gray-300 mb-1">Pilih Alat</label>
      <select name="device_id" class="w-full bg-transparent border border-gray-700 rounded px-3 py-2 text-gray-200">
        @foreach($devices as $d)
          <option value="{{ $d->id }}">{{ $d->name }} - {{ optional($d->category)->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-300 mb-1">Tanggal Mulai</label>
        <input type="date" name="start_date" class="w-full bg-transparent border border-gray-700 rounded px-3 py-2 text-gray-200" required>
      </div>
      <div>
        <label class="block text-sm text-gray-300 mb-1">Tanggal Selesai</label>
        <input type="date" name="end_date" class="w-full bg-transparent border border-gray-700 rounded px-3 py-2 text-gray-200">
      </div>
    </div>
    <div class="mt-4">
      <label class="block text-sm text-gray-300 mb-1">Catatan</label>
      <textarea name="note" class="w-full bg-transparent border border-gray-700 rounded px-3 py-2 text-gray-200" rows="4"></textarea>
    </div>
    <div class="mt-4">
      <button class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Kirim Permohonan</button>
    </div>
  </form>
</div>
@endsection
