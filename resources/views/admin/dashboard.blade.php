@extends('layouts.admin')

@section('content')
<div class="row g-4">
  <!-- Left Sidebar Menu -->
  <div class="col-lg-3">
    <div class="card p-0 overflow-hidden mb-4" style="border: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
      <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.2);">
        <h5 style="margin: 0; font-weight: 700;">📋 MENU CRUD</h5>
      </div>
      <div class="list-group list-group-flush">
        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action py-3 px-4" style="border: 0; border-bottom: 1px solid #e5e7eb;">
          <i class="bi bi-people-fill" style="color: #3b82f6; margin-right: 10px;"></i>
          <strong>Kelola User</strong>
          <span class="badge bg-secondary float-end">{{ \App\Models\User::count() }}</span>
        </a>
        <a href="{{ route('admin.devices.index') }}" class="list-group-item list-group-item-action py-3 px-4" style="border: 0; border-bottom: 1px solid #e5e7eb;">
          <i class="bi bi-laptop" style="color: #10b981; margin-right: 10px;"></i>
          <strong>CRUD Alat</strong>
          <span class="badge bg-secondary float-end">{{ \App\Models\Device::count() }}</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action py-3 px-4" style="border: 0; border-bottom: 1px solid #e5e7eb;">
          <i class="bi bi-tags-fill" style="color: #f59e0b; margin-right: 10px;"></i>
          <strong>CRUD Kategori</strong>
          <span class="badge bg-secondary float-end">{{ \App\Models\Category::count() }}</span>
        </a>
        <a href="{{ route('admin.loans.index') }}" class="list-group-item list-group-item-action py-3 px-4" style="border: 0; border-bottom: 1px solid #e5e7eb;">
          <i class="bi bi-inbox" style="color: #ef4444; margin-right: 10px;"></i>
          <strong>CRUD Peminjaman</strong>
          <span class="badge bg-secondary float-end">{{ \App\Models\Loan::count() }}</span>
        </a>
        <a href="{{ route('admin.returns.index') }}" class="list-group-item list-group-item-action py-3 px-4" style="border: 0; border-bottom: 1px solid #e5e7eb;">
          <i class="bi bi-arrow-counterclockwise" style="color: #8b5cf6; margin-right: 10px;"></i>
          <strong>Pengembalian</strong>
          <span class="badge bg-secondary float-end">{{ \App\Models\Loan::where('status','returned')->count() }}</span>
        </a>
        <a href="{{ route('admin.activity_logs.index') }}" class="list-group-item list-group-item-action py-3 px-4" style="border: 0;">
          <i class="bi bi-clipboard-check" style="color: #06b6d4; margin-right: 10px;"></i>
          <strong>Log Aktivitas</strong>
        </a>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="card p-3" style="border: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 5px solid #3b82f6;">
      <h6 style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 10px;">Statistik Cepat</h6>
      <div class="mb-2">
        <small class="text-muted">Total User</small>
        <h4 style="color: #1e3a8a; margin: 5px 0;">{{ \App\Models\User::count() }}</h4>
      </div>
      <div class="mb-2">
        <small class="text-muted">Total Alat</small>
        <h4 style="color: #1e3a8a; margin: 5px 0;">{{ \App\Models\Device::count() }}</h4>
      </div>
      <div>
        <small class="text-muted">Total Peminjaman</small>
        <h4 style="color: #1e3a8a; margin: 5px 0;">{{ \App\Models\Loan::count() }}</h4>
      </div>
    </div>
  </div>

  <!-- Right Content Area -->
  <div class="col-lg-9">
    <!-- Header Stats -->
    <div class="row g-3 mb-4">
      <div class="col-sm-6 col-md-3">
        <div class="card p-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total User</p>
              <h3 style="color: #3b82f6; font-weight: 700; margin: 0;">{{ \App\Models\User::count() }}</h3>
            </div>
            <div style="font-size: 40px;">👥</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card p-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Alat</p>
              <h3 style="color: #10b981; font-weight: 700; margin: 0;">{{ \App\Models\Device::count() }}</h3>
            </div>
            <div style="font-size: 40px;">💻</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card p-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Peminjaman</p>
              <h3 style="color: #f59e0b; font-weight: 700; margin: 0;">{{ \App\Models\Loan::count() }}</h3>
            </div>
            <div style="font-size: 40px;">📦</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card p-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Pending</p>
              <h3 style="color: #ef4444; font-weight: 700; margin: 0;">{{ \App\Models\Loan::where('status','pending')->count() }}</h3>
            </div>
            <div style="font-size: 40px;">⏳</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Data Tables -->
    <div class="row g-4">
      <div class="col-12">
        <div class="card p-4">
          <h5 style="font-weight: 700; margin-bottom: 15px;">📊 Peminjaman Terakhir</h5>
          <div class="table-responsive">
            <table class="table table-sm table-hover">
              <thead style="background: #f5f7fb;">
                <tr>
                  <th>ID</th>
                  <th>Peminjam</th>
                  <th>Alat</th>
                  <th>Periode</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse(\App\Models\Loan::with(['user','device'])->latest()->limit(5)->get() as $loan)
                <tr>
                  <td>#{{ $loan->id }}</td>
                  <td>{{ $loan->user->name ?? '-' }}</td>
                  <td>{{ $loan->device->name ?? '-' }}</td>
                  <td>{{ $loan->start_date }} - {{ $loan->end_date }}</td>
                  <td>
                    <span class="badge" style="background: 
                      @if($loan->status === 'pending') #fbbf24
                      @elseif($loan->status === 'approved') #34d399
                      @elseif($loan->status === 'returned') #60a5fa
                      @else #ef4444 @endif;">
                      {{ ucfirst($loan->status) }}
                    </span>
                  </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted p-3">Belum ada data</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card p-4">
          <h5 style="font-weight: 700; margin-bottom: 15px;">🆕 User Terbaru</h5>
          <div class="table-responsive">
            <table class="table table-sm table-hover">
              <thead style="background: #f5f7fb;">
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody>
                @forelse(\App\Models\User::latest()->limit(5)->get() as $user)
                <tr>
                  <td>#{{ $user->id }}</td>
                  <td><strong>{{ $user->name }}</strong></td>
                  <td>{{ $user->email }}</td>
                  <td><span class="badge bg-secondary">{{ ucfirst($user->role) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted p-3">Belum ada user</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
