@extends('layouts.app')

@section('content')
<div style="max-width:780px; margin:0 auto; padding:1rem 0;">

    {{-- Back link --}}
    <a href="{{ route('blogs.index') }}"
       style="display:inline-flex; align-items:center; gap:.4rem; color:var(--warm-gray);
              text-decoration:none; font-size:.85rem; margin-bottom:2rem; transition:color .2s;"
       onmouseover="this.style.color='var(--gold-dark)'" onmouseout="this.style.color='var(--warm-gray)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Explore
    </a>

    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <p style="font-size:.75rem; letter-spacing:.2em; text-transform:uppercase; color:var(--gold); font-weight:600; margin-bottom:.5rem;">✦ Edit Your Story</p>
        <h1 class="serif" style="font-size:2.8rem; font-weight:600; color:var(--ink); line-height:1.1; margin-bottom:.6rem;">
            Update Your Blog
        </h1>
        <p style="color:var(--warm-gray); font-size:.95rem; line-height:1.6;">
            Refine your story and make it perfect.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('blogs.update', $blog->_id) }}" method="POST"
          style="background:var(--card-bg); border-radius:1.4rem; padding:2.5rem; border:1px solid var(--border-light); box-shadow:0 4px 24px rgba(26,18,9,.06); position:relative; overflow:hidden;">
        @csrf
        @method('PUT')

        {{-- Gold top accent --}}
        <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--gold-dark),var(--gold),var(--gold-light),var(--gold));"></div>

        {{-- TITLE --}}
        <div style="margin-bottom:1.5rem;">
            <label for="title" class="field-label">Blog Title</label>
            <input type="text" name="title" id="title" class="field-input"
                   placeholder="e.g., The Secret Behind Neapolitan Pizza Dough" required
                   value="{{ old('title', $blog->title) }}">
            @error('title')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        {{-- CATEGORY + READ TIME --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.2rem; margin-bottom:1.5rem;">
            <div>
                <label for="category" class="field-label">Category</label>
                <div style="position:relative;">
                    <select name="category" id="category" class="field-input" style="appearance:none; cursor:pointer; padding-right:2.5rem;" required>
                        <option value="" disabled>Choose a cuisine or topic…</option>
                        @foreach($categories as $cat => $icon)
                            <option value="{{ $cat }}" @selected(old('category', $blog->category)===$cat)>{{ $icon }} {{ $cat }}</option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);pointer-events:none;color:#b8afa3;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('category')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="read_time_min" class="field-label">Read Time (minutes)</label>
                <input type="number" name="read_time_min" id="read_time_min" class="field-input"
                       min="1" max="60" placeholder="e.g., 8" required value="{{ old('read_time_min', $blog->read_time_min) }}">
                @error('read_time_min')<p class="field-error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- TAGS --}}
        <div style="margin-bottom:1.5rem;">
            <label for="tags" class="field-label">Tags <span style="font-weight:400;text-transform:none;letter-spacing:0;">(comma-separated)</span></label>
            <input type="text" name="tags" id="tags" class="field-input"
                   placeholder="e.g., pasta, Italian, comfort food, weeknight dinner"
                   value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : '') }}">
            <p style="font-size:.75rem; color:#b8afa3; margin-top:.35rem;">Tags help readers discover your post when they search specific ingredients or topics.</p>
            @error('tags')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        {{-- COVER IMAGE --}}
        <div style="margin-bottom:1.5rem;">
            <label for="cover_image_url" class="field-label">Cover Image URL</label>
            <input type="url" name="cover_image_url" id="cover_image_url" class="field-input"
                   placeholder="https://unsplash.com/…"
                   value="{{ old('cover_image_url', $blog->cover_image_url) }}"
                   oninput="previewImage(this.value)">
            <p style="font-size:.75rem; color:#b8afa3; margin-top:.35rem;">Leave blank for a default food image. Use Unsplash, Pexels, or any direct image link.</p>
            @error('cover_image_url')<p class="field-error">{{ $message }}</p>@enderror
            {{-- Preview --}}
            <div id="imgPreview" style="display:{{ $blog->cover_image_url ? 'block' : 'none' }}; margin-top:.8rem; border-radius:.75rem; overflow:hidden; height:200px;">
                <img id="previewImg" src="{{ $blog->cover_image_url }}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">
            </div>
        </div>

        {{-- CONTENT --}}
        <div style="margin-bottom:1.5rem;">
            <label for="content" class="field-label">Your Story</label>
            <textarea name="content" id="content" rows="14" class="field-input"
                      style="resize:vertical; line-height:1.75; font-size:.95rem;"
                      placeholder="Take us on a journey — describe the dish, its origins, personal memories, cooking tips or the culture behind it…" required>{{ old('content', $blog->content) }}</textarea>
            @error('content')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        {{-- ACTIONS --}}
        <div style="display:flex; justify-content:flex-end; gap:1rem; padding-top:1.2rem; border-top:1px solid #ede6d8;">
            <a href="{{ route('profile.edit') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-gold" style="padding:.7rem 2rem; font-size:.95rem;">
                Update Story
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(url) {
    const preview = document.getElementById('imgPreview');
    const img     = document.getElementById('previewImg');
    if (url && url.startsWith('http')) {
        img.src = url;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
</script>

@endsection
