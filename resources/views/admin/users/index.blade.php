@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="page-title">👥 Kelola User</h2>
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Tambah User
  </a>
</div>

<div class="card p-4">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td>#{{ $u->id }}</td>
          <td><strong>{{ $u->name }}</strong></td>
          <td>{{ $u->email }}</td>
          <td>
            <span class="badge" style="background: 
              @if($u->role === 'admin') #3b82f6
              @elseif($u->role === 'petugas') #f59e0b
              @else #10b981 @endif;">
              {{ ucfirst($u->role) }}
            </span>
          </td>
          <td>
            <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i> Edit
            </a>
            <form method="POST" action="{{ route('admin.users.destroy',$u) }}" style="display:inline;" onsubmit="return confirm('Hapus user ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted p-4">Belum ada user</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4">
  {{ $users->links() }}
</div>
@endsection
