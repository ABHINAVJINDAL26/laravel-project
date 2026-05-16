@extends('layouts.app')

@section('title', 'From My Stove')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem 1.25rem;">

    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:2rem;">
        <div>
            <p style="font-size:.75rem; letter-spacing:.2em; text-transform:uppercase; color:var(--gold); font-weight:600; margin-bottom:.5rem;">✦ Explore Recipes</p>
            <h1 class="serif" style="font-size:2.6rem; font-weight:600; color:var(--ink); line-height:1.05; margin:0;">From My Stove — Community Recipes</h1>
            <p style="color:var(--warm-gray); margin-top:.5rem;">Browse recipes posted by our community. Click any recipe to read details.</p>
        </div>

        <div style="display:flex; gap:.75rem; align-items:center; flex-wrap:wrap; justify-content:flex-end;">
            <form method="GET" action="{{ route('dashboard') }}" style="display:flex; gap:.5rem; align-items:center;">
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search recipes..."
                    style="min-width:240px; padding:.8rem 1rem; border-radius:.8rem; border:1px solid var(--border-light); background:#fff; color:var(--ink);">
                <button type="submit" class="btn-gold" style="padding:.8rem 1rem; border:none; border-radius:.8rem;">Search</button>
                @if(request('search'))
                    <a href="{{ route('dashboard') }}" style="padding:.8rem 1rem; border-radius:.8rem; border:1px solid var(--border-light); color:var(--warm-gray); text-decoration:none;">Clear</a>
                @endif
            </form>
            @auth
                <a href="{{ route('recipes.create') }}" class="btn-gold" style="padding:.8rem 1rem; border-radius:.8rem;">Share Recipe</a>
            @endauth
        </div>
    </div>

    @if($recipes->isEmpty())
        <div style="background:var(--card-bg); border-radius:1rem; padding:2.5rem; text-align:center; border:1px dashed var(--border-light);">
            <p style="color:var(--warm-gray); margin-bottom:1rem;">No recipes yet — be the first to share one.</p>
            @auth
                <a href="{{ route('recipes.create') }}" class="btn-gold">Share a Recipe</a>
            @else
                <p style="color:var(--warm-gray);">Please log in to share recipes.</p>
            @endauth
        </div>
    @else
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1.25rem;">
            @foreach($recipes as $recipe)
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
                <article style="background:var(--card-bg); border-radius:1rem; overflow:hidden; border:1px solid var(--border-light);">
                    <a href="{{ route('recipes.show', $recipe->id) }}" style="text-decoration:none; color:inherit; display:block;">
                        <div style="height:180px; background:#f6f2ee; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                            <img src="{{ $imagePath }}" alt="{{ $recipe->title }}" style="width:100%; height:100%; object-fit:cover; display:block;" />
                        </div>
                        <div style="padding:1rem 1.25rem;">
                            <h3 style="margin:0 0 .5rem; font-size:1.05rem; font-weight:700;">{{ $recipe->title }}</h3>
                            <div style="display:flex; gap:.6rem; align-items:center; margin-bottom:.6rem; color:var(--warm-gray); font-size:.85rem;">
                                <span style="background:var(--gold); color:#fff; padding:.15rem .5rem; border-radius:.5rem; font-weight:700; font-size:.75rem;">{{ $recipe->origin }}</span>
                                <span>·</span>
                                <span>{{ \Illuminate\Support\Str::limit($recipe->description, 80) }}</span>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    @endif

</div>
@endsection
