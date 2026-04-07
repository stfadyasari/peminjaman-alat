<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Petugas - Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
      :root {
        --primary: #1e3a8a;
        --secondary: #3b82f6;
        --light-bg: #f5f7fb;
      }
      body {
        margin: 0;
        background: var(--light-bg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      .app-shell {
        min-height: 100vh;
        display: flex;
      }
      .sidebar {
        width: 270px;
        min-height: 100vh;
        position: sticky;
        top: 0;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: #fff;
        padding: 24px 0;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
      }
      .sidebar-brand,
      .sidebar-user {
        padding: 0 22px;
      }
      .sidebar-brand {
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255,255,255,0.16);
        margin-bottom: 18px;
      }
      .sidebar-brand h4,
      .sidebar-brand p {
        margin: 0;
      }
      .sidebar-brand p,
      .sidebar-user small {
        opacity: 0.8;
      }
      .sidebar .nav-link {
        color: rgba(255,255,255,0.85);
        padding: 12px 22px;
        border-left: 4px solid transparent;
        transition: 0.2s ease;
      }
      .sidebar .nav-link:hover,
      .sidebar .nav-link.active {
        background: rgba(255,255,255,0.12);
        border-left-color: #fff;
        color: #fff;
      }
      .main-content {
        flex: 1;
      }
      .topbar {
        background: #fff;
        padding: 18px 28px;
        box-shadow: 0 2px 14px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
      }
      .topbar h2 {
        margin: 0;
        color: var(--primary);
        font-size: 28px;
        font-weight: 700;
      }
      .user-badge {
        display: inline-block;
        background: var(--secondary);
        color: #fff;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
      }
      .content-wrap {
        padding: 28px;
      }
      .panel-card {
        border: 0;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
      }
      @media (max-width: 991px) {
        .app-shell {
          display: block;
        }
        .sidebar {
          width: 100%;
          min-height: auto;
          position: static;
        }
      }
    </style>
    @stack('styles')
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <div class="sidebar-brand">
          <h4>Menu Petugas</h4>
          <p>Sistem Peminjaman Alat</p>
        </div>

        <div class="sidebar-user mb-3">
          <div class="fw-semibold">{{ auth()->user()->name }}</div>
          <small>{{ auth()->user()->email }}</small>
          <div class="mt-2">
            <span class="user-badge">{{ strtoupper(auth()->user()->role) }}</span>
          </div>
        </div>

        <nav class="nav flex-column">
          <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid me-2"></i> Menu Petugas
          </a>
          <a href="{{ route('petugas.approvals') }}" class="nav-link {{ request()->routeIs('petugas.approvals') ? 'active' : '' }}">
            <i class="bi bi-check2-square me-2"></i> Setujui Peminjaman
          </a>
          <a href="{{ route('petugas.returns') }}" class="nav-link {{ request()->routeIs('petugas.returns') ? 'active' : '' }}">
            <i class="bi bi-arrow-repeat me-2"></i> Pantau Pengembalian
          </a>
          <a href="{{ route('petugas.report') }}" class="nav-link {{ request()->routeIs('petugas.report') ? 'active' : '' }}">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
          </a>
        </nav>
      </aside>

      <main class="main-content">
        <div class="topbar">
          <div>
            <h2>@yield('page_title', 'Petugas')</h2>
            <div class="text-muted">@yield('page_subtitle', 'Kelola proses peminjaman dan pengembalian')</div>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
        </div>

        <div class="content-wrap">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">Ada kesalahan validasi.</div>
          @endif

          @yield('content')
        </div>
      </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
  </body>
</html>
