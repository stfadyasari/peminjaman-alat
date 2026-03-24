@extends('layouts.admin')

@section('content')
<div class="mb-4">
  <h2 class="page-title mb-1">Log Aktivitas</h2>
  <p class="text-muted mb-0">Melihat aktivitas yang merekam semua kegiatan yang terjadi di sistem.</p>
</div>

<div class="card p-4">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
        <tr>
          <th>ID</th>
          <th>User</th>
          <th>Aksi</th>
          <th>Detail</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        @forelse($logs as $l)
        <tr>
          <td>#{{ $l->id }}</td>
          <td><strong>{{ optional($l->user)->name ?? 'System' }}</strong></td>
          <td><code style="background: #f5f7fb; padding: 4px 8px; border-radius: 4px;">{{ $l->action }}</code></td>
          <td>{{ $l->details ?? '-' }}</td>
          <td><small class="text-muted">{{ $l->created_at->format('d-m-Y H:i:s') }}</small></td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted p-4">Belum ada aktivitas</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4">
  {{ $logs->links() }}
</div>
@endsection

