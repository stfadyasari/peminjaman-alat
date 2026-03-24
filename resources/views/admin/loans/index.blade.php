@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="page-title mb-1">CRUD Peminjaman & Pengembalian</h2>
    <p class="text-muted mb-0">Memproses data pengajuan dari peminjam.</p>
  </div>
</div>

<div class="card p-4">
  <ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
        ⏳ Pending (<span class="badge bg-warning">{{ \App\Models\Loan::where('status','pending')->count() }}</span>)
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
        ✅ Disetujui (<span class="badge bg-success">{{ \App\Models\Loan::where('status','approved')->count() }}</span>)
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="returned-tab" data-bs-toggle="tab" data-bs-target="#returned" type="button" role="tab">
        ✔️ Dikembalikan (<span class="badge bg-info">{{ \App\Models\Loan::where('status','returned')->count() }}</span>)
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
        ❌ Ditolak (<span class="badge bg-danger">{{ \App\Models\Loan::where('status','rejected')->count() }}</span>)
      </button>
    </li>
  </ul>

  <div class="tab-content">
    <!-- Pending Tab -->
    <div class="tab-pane fade show active" id="pending" role="tabpanel">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Peminjam</th>
              <th>Alat</th>
              <th>Periode</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Loan::with(['user','device'])->where('status','pending')->get() as $loan)
            <tr>
              <td>#{{ $loan->id }}</td>
              <td>{{ $loan->user->name ?? '-' }}</td>
              <td>{{ $loan->device->name ?? '-' }}</td>
              <td>{{ $loan->start_date }} s/d {{ $loan->end_date }}</td>
              <td>
                <form method="POST" action="{{ route('admin.loans.approve',$loan) }}" style="display:inline;">
                  @csrf
                  <button class="btn btn-sm btn-success">✅ Setujui</button>
                </form>
                <form method="POST" action="{{ route('admin.loans.reject',$loan) }}" style="display:inline;">
                  @csrf
                  <button class="btn btn-sm btn-danger">❌ Tolak</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted p-4">Tidak ada peminjaman pending</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Approved Tab -->
    <div class="tab-pane fade" id="approved" role="tabpanel">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Peminjam</th>
              <th>Alat</th>
              <th>Periode</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Loan::with(['user','device'])->where('status','approved')->get() as $loan)
            <tr>
              <td>#{{ $loan->id }}</td>
              <td>{{ $loan->user->name ?? '-' }}</td>
              <td>{{ $loan->device->name ?? '-' }}</td>
              <td>{{ $loan->start_date }} s/d {{ $loan->end_date }}</td>
              <td>
                <form method="POST" action="{{ route('admin.loans.return',$loan) }}" style="display:inline;" onsubmit="return confirm('Tandai sebagai dikembalikan?')">
                  @csrf
                  <button class="btn btn-sm btn-info">🔄 Tandai Kembali</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted p-4">Tidak ada peminjaman yang disetujui</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Returned Tab -->
    <div class="tab-pane fade" id="returned" role="tabpanel">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Peminjam</th>
              <th>Alat</th>
              <th>Periode</th>
              <th>Dikembalikan</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Loan::with(['user','device'])->where('status','returned')->get() as $loan)
            <tr>
              <td>#{{ $loan->id }}</td>
              <td>{{ $loan->user->name ?? '-' }}</td>
              <td>{{ $loan->device->name ?? '-' }}</td>
              <td>{{ $loan->start_date }} s/d {{ $loan->end_date }}</td>
              <td>{{ $loan->returned_at ? \Carbon\Carbon::parse($loan->returned_at)->format('d-m-Y H:i') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted p-4">Tidak ada peminjaman yang dikembalikan</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Rejected Tab -->
    <div class="tab-pane fade" id="rejected" role="tabpanel">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background: #f5f7fb; border-bottom: 2px solid #e5e7eb;">
            <tr>
              <th>ID</th>
              <th>Peminjam</th>
              <th>Alat</th>
              <th>Periode</th>
              <th>Alasan</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Loan::with(['user','device'])->where('status','rejected')->get() as $loan)
            <tr>
              <td>#{{ $loan->id }}</td>
              <td>{{ $loan->user->name ?? '-' }}</td>
              <td>{{ $loan->device->name ?? '-' }}</td>
              <td>{{ $loan->start_date }} s/d {{ $loan->end_date }}</td>
              <td>{{ $loan->note ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted p-4">Tidak ada peminjaman yang ditolak</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

