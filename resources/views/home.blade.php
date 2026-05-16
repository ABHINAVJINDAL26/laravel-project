@extends('layouts.app')

@section('title', 'Kitchen Archive')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-b from-vintage-cream/5 via-transparent to-transparent">
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 left-1/3 w-96 h-96 bg-vintage-terracotta/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-vintage-terracotta/3 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- Hero Content -->
            <div class="space-y-8 animate-fade-in">
                <div class="space-y-4">
                    <p class="text-vintage-terracotta font-bold uppercase tracking-[0.2em] text-sm">Global Culinary Hub</p>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight text-vintage-cream">
                        Share Your <span class="text-vintage-terracotta">Flavors</span> With The World
                    </h1>
                </div>
                <p class="text-vintage-cream/70 text-lg md:text-xl leading-relaxed max-w-xl">
                    Discover authentic recipes from every corner of the globe. Share your culinary treasures and connect with food lovers worldwide.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="/create" class="btn-terracotta px-8 py-4 text-lg font-semibold text-center">
                        Share Your Recipe
                    </a>
                    <a href="#recipes" class="btn-vintage px-8 py-4 text-lg font-semibold border border-vintage-terracotta/40 text-vintage-cream hover:bg-vintage-terracotta/10 text-center">
                        Explore Recipes
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-6 pt-8 border-t border-white/10">
                    <div class="animate-fade-in" style="animation-delay: 100ms">
                        <p class="text-3xl font-bold text-vintage-terracotta">{{ count($recipes) }}</p>
                        <p class="text-vintage-cream/60 text-sm">Global Recipes</p>
                    </div>
                    <div class="animate-fade-in" style="animation-delay: 200ms">
                        <p class="text-3xl font-bold text-vintage-terracotta">{{ $recipes->groupBy('origin')->count() }}</p>
                        <p class="text-vintage-cream/60 text-sm">Cuisines Featured</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative h-96 lg:h-[500px] animate-slide-up" style="animation-delay: 100ms">
                <div class="absolute inset-0 rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?q=80&w=1000&auto=format&fit=crop"
                         class="w-full h-full object-cover" alt="Global Cuisine">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cuisine Categories Section -->
<div class="bg-white/[0.02] border-y border-white/10 py-12 my-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="text-vintage-terracotta font-bold uppercase tracking-[0.2em] text-sm mb-2">Explore by Cuisine</p>
            <h2 class="text-4xl lg:text-5xl font-bold text-vintage-cream">World Flavors</h2>
        </div>

        <!-- Cuisine Filter Bar -->
        <div class="flex flex-wrap justify-center gap-3 animate-fade-in">
            @php
                $currentOrigin = request()->segment(2);
                $cuisines = [
                    ['label' => 'All', 'slug' => null, 'icon' => '🍽️'],
                    ['label' => 'Indian', 'slug' => 'Indian', 'icon' => '🍛'],
                    ['label' => 'Chinese', 'slug' => 'Chinese', 'icon' => '🥡'],
                    ['label' => 'Italian', 'slug' => 'Italian', 'icon' => '🍝'],
                    ['label' => 'Mexican', 'slug' => 'Mexican', 'icon' => '🌮'],
                    ['label' => 'Thai', 'slug' => 'Thai', 'icon' => '🍜'],
                    ['label' => 'American', 'slug' => 'American', 'icon' => '🍔'],
                ];
            @endphp

            @foreach($cuisines as $cuisine)
                @php
                    $isActive = ($cuisine['slug'] === null && !$currentOrigin) || $currentOrigin === $cuisine['slug'];
                    $url = $cuisine['slug'] ? '/sort/' . $cuisine['slug'] : '/';
                @endphp
                <a href="{{ $url }}"
                   class="cuisine-filter-btn {{ $isActive ? 'active' : '' }}">
                    <span class="text-2xl">{{ $cuisine['icon'] }}</span>
                    <span>{{ $cuisine['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Recipe Grid Section -->
<div class="max-w-7xl mx-auto px-6 py-20" id="recipes">
    <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-bold text-vintage-cream mb-4">Featured Recipes</h2>
        <p class="text-vintage-cream/60 max-w-2xl mx-auto">Carefully curated recipes from around the globe, shared by our community of food enthusiasts.</p>
    </div>

    <!-- Recipe Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($recipes as $recipe)
        <a href="/recipe/{{ $recipe->id }}" class="group cursor-pointer animate-slide-up" style="animation-delay: {{ $loop->index * 50 }}ms">
            @php
                $imagePath = 'https://placehold.co/800x600?text=Recipe+Image';

                if ($recipe->image) {
                    if (\Illuminate\Support\Str::startsWith($recipe->image, ['http://', 'https://'])) {
                        $imagePath = $recipe->image;
                    } elseif (file_exists(public_path('images/' . $recipe->image))) {
                        $imagePath = asset('images/' . $recipe->image);
                    }
                }
            @endphp
            <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-80 mb-6">
                <!-- Recipe Image -->
                <img src="{{ $imagePath }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     alt="{{ $recipe->title }}">

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                <!-- Rating Badge -->
                <div class="absolute top-4 right-4 flex items-center gap-1 bg-white/95 backdrop-blur px-3 py-2 rounded-full shadow-lg">
                    <span class="text-vintage-terracotta font-bold">★</span>
                    <span class="font-bold text-gray-900">{{ $recipe->rating }}</span>
                </div>

                <!-- Cuisine Badge -->
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-vintage-terracotta/90 text-white text-xs font-bold uppercase tracking-widest shadow-lg">
                        {{ $recipe->origin }}
                    </span>
                </div>
            </div>

            <!-- Recipe Info -->
            <div class="space-y-3">
                <h3 class="text-xl font-bold text-vintage-cream group-hover:text-vintage-terracotta transition-colors line-clamp-2">
                    {{ $recipe->title }}
                </h3>
                <p class="text-vintage-cream/60 text-sm line-clamp-2">
                    {{ $recipe->description }}
                </p>

                <!-- View More Button -->
                <div class="flex items-center gap-2 text-vintage-terracotta font-semibold text-sm group-hover:gap-3 transition-all pt-2">
                    <span>View Recipe</span>
                    <span>→</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full">
            <div class="text-center py-24 bg-white/[0.02] rounded-3xl border border-white/10">
                <div class="text-6xl mb-6">🍳</div>
                <h3 class="text-2xl font-bold text-vintage-cream/60 mb-2">No Recipes Found</h3>
                <p class="text-vintage-cream/40 mb-8">No recipes match this cuisine filter yet.</p>
                <a href="/" class="btn-terracotta inline-flex">View All Recipes</a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- CTA Section -->
<div class="relative my-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-vintage-terracotta/20 to-transparent rounded-3xl -z-10"></div>
    <div class="max-w-4xl mx-auto px-6 py-16 text-center">
        <h3 class="text-4xl font-bold text-vintage-cream mb-4">Share Your Culinary Story</h3>
        <p class="text-vintage-cream/70 text-lg mb-8">Have a family recipe or a dish that means something to you? Share it with our global community.</p>
        <a href="/create" class="btn-terracotta px-10 py-4 text-lg font-semibold inline-block">
            Add Your Recipe Now
        </a>
    </div>
</div>

@endsection
