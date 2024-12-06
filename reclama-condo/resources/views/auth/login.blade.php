<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Login - Reclama Condo') }}</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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

        .login-container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .language-dropdown {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .language-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .language-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            min-width: 120px;
            border-radius: 5px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .language-dropdown:hover .language-dropdown-content {
            display: block;
        }

        .language-dropdown-content a {
            color: white;
            padding: 10px;
            text-decoration: none;
            display: block;
        }

        .language-dropdown-content a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        h1 {
            text-align: center;
            color: rgba(255, 255, 255, 0.633);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.3);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            color: var(--text-color);
        }

        .remember-me input {
            margin-right: 10px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3a7bd5;
        }

        .forgot-password {
            color: skyblue;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
        }

        .signup-link a {
            color: skyblue;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-image {
            max-width: 300px;
            max-height: 150px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Language Dropdown -->
        <div class="language-dropdown">
            <button class="language-btn">
                {{ strtoupper(app()->getLocale()) }}
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="language-dropdown-content">
                @foreach (config('localization.locales') as $locale)
                    <a href="{{ route('lang', $locale) }}">{{ strtoupper(__($locale)) }}</a>
                @endforeach
            </div>
        </div>

        <div class="logo">
            <img src="/images/logo.png" alt="{{ __('Reclama Condo Logo') }}" class="logo-image">
        </div>

        <h1>{{ __('Login') }}</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Input -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    required 
                    autocomplete="current-password"
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="remember-forgot">
                <div class="remember-me">
                    <input 
                        type="checkbox" 
                        id="remember_me" 
                        name="remember"
                    >
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-primary">
                {{ __('Log in') }}
            </button>

            <!-- Signup Link -->
            <div class="signup-link">
                {{ __('Don\'t have an account?') }} 
                <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
            </div>
        </form>
    </div>
</body>
</html>