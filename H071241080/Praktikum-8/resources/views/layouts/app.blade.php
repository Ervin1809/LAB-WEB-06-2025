<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Fish It Simulator')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <style>
        :root {
            --ocean-dark: #0a2463;
            --ocean-blue: #1e3a8a;
            --ocean-light: #3b82f6;
            --cyan-bright: #06b6d4;
            --cyan-light: #22d3ee;
            --wave-gradient: linear-gradient(135deg, #0a2463 0%, #1e3a8a 50%, #3b82f6 100%);
        }

        body {
            background: linear-gradient(to bottom, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar Styling */
        .navbar-ocean {
            background: var(--wave-gradient) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        /* Navbar Links */
        .navbar-nav .nav-link {
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .navbar-nav .nav-link:not(.btn-add-fish):hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link:not(.btn-add-fish).active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        .btn-add-fish {
            background: var(--cyan-bright) !important;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1.25rem !important;
        }

        .btn-add-fish:hover {
            background: var(--cyan-light) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);
        }

        /* Card Styling */
        .card-ocean {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .card-header-ocean {
            background: var(--wave-gradient) !important;
            color: white !important;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .card-header-ocean h5 {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Rarity Badges */
        .badge-common { background: #6b7280 !important; }
        .badge-uncommon { background: #10b981 !important; }
        .badge-rare { background: #3b82f6 !important; }
        .badge-epic { background: #8b5cf6 !important; }
        .badge-legendary { background: #f59e0b !important; }
        .badge-mythic { background: #ef4444 !important; }
        .badge-secret { 
            background: linear-gradient(135deg, #1f2937 0%, #6366f1 100%) !important;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        /* Button Enhancements */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-ocean {
            background: var(--ocean-blue);
            color: white;
            border: none;
        }

        .btn-ocean:hover {
            background: var(--ocean-light);
            color: white;
        }

        /* Container spacing */
        main {
            padding-bottom: 3rem;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease;
        }

        /* Pagination Styling - Override Tailwind */
        nav[role="navigation"] {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-top: 1.5rem;
        }

        nav[role="navigation"] > div {
            display: flex !important;
            gap: 0.5rem !important;
            align-items: center !important;
        }

        /* Hide mobile pagination text */
        nav[role="navigation"] .flex.justify-between.flex-1.sm\:hidden {
            display: none !important;
        }

        /* Show desktop pagination */
        nav[role="navigation"] .hidden.sm\:flex-1 {
            display: flex !important;
            width: 100% !important;
            justify-content: center !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 1rem !important;
        }

        /* Pagination text info */
        nav[role="navigation"] p {
            font-size: 0.875rem !important;
            color: #6b7280 !important;
            margin: 0 !important;
            text-align: center !important;
        }

        /* Fix spacing in text */
        nav[role="navigation"] p span {
            margin: 0 !important;
            padding: 0 0.15rem !important;
            font-weight: 600 !important;
            color: var(--ocean-blue) !important;
        }

        /* Pagination buttons container */
        nav[role="navigation"] > div > div:last-child {
            display: flex !important;
            gap: 0.25rem !important;
            align-items: center !important;
        }

        /* Pagination links */
        nav[role="navigation"] a,
        nav[role="navigation"] span {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0.375rem 0.625rem !important;
            margin: 0 !important;
            border-radius: 6px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            min-width: 2.25rem !important;
            font-size: 0.875rem !important;
        }

        /* Default link style */
        nav[role="navigation"] a {
            color: var(--ocean-blue) !important;
            background-color: white !important;
            border: 1px solid #dee2e6 !important;
        }

        /* Hover effect */
        nav[role="navigation"] a:hover {
            color: white !important;
            background-color: var(--cyan-bright) !important;
            border-color: var(--cyan-bright) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(6, 182, 212, 0.3) !important;
        }

        /* Active page */
        nav[role="navigation"] span[aria-current="page"] {
            background: var(--wave-gradient) !important;
            border: 1px solid var(--ocean-blue) !important;
            color: var(--ocean-blue) !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 8px rgba(10, 36, 99, 0.3) !important;
        }

        /* Disabled state (Previous/Next when not available) */
        nav[role="navigation"] span[aria-disabled="true"] {
            color: #9ca3af !important;
            background-color: #f3f4f6 !important;
            border: 1px solid #e5e7eb !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }

        /* SVG icons in pagination */
        nav[role="navigation"] svg {
            width: 0.875rem !important;
            height: 0.875rem !important;
        }

        /* Remove default Tailwind styles */
        nav[role="navigation"] .relative {
            position: static !important;
        }

        nav[role="navigation"] .z-0 {
            z-index: auto !important;
        }

        /* Make pagination more compact */
        nav[role="navigation"] .flex.justify-between {
            gap: 0.5rem !important;
        }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-ocean">
        <div class="container">
            <a class="navbar-brand" href="{{ route('fishes.index') }}">
                🐟 Fish It Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fishes.index') ? 'active' : '' }}" href="{{ route('fishes.index') }}">
                            Daftar Ikan
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link btn btn-add-fish text-white px-3" href="{{ route('fishes.create') }}">
                            + Tambah Ikan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Kontainer Utama -->
    <main class="container mt-4">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✓ Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>✕ Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>