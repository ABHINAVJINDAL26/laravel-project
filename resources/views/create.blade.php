@extends('layouts.app')

@section('title', 'Share Recipe')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem 1.25rem;">
    <div style="display:grid; gap:1.5rem; grid-template-columns:1fr;">
        <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.75rem;">
            <p style="font-size:.75rem; letter-spacing:.2em; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:.5rem;">Share Recipe</p>
            <h1 class="serif" style="font-size:2.4rem; margin:0 0 .75rem; color:var(--ink);">Add a new recipe</h1>
            <p style="color:var(--warm-gray); margin:0;">Tell the community what you cooked and how to make it.</p>
        </div>

        <div style="background:var(--card-bg); border:1px solid var(--border-light); border-radius:1.25rem; padding:1.5rem;">
            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:1rem;">
                @csrf
                <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
                    <div>
                        <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Title</label>
                        <input type="text" name="title" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Cuisine</label>
                        <select name="origin" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                            <option>Indian</option>
                            <option>Chinese</option>
                            <option>Italian</option>
                            <option>Mexican</option>
                            <option>Thai</option>
                            <option>American</option>
                            <option>French</option>
                            <option>Japanese</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Description</label>
                    <textarea name="description" rows="4" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;"></textarea>
                </div>

                <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
                    <div>
                        <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Ingredients</label>
                        <textarea name="ingredients" rows="7" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;"></textarea>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Process</label>
                        <textarea name="process" rows="7" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;"></textarea>
                    </div>
                </div>

                <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); align-items:end;">
                    <div>
                        <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Rating</label>
                        <input type="number" name="rating" min="1" max="5" value="3" required style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.35rem; font-weight:600; color:var(--ink);">Image URL</label>
                        <input type="url" name="image" required placeholder="https://example.com/recipe.jpg" style="width:100%; padding:.85rem 1rem; border:1px solid var(--border-light); border-radius:.85rem; background:#fff;">
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn-gold" style="padding:.9rem 1.25rem; border:none; border-radius:.85rem;">Share Recipe</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
