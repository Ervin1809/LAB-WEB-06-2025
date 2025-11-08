<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fish It Roblox - Fish Database')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        @layer base {
            body {
                font-family: 'Readex Pro', sans-serif;
            }
        }
        
        .rarity-common {
            background-color: #6c757d !important;
        }
        
        .rarity-uncommon {
            background-color: #28a745 !important;
        }
        
        .rarity-rare {
            background-color: #007bff !important;
        }
        
        .rarity-epic {
            background-color: #6f42c1 !important;
        }
        
        .rarity-legendary {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }
        
        .rarity-mythic {
            background-color: #dc3545 !important;
        }
        
        .rarity-secret {
            background: linear-gradient(90deg, #ff0000, #ff8000, #ffff00, #00ff00, #0000ff, #8000ff, #ff00ff, #ff0000) !important;
            background-size: 400% 400% !important;
            animation: rainbow 3s linear infinite !important;
        }
        
        @keyframes rainbow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .glow-common { box-shadow: 0 0 8px rgba(108, 117, 125, 0.7); }
        .glow-uncommon { box-shadow: 0 0 8px rgba(40, 167, 69, 0.7); }
        .glow-rare { box-shadow: 0 0 8px rgba(0, 123, 255, 0.7); }
        .glow-epic { box-shadow: 0 0 8px rgba(111, 66, 193, 0.7); }
        .glow-legendary { box-shadow: 0 0 8px rgba(255, 193, 7, 0.7); }
        .glow-mythic { box-shadow: 0 0 8px rgba(220, 53, 69, 0.7); }
        .glow-secret { 
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.8),
                        0 0 30px rgba(128, 0, 255, 0.6),
                        0 0 45px rgba(255, 0, 0, 0.4);
        }
        
        .neon-border {
            position: relative;
        }
        
        .neon-border::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #00dbde, #fc00ff, #00dbde);
            z-index: -1;
            border-radius: 8px;
        }
        
        .btn-glow {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-glow::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 20px;
            height: 200%;
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(25deg);
            transition: all 0.6s;
        }
        
        .btn-glow:hover::after {
            left: 120%;
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
        }
        
        .icon-spin {
            transition: transform 0.4s ease;
        }
        
        .icon-spin:hover {
            transform: rotate(360deg);
        }
        
        .text-glow {
            transition: text-shadow 0.3s ease;
        }
        
        .text-glow:hover {
            text-shadow: 0 0 8px currentColor;
        }
    </style>
</head>
<body class="flex min-h-full flex-col bg-slate-900 bg-gradient-to-br from-slate-900 via-slate-800 to-cyan-900 text-slate-200 antialiased relative overflow-x-hidden">
    <!-- Animated background elements -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: -1s;"></div>
        <div class="absolute bottom-1/4 left-1/2 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: -2s;"></div>
    </div>

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-slate-900/80 backdrop-blur-lg border-b border-cyan-500/30 shadow-lg shadow-cyan-500/10">
        <div class="container mx-auto px-4">
            <div class="flex h-16 items-center justify-between relative z-10">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('fishes.index') }}" class="flex items-center space-x-2 text-xl font-bold text-cyan-400 transition hover:text-cyan-300 group">
                        <i class="bi bi-water text-2xl group-hover:text-cyan-300 transition duration-300"></i>
                        <span class="font-orbitron font-bold tracking-wider">FISH IT DB</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('fishes.index') }}" class="flex items-center space-x-2 rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-slate-800/80 hover:text-cyan-400 hover:scale-105 {{ request()->routeIs('fishes.index') ? 'text-cyan-400 bg-slate-800/50 border border-cyan-500/30' : 'hover:bg-slate-800' }}">
                        <i class="bi bi-list-ul"></i>
                        <span>Fish List</span>
                    </a>
                    <a href="{{ route('fishes.create') }}" class="flex items-center space-x-2 rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-slate-800/80 hover:text-green-400 hover:scale-105 {{ request()->routeIs('fishes.create') ? 'text-green-400 bg-slate-800/50 border border-green-500/30' : 'hover:bg-slate-800' }}">
                        <i class="bi bi-plus-circle"></i>
                        <span>Add Fish</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto flex-1 p-4 md:p-6 lg:p-8 relative z-10">
        @if(session('success'))
            <div class="mb-4 rounded-lg border border-cyan-700/50 bg-cyan-900/30 p-4 text-sm text-cyan-300 backdrop-blur-sm">
                <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-700/50 bg-red-900/30 p-4 text-sm text-red-300 backdrop-blur-sm">
                 <i class="bi bi-exclamation-triangle-fill mr-2"></i> {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900/70 text-center py-4 border-t border-cyan-500/20 backdrop-blur-sm relative z-10">
        <div class="container mx-auto">
            <p class="text-sm text-slate-400">🎣 <span class="font-orbitron">FISH IT ROBLOX</span> Database Manager</p>
        </div>
    </footer>
    
    {{-- Alpine JS (PENTING UNTUK FUNGSI MODAL DELETE) --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>