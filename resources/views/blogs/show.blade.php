@extends('layouts.app')

@section('content')

{{-- ── HERO ────────────────────────────────────────────── --}}
<div style="position:relative; border-radius:1.5rem; overflow:hidden; margin-bottom:3rem; box-shadow:0 16px 56px rgba(26,18,9,.25);">
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,6,2,.92) 0%,rgba(10,6,2,.35) 55%,transparent 100%);z-index:1;"></div>
    <img src="{{ $blog->cover_image_url }}"
         alt="{{ $blog->title }}"
         style="width:100%; height:480px; object-fit:cover; display:block;"
         onerror="this.src='https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1400&q=80'">

    <div style="position:absolute; bottom:0; left:0; right:0; padding:2.5rem 3rem; z-index:2;">
        {{-- Breadcrumb --}}
        <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:1.2rem; font-size:.78rem; color:rgba(255,255,255,.55);">
            <a href="{{ route('blogs.index') }}" style="color:rgba(255,255,255,.55); text-decoration:none; transition:color .2s;"
               onmouseover="this.style.color='var(--gold-light)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">
                Explore
            </a>
            <span>›</span>
            <a href="{{ route('blogs.index', ['category'=>$blog->category]) }}"
               style="color:rgba(255,255,255,.55); text-decoration:none;"
               onmouseover="this.style.color='var(--gold-light)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">
                {{ $blog->category }}
            </a>
            <span>›</span>
            <span style="color:rgba(255,255,255,.8);">{{ Str::limit($blog->title, 40) }}</span>
        </div>

        {{-- Badges --}}
        <div style="display:flex; gap:.6rem; margin-bottom:1rem; flex-wrap:wrap;">
            @if($blog->is_featured)
            <span style="background:var(--gold); color:var(--ink); font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; padding:.28rem .9rem; border-radius:99px;">✦ Featured</span>
            @endif
            <a href="{{ route('blogs.index', ['category'=>$blog->category]) }}"
               style="background:rgba(255,255,255,.14); backdrop-filter:blur(8px); color:white;
                      font-size:.7rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase;
                      padding:.28rem .9rem; border-radius:99px; border:1px solid rgba(255,255,255,.2);
                      text-decoration:none;">
                {{ ($categories[$blog->category] ?? '🍽') }} {{ $blog->category }}
            </a>
        </div>

        <h1 class="serif" style="font-size:2.8rem; font-weight:600; color:white; line-height:1.15; max-width:800px; text-shadow:0 2px 16px rgba(0,0,0,.4); margin-bottom:1rem;">
            {{ $blog->title }}
        </h1>

        <div style="display:flex; align-items:center; gap:1.8rem; color:rgba(255,255,255,.7); font-size:.82rem; flex-wrap:wrap;">
            <span style="display:flex; align-items:center; gap:.35rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                </svg>
                {{ $blog->read_time_min }} min read
            </span>
            <span style="display:flex; align-items:center; gap:.35rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $blog->created_at ? $blog->created_at->format('d M Y') : 'Recently' }}
            </span>
            <span style="display:flex; align-items:center; gap:.35rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span id="heroLikeCount">{{ $blog->likes ?? 0 }}</span> likes
            </span>
        </div>
    </div>
</div>

{{-- ── ARTICLE BODY ──────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:1fr 300px; gap:3rem; align-items:start; max-width:1100px; margin:0 auto;">

    {{-- Left: content --}}
    <article>
        {{-- Tags --}}
        @if(!empty($blog->tags))
        <div style="display:flex; gap:.45rem; flex-wrap:wrap; margin-bottom:2rem;">
            @foreach($blog->tags as $tag)
            <a href="{{ route('blogs.index', ['search'=>$tag]) }}"
               style="background:#f5efe3; color:var(--gold-dark); border-radius:99px;
                      padding:.2rem .75rem; font-size:.75rem; font-weight:500;
                      text-decoration:none; border:1px solid #e8dcc8; transition:background .2s;"
               onmouseover="this.style.background='#eadec5'" onmouseout="this.style.background='#f5efe3'">
                #{{ $tag }}
            </a>
            @endforeach
        </div>
        @endif

        {{-- The content --}}
        <div style="font-size:1.08rem; line-height:1.9; color:var(--charcoal); font-family:'Quicksand',sans-serif;">
            {!! nl2br(e($blog->content)) !!}
        </div>

        {{-- Like + Share bar --}}
        <div style="margin-top:3rem; padding:1.5rem 2rem; background:var(--card-bg); border-radius:1.1rem; border:1px solid var(--border-light); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div style="display:flex; align-items:center; gap:1rem;">
                @php $isLiked = is_array($blog->liked_by) && in_array(auth()->id(), $blog->liked_by); @endphp
                <button id="likeBtn" onclick="likePost()" title="Like this post" class="{{ $isLiked ? 'liked' : '' }}"
                        style="display:flex; align-items:center; gap:.5rem; padding:.6rem 1.4rem;
                               border:1.5px solid {{ $isLiked ? 'var(--gold)' : 'var(--border-light)' }}; border-radius:99px; background:var(--card-bg);
                               color:{{ $isLiked ? '#e05a5a' : 'var(--warm-gray)' }}; font-size:.9rem; font-weight:500; cursor:pointer;
                               transition:all .2s;">
                    <svg id="likeIcon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="{{ $isLiked ? '#e05a5a' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span id="likeText"><span id="likeCount">{{ $blog->likes ?? 0 }}</span> Likes</span>
                </button>
            </div>
            <div style="display:flex; align-items:center; gap:.6rem; font-size:.83rem; color:var(--warm-gray);">
                <span>Share:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->url()) }}"
                   target="_blank" rel="noopener"
                   style="padding:.4rem .9rem; border-radius:99px; border:1.5px solid #e8dcc8; text-decoration:none; color:var(--warm-gray); font-size:.8rem; transition:border-color .2s;"
                   onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='#e8dcc8'">
                    𝕏 Twitter
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>showCopied())"
                        style="padding:.4rem .9rem; border-radius:99px; border:1.5px solid #e8dcc8; background:none; cursor:pointer; color:var(--warm-gray); font-size:.8rem; transition:border-color .2s;"
                        onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='#e8dcc8'">
                    🔗 Copy Link
                </button>
            </div>
        </div>

        {{-- Back --}}
        <a href="{{ route('blogs.index') }}"
           style="display:inline-flex; align-items:center; gap:.4rem; margin-top:1.5rem;
                  color:var(--warm-gray); text-decoration:none; font-size:.85rem;"
           onmouseover="this.style.color='var(--gold-dark)'" onmouseout="this.style.color='var(--warm-gray)'">
            ← Back to Explore
        </a>
    </article>

    {{-- Right: sidebar --}}
    <aside style="position:sticky; top:90px;">
        {{-- Blog info card --}}
        <div style="background:var(--card-bg); border-radius:1.1rem; border:1px solid var(--border-light); padding:1.4rem; margin-bottom:1.5rem;">
            <p style="font-size:.7rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--gold-dark); margin-bottom:.8rem;">About this post</p>
            <div style="display:flex; flex-direction:column; gap:.7rem;">
                <div style="display:flex; justify-content:space-between; font-size:.85rem;">
                    <span style="color:var(--warm-gray);">Category</span>
                    <span style="font-weight:600; color:var(--charcoal);">{{ $blog->category }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:.85rem;">
                    <span style="color:var(--warm-gray);">Read time</span>
                    <span style="font-weight:600; color:var(--charcoal);">{{ $blog->read_time_min }} min</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:.85rem;">
                    <span style="color:var(--warm-gray);">Likes</span>
                    <span style="font-weight:600; color:var(--charcoal);">{{ $blog->likes ?? 0 }}</span>
                </div>
                @if($blog->created_at)
                <div style="display:flex; justify-content:space-between; font-size:.85rem;">
                    <span style="color:var(--warm-gray);">Published</span>
                    <span style="font-weight:600; color:var(--charcoal);">{{ $blog->created_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Related stories --}}
        @if($related->isNotEmpty())
        <div>
            <p style="font-size:.7rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--gold-dark); margin-bottom:.9rem;">More in {{ $blog->category }}</p>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                @foreach($related as $r)
                <a href="{{ route('blogs.show', $r->_id) }}"
                   style="display:flex; gap:.8rem; background:var(--card-bg); border-radius:.85rem; border:1px solid var(--border-light); overflow:hidden; text-decoration:none; transition:transform .2s, box-shadow .2s;"
                   onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(26,18,9,.08)'"
                   onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <img src="{{ $r->cover_image_url }}" alt="{{ $r->title }}"
                         style="width:80px; height:80px; object-fit:cover; flex-shrink:0;"
                         onerror="this.src='https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=200&q=60'">
                    <div style="padding:.65rem .8rem; display:flex; flex-direction:column; justify-content:center;">
                        <p style="font-family:'Outfit',sans-serif; font-size:.95rem; font-weight:600; color:var(--ink); line-height:1.3; margin:0 0 .3rem;">
                            {{ Str::limit($r->title, 50) }}
                        </p>
                        <span style="font-size:.72rem; color:var(--warm-gray);">{{ $r->read_time_min }} min read</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </aside>
</div>

<script>
const blogId = '{{ $blog->_id }}';

function likePost() {
    const btn = document.getElementById('likeBtn');
    const icon = document.getElementById('likeIcon');
    const countEl = document.getElementById('likeCount');
    const heroCountEl = document.getElementById('heroLikeCount');

    const isLiked = btn.classList.toggle('liked');
    if (isLiked) {
        btn.style.borderColor = 'var(--gold)';
        btn.style.color = '#e05a5a';
        icon.setAttribute('fill', '#e05a5a');
    } else {
        btn.style.borderColor = 'var(--border-light)';
        btn.style.color = 'var(--warm-gray)';
        icon.setAttribute('fill', 'none');
    }

    fetch(`/blogs/${blogId}/like`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
    })
    .then(r => r.json())
    .then(data => {
        countEl.textContent = data.likes;
        if (heroCountEl) heroCountEl.textContent = data.likes;
    })
    .catch(() => {});
}

function showCopied() {
    const btn = event.target;
    const orig = btn.textContent;
    btn.textContent = '✓ Copied!';
    btn.style.borderColor = 'var(--gold)';
    setTimeout(() => { btn.textContent = orig; btn.style.borderColor = '#e8dcc8'; }, 2000);
}
</script>

@endsection
