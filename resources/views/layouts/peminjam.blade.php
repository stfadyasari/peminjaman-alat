<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjam - Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
      :root {
        --primary: #1d4ed8;
        --secondary: #3b82f6;
        --light-bg: #eff6ff;
      }
      body {
        margin: 0;
        background: linear-gradient(180deg, #f8fbff, var(--light-bg));
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
        background: linear-gradient(180deg, var(--primary), #1e40af);
        color: #fff;
        padding: 24px 0;
        box-shadow: 2px 0 18px rgba(29, 78, 216, 0.2);
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
      .sidebar .nav-link {
        color: rgba(255,255,255,0.88);
        padding: 12px 22px;
        border-left: 4px solid transparent;
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
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <div class="sidebar-brand">
          <h4 class="mb-1">Menu Peminjam</h4>
          <p class="mb-0 opacity-75">Sistem Peminjaman Alat</p>
        </div>

        <div class="sidebar-user mb-3">
          <div class="fw-semibold">{{ auth()->user()->name }}</div>
          <small>{{ auth()->user()->email }}</small>
          <div class="mt-2">
            <span class="user-badge">{{ strtoupper(auth()->user()->role) }}</span>
          </div>
        </div>

        <nav class="nav flex-column">
          <a href="{{ route('peminjam.dashboard') }}" class="nav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid me-2"></i> Menu Peminjam
          </a>
          <a href="{{ route('peminjam.devices') }}" class="nav-link {{ request()->routeIs('peminjam.devices') ? 'active' : '' }}">
            <i class="bi bi-laptop me-2"></i> Lihat Daftar Alat
          </a>
          <a href="{{ route('peminjam.loans.create') }}" class="nav-link {{ request()->routeIs('peminjam.loans.create') ? 'active' : '' }}">
            <i class="bi bi-journal-plus me-2"></i> Ajukan Peminjaman
          </a>
          <a href="{{ route('peminjam.loans.history') }}" class="nav-link {{ request()->routeIs('peminjam.loans.history') ? 'active' : '' }}">
            <i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman
          </a>
          <a href="{{ route('peminjam.returns') }}" class="nav-link {{ request()->routeIs('peminjam.returns*') ? 'active' : '' }}">
            <i class="bi bi-arrow-counterclockwise me-2"></i> Riwayat Pengembalian
          </a>
        </nav>
      </aside>

      <main class="main-content">
        <div class="topbar">
          <div>
            <h2>@yield('page_title', 'Peminjam')</h2>
            <div class="text-muted">@yield('page_subtitle', 'Kelola peminjaman alat Anda')</div>
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
