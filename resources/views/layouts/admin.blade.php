<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin  - Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
      :root {
        --primary: #1e3a8a;
        --secondary: #3b82f6;
        --light-bg: #f5f7fb;
      }
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { background: var(--light-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
      .sidebar {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: #fff;
        padding: 20px 0;
        position: sticky;
        top: 0;
        width: 260px;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
      }
      .sidebar-brand {
        padding: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
      }
      .sidebar-brand h4 { font-weight: 700; font-size: 20px; margin: 0; }
      .sidebar-brand p { font-size: 12px; margin: 5px 0 0 0; opacity: 0.8; }
      .sidebar .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 12px 20px;
        border-left: 4px solid transparent;
        transition: all 0.3s;
        font-size: 14px;
      }
      .sidebar .nav-link:hover {
        background: rgba(255,255,255,0.1);
        border-left-color: #fff;
        color: #fff;
      }
      .sidebar .nav-link.active {
        background: rgba(255,255,255,0.15);
        border-left-color: #fff;
        color: #fff;
        font-weight: 600;
      }
      .sidebar .nav-section {
        color: rgba(255,255,255,0.5);
        padding: 15px 20px 8px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 15px;
      }
      .main-content {
        flex: 1;
        overflow-y: auto;
      }
      .topbar {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
      }
      .topbar h2 { font-weight: 700; color: var(--primary); margin: 0; }
      .topbar-right { display: flex; align-items: center; gap: 20px; }
      .user-info { display: flex; align-items: center; gap: 10px; }
      .user-badge {
        background: var(--secondary);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
      }
      .btn-logout { 
        background: #ef4444;
        border: 0;
        color: #fff;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.2s;
      }
      .btn-logout:hover { background: #dc2626; color: #fff; }
      .page-title { font-size: 28px; font-weight: 700; color: var(--primary); margin-bottom: 25px; }
      .card {
        border: 0;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
      }
      .card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
      @media (max-width: 768px) {
        .sidebar { width: 60px; }
        .sidebar-brand h4, .sidebar .nav-link, .sidebar .nav-section { display: none; }
        .sidebar { padding: 10px 0; }
      }
    </style>
  </head>
  <body>
    <div class="d-flex">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="sidebar-brand">
          <h4>📱 Admin</h4>
          <p>Admin </p>
        </div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          
          <div class="nav-section">Manajemen</div>
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
              <i class="bi bi-people-fill"></i> Kelola User
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.devices.index') }}" class="nav-link {{ request()->routeIs('admin.devices.*') ? 'active' : '' }}">
              <i class="bi bi-laptop"></i> CRUD Alat
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
              <i class="bi bi-tags-fill"></i> CRUD Kategori
            </a>
          </li>

          <div class="nav-section">Peminjaman</div>
          <li class="nav-item">
            <a href="{{ route('admin.loans.index') }}" class="nav-link {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}">
              <i class="bi bi-inbox"></i> CRUD Peminjaman
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.returns.index') }}" class="nav-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">
              <i class="bi bi-arrow-counterclockwise"></i> Pengembalian
            </a>
          </li>

          <div class="nav-section">Laporan</div>
          <li class="nav-item">
            <a href="{{ route('admin.activity_logs.index') }}" class="nav-link {{ request()->routeIs('admin.activity_logs.*') ? 'active' : '' }}">
              <i class="bi bi-clipboard-check"></i> Log Aktivitas
            </a>
          </li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
          <h2>Admin </h2>
          <div class="topbar-right">
            <div class="user-info">
              <span><i class="bi bi-person-circle" style="font-size: 20px;"></i></span>
              <div>
                <div style="font-weight: 600;">{{ auth()->user()->name }}</div>
                <div class="user-badge">{{ strtoupper(auth()->user()->role) }}</div>
              </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
              @csrf
              <button type="submit" class="btn btn-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
              </button>
            </form>
          </div>
        </div>

        <!-- Page Content -->
        <div style="padding: 0 30px 30px;">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle"></i> Ada kesalahan validasi
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif
          @yield('content')
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
