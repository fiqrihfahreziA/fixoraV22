<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} | SIMRS RSMZ</title>
    <link rel="icon" href="{{ asset('gambar/rsmz.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --ink: #12262b;
            --muted: #5d7177;
            --line: #d9e3e4;
            --page: #f4f8f8;
            --teal-900: #0b3b45;
            --teal-700: #0e6a73;
            --teal-600: #118089;
            --teal-100: #dff0f0;

            /* Samakan warna "primary" Bootstrap agar halaman lain ikut berubah */
            --bs-primary: #0e6a73;
            --bs-primary-rgb: 14, 106, 115;
            --bs-link-color: #0e6a73;
            --bs-link-hover-color: #0b3b45;
            --bs-body-font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            --bs-body-color: var(--ink);
        }

        body { background: var(--page); min-height: 100vh; }

        /* ---------- Navbar ---------- */
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .topbar .navbar { padding-top: .7rem; padding-bottom: .7rem; }

        .brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            font-weight: 800;
            color: var(--teal-900);
            letter-spacing: -.01em;
        }
        .brand:hover { color: var(--teal-900); }
        .brand-mark {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--teal-900);
            display: grid; place-items: center;
        }
        .brand-mark svg { width: 20px; height: 20px; }

        .topbar .nav-link {
            color: var(--muted);
            font-weight: 600;
            font-size: .93rem;
            padding: .5rem .9rem;
            border-radius: 10px;
            transition: background .15s, color .15s;
        }
        .topbar .nav-link:hover { background: var(--page); color: var(--ink); }
        .topbar .nav-link.active { background: var(--teal-100); color: var(--teal-700); }

        .navbar-toggler { border: 1px solid var(--line); border-radius: 10px; padding: .4rem .6rem; }
        .navbar-toggler:focus { box-shadow: 0 0 0 4px rgba(17,128,137,.15); }

        /* ---------- Menu akun ---------- */
        .user-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 999px;
            padding: .3rem .85rem .3rem .3rem;
            font-weight: 600;
            font-size: .9rem;
            color: var(--ink);
        }
        .user-btn:hover, .user-btn.show { background: var(--page); }
        .avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--teal-700);
            color: #fff;
            display: grid; place-items: center;
            font-size: .8rem;
            font-weight: 700;
        }
        .dropdown-menu {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: .4rem;
            box-shadow: 0 12px 32px rgba(11,59,69,.12);
            min-width: 220px;
        }
        .dropdown-item { border-radius: 9px; padding: .55rem .75rem; font-size: .92rem; }
        .dropdown-item:hover { background: var(--page); }
        .dropdown-item.logout { color: #b42318; font-weight: 600; }
        .dropdown-item.logout:hover { background: #fef3f2; }
        .dropdown-header-info { padding: .5rem .75rem .6rem; border-bottom: 1px solid var(--line); margin-bottom: .35rem; }
        .dropdown-header-info small { color: var(--muted); display: block; }
        .dropdown-header-info strong { font-size: .95rem; }

        /* ---------- Konten ---------- */
        main.content { padding-top: 2rem; padding-bottom: 3rem; }

        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: none;
        }
        .table { --bs-table-bg: transparent; }
        .table > thead th {
            color: var(--muted);
            font-size: .85rem;
            font-weight: 600;
            border-bottom-color: var(--line);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border-color: var(--line);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--teal-600);
            box-shadow: 0 0 0 4px rgba(17,128,137,.15);
        }
        .btn { border-radius: 10px; font-weight: 600; }
        .btn-primary {
            --bs-btn-bg: #0e6a73;
            --bs-btn-border-color: #0e6a73;
            --bs-btn-hover-bg: #0b3b45;
            --bs-btn-hover-border-color: #0b3b45;
            --bs-btn-active-bg: #0b3b45;
            --bs-btn-active-border-color: #0b3b45;
            --bs-btn-disabled-bg: #0e6a73;
            --bs-btn-disabled-border-color: #0e6a73;
        }

        footer.site-foot {
            text-align: center;
            color: var(--muted);
            font-size: .82rem;
            padding: 0 0 2rem;
        }

        @media (max-width: 991.98px) {
            .topbar .navbar-collapse { padding-top: .75rem; }
            .user-btn { margin-top: .75rem; width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $namaUser = $authUser?->karyawan?->nama ?? 'Admin';
        $inisial  = strtoupper(mb_substr($namaUser, 0, 1));
    @endphp

    <!-- Navbar -->
    <header class="topbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand brand m-0" href="{{ route('admin.dashboard') }}">
                    <span class="brand-mark" aria-hidden="true" style="background: transparent !important; box-shadow: none !important; padding: 0;">
                        <img src="{{ asset('gambar/rsmz.png') }}" 
                            alt="Logo SIMRS RSMZ" 
                            width="28" 
                            height="28" 
                            style="object-fit: contain; background: transparent;">
                    </span>
                    SIMRS RSMZ
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Buka menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto ms-lg-4 mb-2 mb-lg-0 gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}" href="{{ route('admin.pengguna') }}">Data Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.karyawan*') ? 'active' : '' }}" href="{{ route('admin.karyawan') }}">Data Karyawan</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Laporan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pengaturan</a>
                        </li> -->
                    </ul>

                    <!-- Akun & logout -->
                    <div class="dropdown">
                        <button class="user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="avatar" aria-hidden="true">{{ $inisial }}</span>
                            <span class="text-truncate" style="max-width:140px">{{ $namaUser }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header-info">
                                <small>Masuk sebagai</small>
                                <strong>{{ $namaUser }}</strong>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <main class="container content">
        @yield('content')
    </main>

    <footer class="site-foot">&copy; {{ date('Y') }} SIMRS RSMZ</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>