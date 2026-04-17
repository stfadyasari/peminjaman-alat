<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Peminjaman Alat Laptop</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#081226',
                        ocean: '#0f4c81',
                        cyan: '#19a7ce',
                        mist: '#eef8ff',
                        coral: '#ff7a59',
                    },
                    boxShadow: {
                        glow: '0 25px 80px rgba(8, 18, 38, 0.18)',
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-slate-950 text-white font-sans antialiased">
    <div class="min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(25,167,206,0.22),_transparent_28%),radial-gradient(circle_at_top_right,_rgba(255,122,89,0.18),_transparent_24%),linear-gradient(180deg,_#06101f_0%,_#0a1930_46%,_#eff8ff_46%,_#eff8ff_100%)]">
        <header class="relative z-10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-10">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 shadow-lg shadow-cyan/20 backdrop-blur">
                        <svg class="h-6 w-6 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6.75A2.75 2.75 0 0 1 6.75 4h10.5A2.75 2.75 0 0 1 20 6.75v7.5A2.75 2.75 0 0 1 17.25 17H6.75A2.75 2.75 0 0 1 4 14.25v-7.5ZM9 20h6M10 17v3m4-3v3"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-extrabold tracking-tight">Sistem Peminjaman Alat</div>
                        <div class="text-sm text-white/60">Laptop dan perangkat pendukung</div>
                    </div>
                </div>

                <nav class="hidden items-center gap-3 sm:flex">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-white/15 px-5 py-2.5 text-sm font-semibold text-white transition hover:border-cyan hover:bg-white/5">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/15 px-5 py-2.5 text-sm font-semibold text-white transition hover:border-cyan hover:bg-white/5">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="rounded-full bg-coral px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-coral/30 transition hover:-translate-y-0.5 hover:bg-[#ff6845]">
                            Daftar Sekarang
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="relative">
            <section class="mx-auto grid max-w-7xl gap-12 px-6 pb-24 pt-8 lg:grid-cols-[1.15fr_0.85fr] lg:px-10 lg:pb-28 lg:pt-14">
                <div class="relative z-10">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold uppercase tracking-[0.28em] text-cyan backdrop-blur">
                        Platform Terintegrasi
                    </div>
                    <h1 class="max-w-3xl text-5xl font-extrabold leading-[1.02] tracking-tight text-white sm:text-6xl lg:text-7xl">
                        Peminjaman PPLG
                        <span class="block text-cyan">lebih cepat, rapi, dan mudah dipantau.</span>
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-white/72 sm:text-xl">
                        Kelola pengajuan alat, persetujuan petugas, pengembalian, dan laporan dalam satu sistem yang jelas untuk admin, petugas, dan peminjam.
                    </p>

                    <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan px-7 py-4 text-base font-bold text-slate-950 shadow-lg shadow-cyan/25 transition hover:-translate-y-0.5 hover:bg-[#36b5d6]">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan px-7 py-4 text-base font-bold text-slate-950 shadow-lg shadow-cyan/25 transition hover:-translate-y-0.5 hover:bg-[#36b5d6]">
                                Masuk ke Sistem
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/5 px-7 py-4 text-base font-semibold text-white transition hover:border-white/30 hover:bg-white/10">
                                Buat Akun Peminjam
                            </a>
                        @endauth
                    </div>

                    <div class="mt-12 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <div class="text-3xl font-extrabold text-cyan">3</div>
                            <div class="mt-2 text-sm font-semibold text-white">Role terhubung</div>
                            <div class="mt-1 text-sm text-white/60">Admin, petugas, dan peminjam</div>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <div class="text-3xl font-extrabold text-coral">24/7</div>
                            <div class="mt-2 text-sm font-semibold text-white">Akses online</div>
                            <div class="mt-1 text-sm text-white/60">Pantau status kapan saja</div>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <div class="text-3xl font-extrabold text-white">1</div>
                            <div class="mt-2 text-sm font-semibold text-white">Sistem terpusat</div>
                            <div class="mt-1 text-sm text-white/60">Pengajuan sampai laporan</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-x-10 top-10 h-56 rounded-full bg-cyan/25 blur-3xl"></div>
                    <div class="relative rounded-[2rem] border border-white/10 bg-white/10 p-4 shadow-glow backdrop-blur-xl">
                        <div class="rounded-[1.6rem] bg-[#071428] p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-white/50">Dashboard Ringkas</div>
                                    <div class="mt-1 text-2xl font-bold">Alur peminjaman modern</div>
                                </div>
                                <div class="rounded-2xl bg-cyan/15 px-4 py-2 text-sm font-semibold text-cyan">Aktif</div>
                            </div>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-3xl bg-white p-5 text-ink">
                                    <div class="text-sm font-semibold text-slate-500">Peminjam</div>
                                    <div class="mt-3 text-xl font-bold">Lihat alat dan ajukan pinjam</div>
                                    <div class="mt-2 text-sm leading-6 text-slate-500">Pilih alat tersedia, kirim pengajuan, dan pantau pengembalian.</div>
                                </div>
                                <div class="rounded-3xl bg-cyan p-5 text-slate-950">
                                    <div class="text-sm font-semibold text-slate-900/70">Petugas</div>
                                    <div class="mt-3 text-xl font-bold">Setujui, tolak, dan cetak laporan</div>
                                    <div class="mt-2 text-sm leading-6 text-slate-900/75">Fokus pada verifikasi peminjaman dan status pengembalian.</div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-3xl bg-white/5 p-5">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="text-sm font-semibold text-white">Status sistem</div>
                                    <div class="text-xs uppercase tracking-[0.24em] text-white/45">Realtime</div>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">
                                        <span class="text-sm text-white/75">Pengajuan peminjaman</span>
                                        <span class="rounded-full bg-amber-400/20 px-3 py-1 text-xs font-bold text-amber-300">Pending</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">
                                        <span class="text-sm text-white/75">Persetujuan petugas</span>
                                        <span class="rounded-full bg-emerald-400/20 px-3 py-1 text-xs font-bold text-emerald-300">Diproses</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">
                                        <span class="text-sm text-white/75">Pengembalian alat</span>
                                        <span class="rounded-full bg-sky-400/20 px-3 py-1 text-xs font-bold text-sky-300">Tercatat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-mist text-ink">
                <div class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
                    <div class="max-w-2xl">
                        <div class="text-sm font-bold uppercase tracking-[0.24em] text-ocean">Kenapa sistem ini lebih nyaman</div>
                        <h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Landing page yang bukan cuma bagus, tapi juga jelas arahnya.</h2>
                    </div>

                    <div class="mt-12 grid gap-6 lg:grid-cols-3">
                        <div class="rounded-[2rem] bg-white p-8 shadow-lg shadow-slate-200/70">
                            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-100 text-ocean">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7.5h18M6.75 4.5h10.5A2.25 2.25 0 0 1 19.5 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 17.25V6.75A2.25 2.25 0 0 1 6.75 4.5Z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold">Daftar alat lebih terarah</h3>
                            <p class="mt-3 text-base leading-7 text-slate-600">Pengguna bisa langsung memahami alat tersedia, status peminjaman, dan langkah berikutnya tanpa bingung.</p>
                        </div>

                        <div class="rounded-[2rem] bg-white p-8 shadow-lg shadow-slate-200/70">
                            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75 11.25 15 15 9.75m6 2.25A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold">Proses persetujuan rapi</h3>
                            <p class="mt-3 text-base leading-7 text-slate-600">Petugas dapat fokus pada setujui, tolak, pengembalian, dan laporan tanpa bercampur dengan menu lain.</p>
                        </div>

                        <div class="rounded-[2rem] bg-white p-8 shadow-lg shadow-slate-200/70">
                            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-100 text-coral">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold">Lebih hemat waktu</h3>
                            <p class="mt-3 text-base leading-7 text-slate-600">Semua peran punya jalur kerja sendiri sehingga layanan peminjaman terasa lebih cepat dan tertib.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white text-ink">
                <div class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
                    <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
                        <div>
                            <div class="text-sm font-bold uppercase tracking-[0.24em] text-ocean">Alur Sistem</div>
                            <h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Tiga langkah sederhana untuk menjalankan seluruh proses.</h2>
                        </div>

                        <div class="space-y-5">
                            <div class="rounded-[2rem] border border-slate-200 p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-ink text-lg font-extrabold text-white">1</div>
                                    <div>
                                        <h3 class="text-2xl font-bold">Peminjam memilih alat</h3>
                                        <p class="mt-2 text-slate-600">Masuk ke sistem, lihat daftar alat yang tersedia, lalu kirim pengajuan peminjaman sesuai kebutuhan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[2rem] border border-slate-200 p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-cyan text-lg font-extrabold text-slate-950">2</div>
                                    <div>
                                        <h3 class="text-2xl font-bold">Petugas memverifikasi</h3>
                                        <p class="mt-2 text-slate-600">Petugas meninjau pengajuan, menyetujui atau menolak, lalu memantau proses pengembalian alat.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[2rem] border border-slate-200 p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-coral text-lg font-extrabold text-white">3</div>
                                    <div>
                                        <h3 class="text-2xl font-bold">Admin memantau keseluruhan</h3>
                                        <p class="mt-2 text-slate-600">Admin mengelola user, alat, kategori, peminjaman, pengembalian, dan aktivitas sistem dari satu tempat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="px-6 pb-20 lg:px-10">
                <div class="mx-auto max-w-7xl rounded-[2.4rem] bg-ink px-8 py-12 text-white shadow-glow lg:px-12">
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                        <div class="max-w-2xl">
                            <div class="text-sm font-bold uppercase tracking-[0.24em] text-cyan">Siap Digunakan</div>
                            <h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Mulai pakai sistem peminjaman yang lebih modern hari ini.</h2>
                            <p class="mt-4 text-lg leading-8 text-white/68">Halaman depan sekarang lebih kuat sebagai pintu masuk sistem, lebih jelas untuk pengguna baru, dan lebih meyakinkan secara visual.</p>
                        </div>
                        <div class="flex flex-col gap-4 sm:flex-row">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan px-7 py-4 text-base font-bold text-slate-950 transition hover:bg-[#36b5d6]">
                                    Masuk Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan px-7 py-4 text-base font-bold text-slate-950 transition hover:bg-[#36b5d6]">
                                    Login Sekarang
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/15 px-7 py-4 text-base font-semibold text-white transition hover:bg-white/5">
                                    Buat Akun
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
