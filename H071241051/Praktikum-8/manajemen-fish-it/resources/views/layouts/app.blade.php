<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It Management System</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- Reset & Base --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #191B1F; /* Background gelap seperti Roblox */
            color: #E2E2E2;
            line-height: 1.6;
            padding-top: 80px; /* Memberi ruang untuk navbar */
        }
        h1, h2 {
            margin-bottom: 1.5rem;
            font-weight: 700;
            color: #FFFFFF;
        }
        a {
            color: #4B9DFF; /* Biru cerah untuk link */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        
        /* --- Layout --- */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #24272C; /* Kontainer konten */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* --- Navbar --- */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #1F2125; /* Navbar lebih gelap */
            padding: 1rem 2rem;
            border-bottom: 1px solid #363A40;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #FFFFFF;
        }
        .navbar-brand:hover {
            text-decoration: none;
            color: #FFFFFF;
        }
        .navbar-nav a {
            color: #E2E2E2;
            font-weight: 500;
            margin-left: 1.5rem;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .navbar-nav a:hover {
            color: #FFFFFF;
            text-decoration: none;
        }

        /* --- Tombol (Buttons) --- */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.25rem;
            border-radius: 8px; /* Sudut bulat */
            border: none;
            font-size: 0.9rem;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }
        .btn:hover {
            text-decoration: none;
            opacity: 0.85;
        }
        /* Warna tombol ala Roblox */
        .btn-primary {
            background-color: #02B163; /* Hijau Roblox */
            color: #FFFFFF;
        }
        .btn-secondary {
            background-color: #5A5D63; /* Abu-abu */
            color: #FFFFFF;
        }
        .btn-info {
            background-color: #00A2FF; /* Biru Cerah */
            color: #FFFFFF;
        }
        .btn-warning {
            background-color: #FBB03B; /* Kuning */
            color: #191B1F;
        }
        .btn-danger {
            background-color: #DA2F47; /* Merah Roblox */
            color: #FFFFFF;
        }
        
        /* --- Formulir (Forms) --- */
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #C3C3C3;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            background-color: #191B1F; /* Input gelap */
            border: 1px solid #363A40;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 1rem;
        }
        .form-control:focus {
            outline: none;
            border-color: #00A2FF;
            box-shadow: 0 0 0 3px rgba(0,162,255,0.2);
        }
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* --- Tabel (Tables) --- */
        .table-wrapper {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }
        .table th, .table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #363A40;
            text-align: left;
            vertical-align: middle;
        }
        .table th {
            background-color: #1F2125;
            font-weight: 700;
            color: #FFFFFF;
        }
        .table tbody tr:hover {
            background-color: #2A2D32;
        }
        .table td .btn { /* Tombol di dalam tabel lebih kecil */
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            margin-right: 5px;
        }
        
        /* --- Utilities --- */
        .mb-3 { margin-bottom: 1.5rem; }
        .mt-3 { margin-top: 1.5rem; }
        .d-inline { display: inline; }
        
        /* --- Alerts --- */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #02B163;
            color: #FFFFFF;
        }
        .alert-danger {
            background-color: #DA2F47;
            color: #FFFFFF;
        }

        /* --- Pagination --- */
        .pagination {
            margin-top: 2rem;
        }
        /* Style bawaan pagination Laravel */
        .pagination .page-item.active .page-link {
             background-color: #00A2FF;
             border-color: #00A2FF;
             color: #FFFFFF;
        }
        .pagination .page-link {
            background-color: #363A40;
            border-color: #5A5D63;
            color: #E2E2E2;
        }
        .pagination .page-link:hover {
            background-color: #5A5D63;
        }
        .pagination .page-item.disabled .page-link {
            color: #5A5D63;
            background-color: #1F2125;
            border-color: #363A40;
        }

        /* --- Halaman Detail --- */
        .fish-detail {
            line-height: 1.8;
        }
        .fish-detail strong {
            color: #FFFFFF;
            min-width: 150px;
            display: inline-block;
        }
        .fish-detail-desc {
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 3px solid #00A2FF;
            color: #C3C3C3;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('fishes.index') }}" class="navbar-brand">
            
            Fish It
        </a>
        <div class="navbar-nav">
            <a href="{{ route('fishes.index') }}">Daftar Ikan</a>
            <a href="{{ route('fishes.create') }}" class="btn btn-primary" style="margin-left: 1.5rem;">+ Tambah Ikan Baru</a>
        </div>
    </nav>

    <main>
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops! Ada masalah dengan input Anda:</strong>
                    <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>