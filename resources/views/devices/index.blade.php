@extends('layouts.app')

@section('content')
<h3>Daftar Alat</h3>
<div class="row">
  @foreach($devices as $d)
  <div class="col-md-4 mb-3">
    <div class="card">
      @if($d->image)
        <img src="{{ asset('storage/'.$d->image) }}" class="card-img-top" alt="{{ $d->name }}" style="height: 220px; object-fit: cover;">
      @endif
      <div class="card-body">
        <h5 class="card-title">{{ $d->name }}</h5>
        <p class="card-text">Kategori: {{ optional($d->category)->name }}</p>
        <p class="card-text">Stok tersedia: {{ $d->available_stock }}</p>
        <p class="card-text">Baik: {{ $d->good_stock }}</p>
        <p class="card-text">Rusak ringan: {{ $d->minor_damage_stock }}</p>
        <p class="card-text">Rusak berat: {{ $d->major_damage_stock }}</p>
        <p>Status: {{ $d->available_stock > 0 ? 'Tersedia' : 'Tidak tersedia' }}</p>
        @auth
          @if(auth()->user()->role === 'peminjam' && $d->available_stock > 0)
            <a href="{{ route('loans.create') }}" class="btn btn-primary">Pinjam</a>
          @endif
        @endauth
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
