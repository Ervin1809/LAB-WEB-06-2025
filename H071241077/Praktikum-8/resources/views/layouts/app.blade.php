<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It Simulator - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom, #eaf2ff 0%, #f5faff 100%);
            min-height: 100vh;
        }
        .bg-gradient-navbar {
            background: linear-gradient(135deg, #84a9ff, #b3c7ff);
        }
        .card-custom {
            border-radius: 20px;
            border: 3px solid #a2b7ff;
            overflow: hidden;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #8bb3ff, #b5a3ff);
            color: #2c3e7d;
            font-weight: bold;
            padding: 1rem 1.5rem;
        }
        .btn-tambah {
            background-color: #a6c1ff;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
        }
        .btn-tambah:hover {
            background-color: #8eaef0;
        }
        .btn-kuning { background-color: #ffd966; color: #2c3e7d; }
        .btn-biru { background-color: #5a9fff; color: white; }
        .btn-pink { background-color: #ff8fab; color: white; }
        .btn-abu { background-color: #9ca3af; color: white; }
        .form-control-custom, .form-select-custom {
            border: 2px solid #6b8cce;
            border-radius: 10px;
            padding: 10px 15px;
        }
        .table-header-custom {
            background: linear-gradient(135deg, #b8d4ff, #d4c5ff);
            color: #2c3e7d;
            font-weight: bold;
        }
        footer {
            background: linear-gradient(135deg, #8bb3ff, #b5a3ff);
            color: white;
            padding: 1rem;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-gradient-navbar mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('fishes.index') }}">
            🐠 Fish It Simulator
        </a>
    </div>
</nav>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<div class="container mb-5">
    @yield('content')
</div>

<footer>
  <div class="container-custom"> <div class="text-center">
      <p>&copy; {{ date('Y') }} FishIt Manager. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
