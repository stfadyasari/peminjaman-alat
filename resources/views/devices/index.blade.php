@extends('layouts.app')

@section('content')
<h3>Daftar Alat</h3>
<div class="row">
  @foreach($devices as $d)
  <div class="col-md-4 mb-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ $d->name }}</h5>
        <p class="card-text">Kategori: {{ optional($d->category)->name }}</p>
        <p>Status: {{ $d->status }}</p>
        @auth
          @if(auth()->user()->role === 'peminjam' && $d->status === 'available')
            <a href="{{ route('loans.create') }}" class="btn btn-primary">Pinjam</a>
          @endif
        @endauth
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
