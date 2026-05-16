<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>From My Stove To Yours - Recipe Portal</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        vintageDark: '#2D2926',
                        vintageAccent: '#D4AF37', // Gold/Brass accent for a premium feel
                        vintageLight: '#F5F5DC', // Beige for text or light elements
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
        /* Custom Styles for extra polish */
        body {
            background-color: #2D2926;
            color: #F5F5DC;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-vintageDark min-h-screen flex flex-col font-sans">
    
    <!-- Navbar -->
    <nav class="w-full border-b border-white/10 glass-card fixed top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-full bg-vintageAccent flex items-center justify-center text-vintageDark font-bold text-xl transition-transform group-hover:scale-105 shadow-lg shadow-vintageAccent/30">
                            F
                        </div>
                        <span class="font-serif text-2xl tracking-wide text-white group-hover:text-vintageAccent transition-colors">From My Stove To Yours</span>
                    </a>
                </div>
                
                <!-- Auth Links -->
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white/80 hover:text-vintageAccent transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-white/80 hover:text-white transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent rounded-full shadow-sm text-sm font-semibold text-vintageDark bg-vintageAccent hover:bg-white transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-vintageAccent/20">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-vintageAccent/20 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-white/5 rounded-full blur-[120px]"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-32 text-center lg:pt-36 lg:pb-40">
                <span class="inline-block py-1 px-3 rounded-full glass-card text-vintageAccent font-semibold tracking-wider uppercase text-xs mb-6 border border-vintageAccent/30">
                    Welcome to the Culinary Community
                </span>
                <h1 class="text-5xl md:text-7xl font-serif font-bold text-white mb-6 leading-[1.1] tracking-tight">
                    Share, Discover,<br/> and <span class="text-vintageAccent italic">Learn.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg md:text-xl text-white/70 mx-auto leading-relaxed">
                    Home cooks and food enthusiasts often lack a centralized platform to share recipes and cooking tips. A portal is required to enable users to share, discover, and learn from each other, fostering a community of culinary enthusiasts.
                </p>
                
                <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#explore" class="inline-flex justify-center items-center px-8 py-3.5 rounded-full bg-vintageAccent text-vintageDark font-semibold hover:bg-white transition-all duration-300 transform hover:-translate-y-1 shadow-xl shadow-vintageAccent/20 text-lg">
                        Explore Recipes
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-3.5 rounded-full glass-card text-white font-semibold hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1 text-lg">
                        Join Community
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Section -->
        <div id="explore" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-white mb-4">Trending Recipes</h2>
                <p class="text-white/60 max-w-xl mx-auto text-lg">Discover what our community is cooking right now and find your next favorite dish.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="glass-card rounded-2xl overflow-hidden group cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:shadow-black/50 transition-all duration-300 border border-white/5 hover:border-vintageAccent/30">
                    <div class="h-56 relative overflow-hidden bg-vintageDark">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800&auto=format&fit=crop" alt="Avocado Salad" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-700"></div>
                        <div class="absolute top-4 right-4 bg-vintageDark/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs text-vintageAccent font-semibold tracking-wide uppercase border border-vintageAccent/20">
                            Lunch
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-serif font-bold text-white mb-3 group-hover:text-vintageAccent transition-colors">Vibrant Avocado Salad</h3>
                        <p class="text-white/60 mb-6 line-clamp-2 leading-relaxed">A refreshing and healthy mix of ripe avocados, cherry tomatoes, and mixed greens with a tangy lemon dressing.</p>
                        <div class="flex items-center justify-between pt-4 border-t border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-vintageAccent to-yellow-600 flex items-center justify-center text-vintageDark text-sm font-bold shadow-md">JD</div>
                                <span class="text-sm font-medium text-white/90">John Doe</span>
                            </div>
                            <span class="text-xs text-white/40 font-medium tracking-wide">2 hrs ago</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="glass-card rounded-2xl overflow-hidden group cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:shadow-black/50 transition-all duration-300 border border-white/5 hover:border-vintageAccent/30">
                    <div class="h-56 relative overflow-hidden bg-vintageDark">
                        <img src="https://images.unsplash.com/photo-1473093295043-cdd812d0e601?q=80&w=800&auto=format&fit=crop" alt="Vegan Pasta" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-700"></div>
                        <div class="absolute top-4 right-4 bg-vintageDark/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs text-vintageAccent font-semibold tracking-wide uppercase border border-vintageAccent/20">
                            Dinner
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-serif font-bold text-white mb-3 group-hover:text-vintageAccent transition-colors">Vegan Basil Pesto Pasta</h3>
                        <p class="text-white/60 mb-6 line-clamp-2 leading-relaxed">Al dente pasta tossed in a rich, dairy-free basil pesto made with pine nuts, nutritional yeast, and extra virgin olive oil.</p>
                        <div class="flex items-center justify-between pt-4 border-t border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-pink-500 to-rose-400 flex items-center justify-center text-white text-sm font-bold shadow-md">AS</div>
                                <span class="text-sm font-medium text-white/90">Anna Smith</span>
                            </div>
                            <span class="text-xs text-white/40 font-medium tracking-wide">5 hrs ago</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="glass-card rounded-2xl overflow-hidden group cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:shadow-black/50 transition-all duration-300 border border-white/5 hover:border-vintageAccent/30">
                    <div class="h-56 relative overflow-hidden bg-vintageDark">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop" alt="Veggie Bowl" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-700"></div>
                        <div class="absolute top-4 right-4 bg-vintageDark/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs text-vintageAccent font-semibold tracking-wide uppercase border border-vintageAccent/20">
                            Healthy
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-serif font-bold text-white mb-3 group-hover:text-vintageAccent transition-colors">Nourishing Buddha Bowl</h3>
                        <p class="text-white/60 mb-6 line-clamp-2 leading-relaxed">A wholesome bowl packed with quinoa, roasted sweet potatoes, crispy chickpeas, and a creamy tahini drizzle.</p>
                        <div class="flex items-center justify-between pt-4 border-t border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-cyan-400 flex items-center justify-center text-white text-sm font-bold shadow-md">MK</div>
                                <span class="text-sm font-medium text-white/90">Mike Kitchen</span>
                            </div>
                            <span class="text-xs text-white/40 font-medium tracking-wide">1 day ago</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <a href="#" class="inline-flex items-center gap-2 text-vintageAccent hover:text-white transition-colors font-semibold text-lg group">
                    View All Posts
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 mt-auto py-10 bg-[#25221F]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-vintageAccent flex items-center justify-center text-vintageDark font-bold text-xs">F</div>
                <span class="font-serif font-semibold text-white">From My Stove To Yours</span>
            </div>
            <p class="text-sm text-white/40">
                &copy; {{ date('Y') }} From My Stove To Yours. All rights reserved.
            </p>
            <div class="flex gap-8">
                <a href="#" class="text-sm text-white/40 hover:text-vintageAccent transition-colors">Privacy Policy</a>
                <a href="#" class="text-sm text-white/40 hover:text-vintageAccent transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>
</html>
