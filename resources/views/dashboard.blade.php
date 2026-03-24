<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-stat {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 5px solid var(--secondary);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        .card-stat h6 {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .card-stat h3 {
            color: var(--primary);
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }
        .quick-action {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .quick-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            text-decoration: none;
            color: var(--secondary);
        }
        .quick-action-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .btn-custom {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .role-badge {
            display: inline-block;
            background: var(--secondary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 10px;
        }
        .welcome-box {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="/">
                📱 Peminjaman Alat 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link text-white fw-500">
                            {{ auth()->user()->name }}
                            <span class="role-badge">{{ strtoupper(auth()->user()->role) }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light btn-custom btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="container-fluid mt-5">
        <div class="welcome-box">
            <h1 class="mb-2">👋 Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="mb-0">Anda login sebagai <strong>{{ ucfirst(auth()->user()->role) }}</strong></p>
        </div>

        <!-- Admin Dashboard -->
        @if(auth()->user()->role === 'admin')
            <div class="row g-4 mb-5">
                <div class="col-md-3 col-sm-6">
                    <div class="card-stat">
                        <h6>Total User</h6>
                        <h3>{{ \App\Models\User::count() }}</h3>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card-stat" style="border-left-color: var(--success);">
                        <h6>Total Alat</h6>
                        <h3>{{ \App\Models\Device::count() }}</h3>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card-stat" style="border-left-color: var(--warning);">
                        <h6>Peminjaman</h6>
                        <h3>{{ \App\Models\Loan::count() }}</h3>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card-stat" style="border-left-color: var(--danger);">
                        <h6>Pending</h6>
                        <h3>{{ \App\Models\Loan::where('status','pending')->count() }}</h3>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">📋 Menu Admin</h4>
            <div class="row g-3 mb-5">
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('admin.dashboard') }}" class="quick-action">
                        <div class="quick-action-icon">📊</div>
                        <div><strong>Dashboard</strong></div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('admin.users.index') }}" class="quick-action">
                        <div class="quick-action-icon">👥</div>
                        <div><strong>Kelola User</strong></div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('admin.devices.index') }}" class="quick-action">
                        <div class="quick-action-icon">💻</div>
                        <div><strong>Kelola Alat</strong></div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('admin.categories.index') }}" class="quick-action">
                        <div class="quick-action-icon">🏷️</div>
                        <div><strong>Kategori</strong></div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('admin.loans.index') }}" class="quick-action">
                        <div class="quick-action-icon">📦</div>
                        <div><strong>Peminjaman</strong></div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('admin.activity_logs.index') }}" class="quick-action">
                        <div class="quick-action-icon">📝</div>
                        <div><strong>Log Aktivitas</strong></div>
                    </a>
                </div>
            </div>

        <!-- Petugas Dashboard -->
        @elseif(auth()->user()->role === 'petugas')
            <div class="row g-4 mb-5">
                <div class="col-md-4 col-sm-6">
                    <div class="card-stat">
                        <h6>Pending</h6>
                        <h3>{{ \App\Models\Loan::where('status','pending')->count() }}</h3>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card-stat" style="border-left-color: var(--success);">
                        <h6>Disetujui</h6>
                        <h3>{{ \App\Models\Loan::where('status','approved')->count() }}</h3>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card-stat" style="border-left-color: var(--warning);">
                        <h6>Dikembalikan</h6>
                        <h3>{{ \App\Models\Loan::where('status','returned')->count() }}</h3>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">📋 Menu Petugas</h4>
            <div class="row g-3 mb-5">
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('petugas.approvals') }}" class="quick-action">
                        <div class="quick-action-icon">📋</div>
                        <div><strong>Setujui Peminjaman</strong></div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('petugas.approvals') }}" class="quick-action">
                        <div class="quick-action-icon">✅</div>
                        <div><strong>Setujui/Tolak</strong></div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('petugas.returns') }}" class="quick-action">
                        <div class="quick-action-icon">🔄</div>
                        <div><strong>Pantau Pengembalian</strong></div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('petugas.report') }}" class="quick-action">
                        <div class="quick-action-icon">📊</div>
                        <div><strong>Cetak Laporan</strong></div>
                    </a>
                </div>
            </div>

        <!-- Peminjam Dashboard -->
        @else
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card-stat">
                        <h6>Alat Tersedia</h6>
                        <h3>{{ \App\Models\Device::where('status','available')->count() }}</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-stat" style="border-left-color: var(--warning);">
                        <h6>Peminjaman Saya</h6>
                        <h3>{{ \App\Models\Loan::where('user_id', auth()->id())->count() }}</h3>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">📋 Menu Peminjam</h4>
            <div class="row g-3 mb-5">
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('peminjam.devices') }}" class="quick-action">
                        <div class="quick-action-icon">💻</div>
                        <div><strong>Lihat Alat</strong></div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('peminjam.loans.create') }}" class="quick-action">
                        <div class="quick-action-icon">➕</div>
                        <div><strong>Ajukan Peminjaman</strong></div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('peminjam.returns') }}" class="quick-action">
                        <div class="quick-action-icon">↩️</div>
                        <div><strong>Mengembalikan Alat</strong></div>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
