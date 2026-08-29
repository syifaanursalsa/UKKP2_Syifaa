<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pengaduan')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6f9; }

        /* Sidebar kiri */
        .sidebar { width: 250px; min-height: 100vh; background: #212529; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; }
        .sidebar .brand { padding: 1.1rem 1.2rem; color: #fff; font-weight: 700; border-bottom: 1px solid #343a40; }
        .sidebar a.menu { display: block; padding: .8rem 1.2rem; color: #adb5bd; text-decoration: none; }
        .sidebar a.menu:hover { background: #0d6efd; color: #fff; }
        .sidebar .footer { margin-top: auto; padding: 1rem 1.2rem; border-top: 1px solid #343a40; }

        /* Konten utama */
        .main { margin-left: 250px; padding: 1.5rem; }

        /* Responsive: layar kecil sidebar jadi di atas */
        @media (max-width: 768px) {
            .sidebar { width: 100%; min-height: auto; position: relative; }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

    @php $role = auth()->user()->role; @endphp

    <aside class="sidebar">
        <div class="brand">
            <i class=""></i>Sistem Pengaduan
        </div>

                        <nav>
            <a class="menu" href="{{ route($role . '.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>

            @if (in_array($role, ['admin', 'petugas']))
                <a class="menu" href="{{ route('users.index') }}">
                    <i class="bi bi-people me-2"></i>User
                </a>
                <a class="menu" href="{{ route('kelola.pengaduan') }}">
                    <i class="bi bi-clipboard-data me-2"></i>Kelola Pengaduan
                </a>
            @endif

            @if ($role == 'customer')
                <a class="menu" href="{{ route('pengaduan.index') }}">
                    <i class="bi bi-megaphone me-2"></i>Pengaduan
                </a>
            @endif

            <a class="menu" href="{{ route('profil') }}">
                <i class="bi bi-person-circle me-2"></i>Profile
            </a>
        </nav>

             
        <div class="footer">
            <div class="text-white small mb-2">
                {{ auth()->user()->nama }}
                <span class="badge text-bg-info ms-1">{{ ucfirst($role) }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>