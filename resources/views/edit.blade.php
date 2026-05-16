@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem 1.25rem;">
    <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.5rem;">
        <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:1rem;">
            @csrf
            @method('PUT')
            <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Title</label>
                    <input type="text" name="title" value="{{ $recipe->title }}" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Cuisine</label>
                    <input type="text" name="origin" value="{{ $recipe->origin }}" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                </div>
            </div>

            <div>
                <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Description</label>
                <textarea name="description" rows="4" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">{{ $recipe->description }}</textarea>
            </div>

            <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Ingredients</label>
                    <textarea name="ingredients" rows="7" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">{{ $recipe->ingredients }}</textarea>
                </div>
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Process</label>
                    <textarea name="process" rows="7" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">{{ $recipe->process }}</textarea>
                </div>
            </div>

            <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); align-items:end;">
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Rating</label>
                    <input type="number" name="rating" min="1" max="5" value="{{ $recipe->rating }}" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Image URL</label>
                    <input type="url" name="image" value="{{ $recipe->image }}" placeholder="https://example.com/recipe.jpg" style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem; background:#fff;">
                </div>
            </div>

            <div>
                <button type="submit" class="btn-gold" style="padding:.9rem 1.25rem; border:none; border-radius:.85rem;">Update Recipe</button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem 1.25rem;">
    <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.5rem;">
        <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:1rem;">
            @csrf
            @method('PUT')

            <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Title</label>
                    <input type="text" name="title" value="{{ $recipe->title }}" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Cuisine</label>
                    <input type="text" name="origin" value="{{ $recipe->origin }}" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                </div>
            </div>

            <div>
                <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Description</label>
                <textarea name="description" rows="4" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">{{ $recipe->description }}</textarea>
            </div>

            <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Ingredients</label>
                    <textarea name="ingredients" rows="7" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">{{ $recipe->ingredients }}</textarea>
                </div>
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Process</label>
                    <textarea name="process" rows="7" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">{{ $recipe->process }}</textarea>
                </div>
            </div>

            <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); align-items:end;">
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Rating</label>
                    <input type="number" name="rating" min="1" max="5" value="{{ $recipe->rating }}" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Image URL</label>
                    <input type="url" name="image" placeholder="Leave blank to keep the current image" style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem; background:#fff;">
                </div>
            </div>

            <div>
                <button type="submit" class="btn-gold" style="padding:.9rem 1.25rem; border:none; border-radius:.85rem;">Update Recipe</button>
            </div>
        </form>
    </div>
</div>
@endsection
