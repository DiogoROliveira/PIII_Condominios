<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Reclama Condo') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #6c757d;
            --text-color: rgba(255, 255, 255, 0.9);
            --bg-overlay: rgba(0, 0, 0, 0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: url('/images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--bg-overlay);
            z-index: 1;
        }

        /* Header Improvements */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background-color: transparent;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .header.scrolled {
            background-color: rgba(0, 0, 0, 0.678);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 60px;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Language Dropdown */
        .language-dropdown {
            position: relative;
        }

        .language-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: rgba(0, 0, 0, 0.8);
            min-width: 120px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px;
            z-index: 1;
        }

        .language-dropdown:hover .language-dropdown-content {
            display: block;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 5%;
            position: relative;
            z-index: 10;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            background-color: #217adf;
            transform: translateY(-5px);
        }

        /* Sections Common Styles */
        .section {
            background-color: rgba(0, 0, 0, 0.629);
            padding: 43px 5%;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .section h2 {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 25px;
            font-size: 2.2rem;
        }

        .section p {
            max-width: 800px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        /* Contact Section */
        .contact-info {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .email {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        /* Footer */
        .footer {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .nav-links {
                display: none;
                /* Placeholder for mobile menu */
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="/images/logo.png" alt="Reclama Condo Logo">
        </div>
        <nav class="nav-links">
            <a href="#home">{{ __('Home') }}</a>
            <a href="#about">{{ __('About') }}</a>
            <a href="#contact">{{ __('Contact') }}</a>
            @if (!Auth::check())
            <a href="{{ route('login') }}">{{ __('Log in') }}</a>
            <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
            @else
            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
            @endif


            <div class="language-dropdown">
                <a href="#" class="language-switch">
                    <i class="fas fa-globe"></i>
                </a>
                <div class="language-dropdown-content">
                    @foreach (config('localization.locales') as $locale)
                    <a href="{{ route('lang', $locale) }}">{{ strtoupper(__($locale)) }}</a>
                    @endforeach
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>{{ __('Reclama Condo') }}</h1>
            <p>{{ __('Simplifying condominium management has never been easier! At ReclamaCondo, we streamline the handling of complaints and ensure seamless rent management for your property.') }}</p>
            <p>{{ __('Welcome to the ultimate platform for condominium management!') }}</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-button">{{ __('Start Now') }}</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <h2>{{ __('About us') }}</h2>
        <p>{{ __('At ReclamaCondo, we are driven by the mission to revolutionize condominium management. Our dedicated team has created an innovative platform that bridges the gap between property owners and managers, fostering efficient communication and delivering prompt solutions to any complaints. Let us transform the way you manage your condominium!') }}</p>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <h2>{{ __('Contact us') }}</h2>
            <p>{{ __('If you have any questions or need further assistance, please don\'t hesitate to contact us.') }}</p>
            <div class="contact-info">
                <p>
                    <i class="fas fa-envelope"></i>
                    <a class="email" href="mailto:reisdavid@ipvc.pt">reisdavid@ipvc.pt</a>
                </p>
                <p>
                    <i class="fas fa-envelope"></i>
                    <a class="email" href="mailto:diogo.rosas.oliveira@ipvc.pt">diogo.rosas.oliveira@ipvc.pt</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        &copy; {{ date('Y') }} {{ __('Reclama Condo') }}. {{ __('All rights reserved.') }}
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>