@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- HERO / PAGE HEADER --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div style="text-align:center; padding: 3rem 0 2rem; max-width:700px; margin:0 auto;">
    <p style="font-size:.78rem; letter-spacing:.2em; text-transform:uppercase; color:var(--gold); font-weight:600; margin-bottom:.6rem;">
        ✦ &nbsp; World Cuisines &nbsp; ✦
    </p>
    <h1 class="serif" style="font-size:3.2rem; font-weight:600; color:var(--ink); line-height:1.1; margin-bottom:1rem;">
        Culinary Stories from<br><em style="color:var(--gold-dark);">Every Corner of the World</em>
    </h1>
    <p style="font-size:1.05rem; color:var(--warm-gray); line-height:1.7;">
        Explore recipes, traditions, techniques, and personal tales from passionate food lovers — discover cuisines that will transport your senses.
    </p>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- SEARCH + SORT BAR --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('blogs.index') }}" style="margin:1.5rem 0 2rem;">
    <div style="display:flex; gap:.75rem; flex-wrap:wrap; align-items:center;">

        {{-- Search --}}
        <div style="flex:1; min-width:220px; position:relative;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#b8afa3;pointer-events:none;">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" name="search" value="{{ $currentSearch }}"
                   placeholder="Search pasta, ramen, biryani…"
                   class="field-input" style="padding-left:2.6rem;" autocomplete="off">
        </div>

        {{-- Category dropdown --}}
        <div style="position:relative; min-width:200px;">
            <select name="category" class="field-input" style="appearance:none; padding-right:2.5rem; cursor:pointer;">
                <option value="">🌍 All Categories</option>
                @foreach($categories as $cat => $icon)
                    <option value="{{ $cat }}" @selected($currentCategory === $cat)>{{ $icon }} {{ $cat }}</option>
                @endforeach
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);pointer-events:none;color:#b8afa3;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        {{-- Sort --}}
        <div style="position:relative; min-width:170px;">
            <select name="sort" class="field-input" style="appearance:none; padding-right:2.5rem; cursor:pointer;">
                <option value="newest"    @selected($currentSort==='newest')   >🕐 Newest First</option>
                <option value="oldest"    @selected($currentSort==='oldest')   >📅 Oldest First</option>
                <option value="likes"     @selected($currentSort==='likes')    >❤️ Most Liked</option>
                <option value="read_time" @selected($currentSort==='read_time')>⚡ Quick Reads</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);pointer-events:none;color:#b8afa3;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <button type="submit" class="btn-gold">Search</button>

        @if($currentSearch || $currentCategory || $currentSort !== 'newest')
            <a href="{{ route('blogs.index') }}" class="btn-outline">Clear</a>
        @endif

        <div style="flex-grow: 1;"></div>
        
        <a href="{{ route('blogs.create') }}" class="btn-gold" style="padding:.5rem 1.2rem;font-size:.82rem; margin-left: auto;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Write a Story
        </a>
    </div>

    {{-- Active filter pills --}}
    @if($currentSearch || $currentCategory)
    <div style="margin-top:.9rem; display:flex; gap:.5rem; flex-wrap:wrap; align-items:center;">
        <span style="font-size:.78rem; color:var(--warm-gray);">Active filters:</span>
        @if($currentSearch)
            <span class="tag">🔍 "{{ $currentSearch }}"</span>
        @endif
        @if($currentCategory)
            <span class="tag">{{ $categories[$currentCategory] ?? '' }} {{ $currentCategory }}</span>
        @endif
    </div>
    @endif
</form>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- TOPIC QUICK-FILTERS (scrollable pills) --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div style="display:flex; gap:.5rem; overflow-x:auto; padding-bottom:.5rem; margin-bottom:2.5rem; scrollbar-width:none;">
    <a href="{{ route('blogs.index', array_merge(request()->except('category'), ['category'=>''])) }}"
       style="flex-shrink:0; padding:.4rem 1.1rem; border-radius:99px; font-size:.82rem; font-weight:500; text-decoration:none;
              background:{{ !$currentCategory ? 'var(--gold)' : 'var(--card-bg)' }};
              color:{{ !$currentCategory ? 'var(--ink)' : 'var(--warm-gray)' }};
              border:1.5px solid {{ !$currentCategory ? 'var(--gold)' : '#e5ddd0' }};
              transition:all .2s;">
        All
    </a>
    @foreach($categories as $cat => $icon)
    <a href="{{ route('blogs.index', array_merge(request()->except(['category','page']), ['category'=>$cat])) }}"
       style="flex-shrink:0; padding:.4rem 1rem; border-radius:99px; font-size:.82rem; font-weight:500; text-decoration:none;
              background:{{ $currentCategory===$cat ? 'var(--gold)' : 'var(--card-bg)' }};
              color:{{ $currentCategory===$cat ? 'var(--ink)' : 'var(--warm-gray)' }};
              border:1.5px solid {{ $currentCategory===$cat ? 'var(--gold)' : '#e5ddd0' }};
              white-space:nowrap; transition:all .2s;">
        {{ $icon }} {{ $cat }}
    </a>
    @endforeach
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- FEATURED BLOG --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if($featuredBlog && !$currentSearch && !$currentCategory)
<div style="position:relative; border-radius:1.4rem; overflow:hidden; margin-bottom:3.5rem; box-shadow:0 12px 48px rgba(26,18,9,.2); cursor:pointer;" onclick="window.location='{{ route('blogs.show', $featuredBlog->_id) }}'">
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,6,2,.85) 0%,rgba(10,6,2,.15) 60%,transparent 100%);z-index:1;"></div>
    <img src="{{ $featuredBlog->cover_image_url }}" alt="{{ $featuredBlog->title }}"
         style="width:100%; height:520px; object-fit:cover; display:block; transform:scale(1.01); transition:transform 8s ease;">
    <div style="position:absolute; bottom:0; left:0; right:0; padding:2.5rem 3rem; z-index:2;">
        <div style="display:flex; gap:.6rem; margin-bottom:1rem; align-items:center;">
            <span style="background:var(--gold); color:var(--ink); font-size:.72rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; padding:.3rem .85rem; border-radius:99px;">
                ✦ Featured
            </span>
            <span style="background:rgba(255,255,255,.15); backdrop-filter:blur(8px); color:white; font-size:.72rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase; padding:.3rem .85rem; border-radius:99px; border:1px solid rgba(255,255,255,.2);">
                {{ $featuredBlog->category }}
            </span>
        </div>
        <h2 class="serif" style="font-size:2.6rem; color:white; font-weight:600; line-height:1.2; margin-bottom:.8rem; max-width:700px; text-shadow:0 2px 12px rgba(0,0,0,.4);">
            {{ $featuredBlog->title }}
        </h2>
        <p style="color:rgba(255,255,255,.8); font-size:.9rem; margin-bottom:1.2rem; max-width:560px;">
            {{ Str::limit($featuredBlog->content, 140) }}
        </p>
        <div style="display:flex; align-items:center; gap:1.5rem; color:rgba(255,255,255,.7); font-size:.82rem;">
            <span>⏱ {{ $featuredBlog->read_time_min }} min read</span>
            <span>❤️ {{ $featuredBlog->likes ?? 0 }} likes</span>
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- WORLD CUISINE CAROUSEL --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if(!$currentSearch && !$currentCategory)
<div style="margin-bottom:3rem;">
    <div style="display:flex; align-items:baseline; justify-content:space-between; margin-bottom:1.2rem;">
        <h2 class="serif" style="font-size:1.7rem; font-weight:600; color:var(--ink);">A Taste of the World</h2>
        <div style="display:flex; gap:.5rem;">
            <button onclick="slideCarousel(-1)" aria-label="Previous"
                    style="width:36px;height:36px;border-radius:50%;border:1.5px solid var(--border-light);background:var(--card-bg);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--warm-gray);transition:all .2s;"
                    onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold-dark)'" onmouseout="this.style.borderColor='#e5ddd0';this.style.color='var(--warm-gray)'">&#8592;</button>
            <button onclick="slideCarousel(1)" aria-label="Next"
                    style="width:36px;height:36px;border-radius:50%;border:1.5px solid var(--border-light);background:var(--card-bg);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--warm-gray);transition:all .2s;"
                    onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold-dark)'" onmouseout="this.style.borderColor='#e5ddd0';this.style.color='var(--warm-gray)'">&#8594;</button>
        </div>
    </div>

    <div style="position:relative; overflow:hidden; border-radius:1.3rem; box-shadow:0 8px 32px rgba(26,18,9,.12);" id="carouselWrap">
        <div id="carousel" style="display:flex; transition:transform .55s cubic-bezier(.4,0,.2,1);">
            @php
            $slides = [
                ['url'=>'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1400&q=80','label'=>'Italian Cuisine','sub'=>'Where pasta, pizza and la dolce vita meet'],
                ['url'=>'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?auto=format&fit=crop&w=1400&q=80','label'=>'Asian Street Food','sub'=>'Vibrant flavours from Tokyo to Bangkok'],
                ['url'=>'https://images.unsplash.com/photo-1565557623262-b51c2513a641?auto=format&fit=crop&w=1400&q=80','label'=>'Indian Spices','sub'=>'A symphony of spice, colour and tradition'],
                ['url'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1400&q=80','label'=>'Global Platters','sub'=>'Every plate tells a story'],
                ['url'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1400&q=80','label'=>'Fine Dining','sub'=>'Elevated craft and culinary artistry'],
                ['url'=>'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=1400&q=80','label'=>'Fresh & Vibrant','sub'=>'Farm-to-table ingredients, bursting with colour'],
            ];
            @endphp
            @foreach($slides as $i => $slide)
            <div style="min-width:100%; position:relative;" class="carousel-slide">
                <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,6,2,.8) 0%,transparent 55%);z-index:1;"></div>
                <img src="{{ $slide['url'] }}" alt="{{ $slide['label'] }}"
                     style="width:100%;height:420px;object-fit:cover;display:block;"
                     loading="{{ $i===0 ? 'eager' : 'lazy' }}">
                <div style="position:absolute;bottom:0;left:0;right:0;padding:2rem 2.5rem;z-index:2;">
                    <h3 class="serif" style="font-size:2.1rem;color:white;font-weight:600;text-shadow:0 2px 12px rgba(0,0,0,.4);margin-bottom:.3rem;">{{ $slide['label'] }}</h3>
                    <p style="color:rgba(255,255,255,.75);font-size:.9rem;">{{ $slide['sub'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Dots --}}
        <div style="position:absolute;bottom:.9rem;left:50%;transform:translateX(-50%);display:flex;gap:.45rem;z-index:3;" id="carouselDots">
            @foreach($slides as $i => $slide)
            <button onclick="goToSlide({{ $i }})" aria-label="Slide {{ $i+1 }}"
                    style="width:{{ $i===0 ? '22px' : '7px' }};height:7px;border-radius:99px;border:none;cursor:pointer;transition:all .3s;
                           background:{{ $i===0 ? 'var(--gold)' : 'rgba(255,255,255,.45)' }};" class="carousel-dot"></button>
            @endforeach
        </div>
    </div>
</div>

<script>
    let carouselIndex = 0;
    const totalSlides = {{ count($slides) }};

    function updateCarousel() {
        document.getElementById('carousel').style.transform = `translateX(-${carouselIndex * 100}%)`;
        document.querySelectorAll('.carousel-dot').forEach((d, i) => {
            d.style.background = i === carouselIndex ? 'var(--gold)' : 'rgba(255,255,255,.45)';
            d.style.width = i === carouselIndex ? '22px' : '7px';
        });
    }
    function slideCarousel(dir) {
        carouselIndex = (carouselIndex + dir + totalSlides) % totalSlides;
        updateCarousel();
        resetTimer();
    }
    function goToSlide(i) {
        carouselIndex = i;
        updateCarousel();
        resetTimer();
    }
    let timer = setInterval(() => slideCarousel(1), 5000);
    function resetTimer() { clearInterval(timer); timer = setInterval(() => slideCarousel(1), 5000); }
</script>
@endif

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- BLOG GRID --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if($blogs->isNotEmpty())
<div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(310px,1fr)); gap:1.8rem;">
    @foreach($blogs as $blog)
    <article class="card" data-blog-id="{{ $blog->_id }}"
             onclick="window.location='{{ route('blogs.show', $blog->_id) }}'" style="cursor:pointer;">
        {{-- Cover image --}}
        <div style="position:relative; overflow:hidden;">
            <img src="{{ $blog->cover_image_url }}"
                 alt="{{ $blog->title }}"
                 class="card-img"
                 loading="lazy"
                 onerror="this.src='https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=800&q=70'">
            <div style="position:absolute; top:.9rem; left:.9rem;">
                <a href="{{ route('blogs.index', ['category'=>$blog->category]) }}"
                   style="background:rgba(26,18,9,.75); backdrop-filter:blur(6px);
                          color:var(--gold-light); font-size:.7rem; font-weight:600;
                          letter-spacing:.09em; text-transform:uppercase;
                          padding:.28rem .8rem; border-radius:99px; text-decoration:none;
                          border:1px solid rgba(201,168,76,.3);">
                    {{ ($categories[$blog->category] ?? '🍽') }} {{ $blog->category }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <h3 class="card-title">{{ $blog->title }}</h3>
            <p class="card-excerpt">{{ Str::limit($blog->content, 110) }}</p>

            {{-- Tags --}}
            @if(!empty($blog->tags))
            <div style="display:flex; gap:.4rem; flex-wrap:wrap; margin-top:.8rem;">
                @foreach(array_slice($blog->tags, 0, 4) as $tag)
                    <a href="{{ route('blogs.index', ['search'=>$tag]) }}" class="tag" style="text-decoration:none;">
                        #{{ $tag }}
                    </a>
                @endforeach
            </div>
            @endif

            <div class="card-footer">
                <div style="display:flex; align-items:center; gap:1rem;">
                    <span class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                        </svg>
                        {{ $blog->read_time_min }} min
                    </span>
                    <span class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $blog->created_at ? $blog->created_at->diffForHumans() : 'Recently' }}
                    </span>
                </div>

                {{-- Like button (stop propagation so card click doesn't fire) --}}
                <button class="like-btn {{ is_array($blog->liked_by) && in_array(auth()->id(), $blog->liked_by) ? 'liked' : '' }}" onclick="event.stopPropagation(); likeBlog(this, '{{ $blog->_id }}')" title="Like this post">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="like-count">{{ $blog->likes ?? 0 }}</span>
                </button>
            </div>
        </div>
    </article>
    @endforeach
</div>

@else
{{-- Empty state --}}
<div style="text-align:center; padding:5rem 2rem; background:var(--card-bg); border-radius:1.2rem; border:1.5px dashed var(--border-light);">
    <div style="font-size:3.5rem; margin-bottom:1rem;">🍽️</div>
    <h3 class="serif" style="font-size:1.8rem; color:var(--ink); margin-bottom:.5rem;">
        @if($currentSearch)
            No stories found for "{{ $currentSearch }}"
        @elseif($currentCategory)
            No stories in {{ $currentCategory }} yet
        @else
            The table is empty — be the first!
        @endif
    </h3>
    <p style="color:var(--warm-gray); margin-bottom:1.5rem; font-size:.95rem;">
        @if($currentSearch || $currentCategory)
            Try a different search term or browse all categories.
        @else
            Share your first culinary story and inspire the world.
        @endif
    </p>
    @if($currentSearch || $currentCategory)
        <a href="{{ route('blogs.index') }}" class="btn-outline">Browse All Stories</a>
    @else
        <a href="{{ route('blogs.create') }}" class="btn-gold">Write Your Story</a>
    @endif
</div>
@endif

{{-- Floating write button (mobile) --}}
<a href="{{ route('blogs.create') }}"
   style="position:fixed; bottom:2rem; right:2rem; z-index:50; display:none;"
   id="floatingWrite">
    <span class="btn-gold" style="width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;padding:0;font-size:1.4rem;box-shadow:0 6px 24px rgba(201,168,76,.5);">
        ✍️
    </span>
</a>

<script>
    // Show floating button on mobile
    if (window.innerWidth < 768) {
        document.getElementById('floatingWrite').style.display = 'block';
    }

    // Like function
    function likeBlog(btn, id) {
        btn.classList.toggle('liked');
        fetch(`/blogs/${id}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(r => r.json())
        .then(data => {
            btn.querySelector('.like-count').textContent = data.likes;
        })
        .catch(() => {});
    }

    // Auto-submit sort/category change
    document.querySelectorAll('select[name="sort"], select[name="category"]').forEach(sel => {
        sel.addEventListener('change', () => sel.closest('form').submit());
    });
</script>

@endsection
