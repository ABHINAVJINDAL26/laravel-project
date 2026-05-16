<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'From My Stove To Yours') }} - Authentication</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        vintageDark: '#2D2926',
                        vintageAccent: '#D4AF37',
                        vintageLight: '#F5F5DC',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #2D2926;
            color: #F5F5DC;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Override Breeze standard classes for inputs */
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 0.5rem !important;
        }
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 1px #D4AF37 !important;
        }
        label, span.text-sm {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        a.text-sm, .underline {
            color: #D4AF37 !important;
            text-decoration: none !important;
        }
        a.text-sm:hover, .underline:hover {
            color: white !important;
        }
        button, .bg-indigo-600, input[type="submit"] {
            background-color: #D4AF37 !important;
            color: #2D2926 !important;
            border: none !important;
            font-weight: 600 !important;
            border-radius: 9999px !important;
            padding: 0.5rem 1.5rem !important;
            transition: all 0.3s ease !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            font-size: 0.875rem !important;
        }
        button:hover, .bg-indigo-600:hover {
            background-color: white !important;
            transform: translateY(-1px);
        }
        .bg-white, .dark\:bg-gray-800 {
            background-color: transparent !important;
            box-shadow: none !important;
        }
        input[type="checkbox"] {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        input[type="checkbox"]:checked {
            background-color: #D4AF37 !important;
            border-color: #D4AF37 !important;
        }
    </style>
</head>
<body class="font-sans antialiased text-white bg-vintageDark">
    <div class="min-h-screen flex">
        
        <!-- Left Side: Food Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent z-10"></div>
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=2070&auto=format&fit=crop" 
                 alt="Kitchen preparation" 
                 class="absolute inset-0 w-full h-full object-cover z-0" />
            
            <div class="relative z-20 flex flex-col justify-center px-16 text-white h-full w-full bg-gradient-to-t from-vintageDark via-transparent to-transparent">
                <a href="/" class="flex items-center gap-3 mb-12 group">
                    <div class="w-12 h-12 rounded-full bg-vintageAccent flex items-center justify-center text-vintageDark font-bold text-2xl shadow-lg transition-transform group-hover:scale-105">
                        F
                    </div>
                    <span class="font-serif text-3xl font-bold tracking-wide group-hover:text-vintageAccent transition-colors">From My Stove To Yours</span>
                </a>
                
                <h1 class="text-4xl lg:text-5xl font-serif font-bold leading-tight mb-6">
                    Join the culinary<br /><span class="text-vintageAccent italic">journey.</span>
                </h1>
                <p class="text-lg text-white/80 max-w-md">
                    Access your favorite recipes, share your own creations, and become part of a community that celebrates the joy of cooking.
                </p>
            </div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-vintageDark relative">
            
            <!-- Mobile Logo -->
            <div class="lg:hidden absolute top-8 left-8">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-full bg-vintageAccent flex items-center justify-center text-vintageDark font-bold text-lg transition-transform group-hover:scale-105">
                        F
                    </div>
                    <span class="font-serif text-xl font-bold group-hover:text-vintageAccent transition-colors">From My Stove To Yours</span>
                </a>
            </div>

            <div class="w-full max-w-md mt-12 lg:mt-0">
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-serif font-bold text-white mb-2">Welcome</h2>
                    <p class="text-white/60">Please enter your details to continue.</p>
                </div>

                <!-- Form Container -->
                <div class="bg-[#3D3834]/50 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-white/5 relative z-10">
                    {{ $slot }}
                </div>
                
                <p class="text-center text-sm text-white/40 mt-8">
                    &copy; {{ date('Y') }} From My Stove To Yours. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
