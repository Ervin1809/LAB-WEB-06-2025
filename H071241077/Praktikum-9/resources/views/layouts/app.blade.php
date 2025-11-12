<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Product Management')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --brown-1:#4b2e2e;
      --brown-2:#8b6f47;
      --brown-3:#d2b48c;
      --card:#fffaf0;
    }
    body{
      min-height:100vh;
      display:flex;
      flex-direction:column;
      background: linear-gradient(135deg,var(--brown-3),var(--brown-2));
      color:var(--brown-1);
    }
    .navbar{
      background: linear-gradient(90deg,var(--brown-2),var(--brown-1));
    }
    .navbar .nav-link, .navbar-brand { color: #fff !important; }
    .card{
      background: var(--card);
      border-radius:12px;
    }
    footer{
      margin-top:auto;
      padding:12px 0;
      background: linear-gradient(90deg,var(--brown-1),var(--brown-2));
      color:#fff;
      text-align:center;
    }
    .btn-brown{
      background: linear-gradient(90deg,var(--brown-1),var(--brown-2));
      color:#fff;
      border: none;
    }
    .table thead th { background: rgba(0,0,0,0.04); }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ url('/') }}">Product Management System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Kategori</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('warehouses.index') }}">Gudang</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('stocks.index') }}">Stok</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
      </div>
    @endif

    @yield('content')
  </main>

  <footer>
    <div class="container">
      <small>© {{ date('Y') }} Sistem Manajemen Produk — Diesty Mendila</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
