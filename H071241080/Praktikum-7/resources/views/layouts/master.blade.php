<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Enrekang - Pegunungan Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --color-primary: #4A5D4A;
            --color-primary-dark: #3A4D3A;
            --color-secondary: #8B7355;
            --color-accent: #B85C3A;
            --color-cream: #F5F1E8;
            --color-beige: #E8DCC8;
            --color-moss: #7A9075;
            --color-earth: #A68A6D;
            --color-text: #2C2C2C;
            --color-text-light: #666666;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-cream);
            color: var(--color-text);
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-moss) 100%);
            color: white;
            padding: 0.5rem 2rem 1rem;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex; 
           justify-content: space-between;
            align-items: center;
        }

        .header-logo img {
            height: 65px; 
            width: 65px;
            width: auto;
            opacity: 0.9;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 0.15rem;
        }

        .header-subtitle {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .nav {
            background-color: white;
            border-bottom: 1px solid var(--color-beige);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .nav li {
            margin: 0;
        }

        .nav a {
            color: var(--color-text);
            text-decoration: none;
            padding: 1.25rem 1.75rem;
            display: block;
            font-size: 0.9375rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 4px;
        }

        .nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1.75rem;
            right: 1.75rem;
            height: 2px;
            background-color: var(--color-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav a:hover, .nav a.active {
            background-color: var(--color-beige); 
            color: var(--color-primary-dark);
        }

        .nav a:hover::after {
            transform: scaleX(1);
        }

        .content {
            padding: 2rem 2rem;
            min-height: 70vh;
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer {
            background-color: var(--color-primary-dark);
            color: rgba(255, 255, 255, 0.85);
            text-align: center;
            padding: 2.5rem 2rem;
            margin-top: 2.5rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer p {
            font-size: 0.875rem;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        @media (max-width: 768px) {
            .header-logo img {
                height: 55px; 
                width: 45px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .nav ul {
                flex-wrap: wrap;
                padding: 0 1rem;
            }

            .nav a {
                padding: 1rem 1rem;
                font-size: 0.875rem;
            }

            .nav a::after {
                left: 1rem;
                right: 1rem;
            }

            .content {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
    
</head>
<body>

    <header class="header">
    <div class="header-content">
        <div class="header-branding"> 
            <h1>Eksplor Enrekang</h1>
            <p class="header-subtitle">Pesona Pegunungan Massenrempulu</p>
        </div>
        
        <div class="header-logo">
            <img src="{{ asset('images/logo-enrekang.png') }}" alt="Logo Kabupaten Enrekang">
        </div>
    </div>
    </header>

    <nav class="nav">
        <ul>
            <li><x-nav-link route="/" title="Home" /></li>
            <li><x-nav-link route="/destinasi" title="Destinasi" /></li>
            <li><x-nav-link route="/kuliner" title="Kuliner" /></li>
            <li><x-nav-link route="/galeri" title="Galeri" /></li>
            <li><x-nav-link route="/kontak" title="Kontak" /></li>
        </ul>
    </nav>

    <main class="content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Eksplor Pariwisata Enrekang. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>