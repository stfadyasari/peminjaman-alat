<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Log Aktivitas</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; color: #1f2937; font-size: 12px; }
    h1 { margin: 0 0 8px; font-size: 22px; }
    .meta { margin-bottom: 18px; color: #4b5563; }
    .meta p { margin: 0 0 4px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
    th { background: #eff6ff; }
    .empty { text-align: center; color: #6b7280; padding: 18px; }
  </style>
</head>
<body>
  <h1>Laporan Log Aktivitas</h1>
  <div class="meta">
    <p>Total data: {{ $logs->count() }}</p>
    <p>Digenerate pada: {{ $generatedAt->format('d-m-Y H:i:s') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Aksi</th>
        <th>Detail</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      @forelse($logs as $log)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ optional($log->user)->name ?? 'System' }}</td>
        <td>{{ $log->action }}</td>
        <td>{{ $log->details ?? '-' }}</td>
        <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="empty">Belum ada aktivitas.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
