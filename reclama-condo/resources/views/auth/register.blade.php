<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Register - Reclama Condo') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Select2 and Flag Icons -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />

    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #6c757d;
            --text-color: rgba(255, 255, 255, 0.9);
            --bg-overlay: rgba(0, 0, 0, 0.6);
            --placeholder-color: rgba(255, 255, 255, 0.5);
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
            color: white;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 10px;
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
            color: rgba(255, 255, 255, 0.7);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: var(--placeholder-color);
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

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 13px;
        }

        .btn-primary:hover {
            background-color: #3a7bd5;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
        }

        .login-link a {
            color: skyblue;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 7px;
        }

        .logo-image {
            max-width: 300px;
            max-height: 150px;
            object-fit: contain;
        }

        .phone-input-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .country-code-wrapper {
            position: relative;
            width: 35%;
        }

        .country-code-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            padding: 12px 35px 12px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            cursor: pointer;
        }

        .country-code-select option{
            background: rgb(24, 24, 24);
        }

        .country-code-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: white;
        }

        .phone-input-container input {
            width: 65%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .phone-input-container input::placeholder {
            color: var(--placeholder-color);
        }

        /* Custom radio button styling for country code selector */
        .country-code-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 5px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .country-code-dropdown label {
            display: flex;
            align-items: center;
            padding: 10px;
            color: white;
            cursor: pointer;
        }

        .country-code-dropdown label:hover {
            background-color: rgba(248, 28, 28, 0.1);
        }

        .country-code-dropdown input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid white;
            border-radius: 50%;
            margin-right: 10px;
            outline: none;
        }

        .country-code-dropdown input[type="radio"]:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .country-code-dropdown input[type="radio"]:checked::after {
            content: '✓';
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .country-code-wrapper:hover .country-code-dropdown {
            display: block;
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .back-link {
            text-decoration: none;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-link i {
            font-size: 1.2rem;
        }

        .back-link:hover {
            color: var(--primary-color);
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

        <h1>{{ __('Register') }}</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Input -->
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="{{ __('Enter your full name') }}"
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

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
                    autocomplete="username"
                    placeholder="{{ __('Enter your email address') }}"
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Number Input -->
            <div class="form-group">
                <label for="phone_number">{{ __('Phone Number') }}</label>
                <div class="phone-input-container">
                    <div class="country-code-wrapper">
                        <select id="country_code" name="country_code" class="country-code-select">
                            @foreach ($countries as $country)
                            <option value="{{ $country['code'] }}" data-flag="{{ $country['flag'] ?? '' }}">
                                {{ $country['name'] }} ({{ $country['code'] }})
                            </option>   
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down country-code-icon"></i>
                    </div>
                    <input 
                        id="phone_number" 
                        type="tel" 
                        name="phone_number" 
                        class="form-control"
                        value="{{ old('phone_number') }}" 
                        placeholder="{{ __('Enter your phone number') }}"
                        autocomplete="tel"
                    >
                </div>
                @error('phone_number')
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
                    autocomplete="new-password"
                    placeholder="{{ __('Create a strong password') }}"
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="form-group">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control" 
                    required 
                    autocomplete="new-password"
                    placeholder="{{ __('Repeat your password') }}"
                >
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-primary">
                {{ __('Register') }}
            </button>

            <!-- Login Link -->
            <div class="login-link">
                {{ __('Already have an account?') }} 
                <a href="{{ route('login') }}">{{ __('Log in') }}</a>
            </div>

            <!-- Back Button -->
            <div class="back-button">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                </a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Custom country code selection
            $('.country-code-select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const flagClass = selectedOption.data('flag');
                
                // Update country code display if needed
                console.log('Selected country:', selectedOption.text());
            });
        });
    </script>
</body>
</html>