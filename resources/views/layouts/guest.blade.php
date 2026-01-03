<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <style>
            .auth-bg {
                background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                            radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
                            #0f172a;
                min-height: 100vh;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                border-radius: 20px;
                color: white;
            }

            /* Overriding default input styles for dark theme compatibility */
            input[type="email"],
            input[type="password"],
            input[type="text"] {
                background: rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                border-radius: 8px;
            }
            
            input[type="email"]:focus,
            input[type="password"]:focus,
            input[type="text"]:focus {
                border-color: #6366f1;
                box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.3);
            }

            label {
                color: #cbd5e1 !important;
            }

            .primary-btn {
                background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
                border: none;
                transition: transform 0.2s;
            }
            
            .primary-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            }
        </style>

        <div class="auth-bg min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="flex flex-col items-center gap-2">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2rem;">
                        E
                    </div>
                    <span style="font-size: 1.5rem; font-weight: 700; color: white; letter-spacing: -0.5px;">EscrowSecure</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 glass-card overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
