@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem 1.25rem;">
    @php
        $imagePath = 'https://placehold.co/1200x800?text=Recipe+Image';

        if ($recipe->image) {
            if (\Illuminate\Support\Str::startsWith($recipe->image, ['http://', 'https://'])) {
                $imagePath = $recipe->image;
            } elseif (file_exists(public_path('images/' . $recipe->image))) {
                $imagePath = asset('images/' . $recipe->image);
            }
        }
    @endphp

    <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <a href="/" style="color:var(--gold); font-weight:700; text-decoration:none;">← Back to recipes</a>
        <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
            <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-gold" style="padding:.75rem 1rem; border-radius:.85rem;">Edit</a>
            <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Delete this recipe permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-gold" style="padding:.75rem 1rem; border:none; border-radius:.85rem; background:#b04a4a;">Delete</button>
            </form>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr; gap:1.5rem;">
        <div style="height:420px; border-radius:1.25rem; overflow:hidden; border:1px solid var(--border-light); background:#f6f2ee;">
            <img src="{{ $imagePath }}" alt="{{ $recipe->title }}" style="width:100%; height:100%; object-fit:cover; display:block;">
        </div>

        <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.5rem;">
            <p style="margin:0 0 .5rem; color:var(--gold); font-weight:700; text-transform:uppercase; letter-spacing:.18em; font-size:.75rem;">{{ $recipe->origin }}</p>
            <h1 class="serif" style="margin:0 0 .75rem; font-size:2.4rem; color:var(--ink);">{{ $recipe->title }}</h1>
            <p style="margin:0; color:var(--warm-gray); line-height:1.7;">{{ $recipe->description }}</p>
        </div>

        <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
            <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.5rem;">
                <h2 class="serif" style="margin-top:0;">Ingredients</h2>
                <div style="color:var(--warm-gray); line-height:1.8; white-space:pre-line;">{{ $recipe->ingredients }}</div>
            </div>
            <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.5rem;">
                <h2 class="serif" style="margin-top:0;">Process</h2>
                <div style="color:var(--warm-gray); line-height:1.8; white-space:pre-line;">{{ $recipe->process }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
