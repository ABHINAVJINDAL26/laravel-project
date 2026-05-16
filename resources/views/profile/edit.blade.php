@extends('layouts.app')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem 0;">

    <div style="margin-bottom:3rem; text-align:center;">
        <p style="font-size:.75rem; letter-spacing:.2em; text-transform:uppercase; color:var(--gold); font-weight:600; margin-bottom:.5rem;">✦ Welcome Back</p>
        <h1 class="serif" style="font-size:2.8rem; font-weight:600; color:var(--ink); line-height:1.1; margin-bottom:.6rem;">
            {{ $user->name }}'s Profile
        </h1>
        <div style="margin-top:1rem;">
            <a href="{{ route('recipes.create') }}" class="btn-gold" style="padding:.6rem .9rem; border-radius:.6rem;">Share a Recipe</a>
        </div>
    </div>

    {{-- WRITTEN BLOGS --}}
    <div style="margin-bottom:4rem;">
        <h2 class="serif" style="font-size:1.8rem; font-weight:600; color:var(--ink); margin-bottom:1.5rem; padding-bottom:.5rem; border-bottom:1px solid var(--border-light);">
            Your Stories
        </h2>
        @if($writtenBlogs->isNotEmpty())
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(310px,1fr)); gap:1.5rem;">
                @foreach($writtenBlogs as $blog)
                <article class="card" style="position:relative;">
                    <img src="{{ $blog->cover_image_url }}" alt="{{ $blog->title }}" class="card-img" style="height:160px;">
                    <div class="card-body">
                        <h3 class="card-title" style="font-size:1.15rem;">{{ $blog->title }}</h3>
                        <p class="card-excerpt" style="font-size:.8rem;">{{ Str::limit($blog->content, 80) }}</p>

                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1rem; border-top:1px solid #f0e8da; padding-top:.8rem;">
                            <span class="card-meta">❤️ {{ $blog->likes ?? 0 }} likes</span>
                            <div style="display:flex; gap:.5rem;">
                                <a href="{{ route('blogs.edit', $blog->_id) }}" class="btn-outline" style="padding:.3rem .8rem; font-size:.7rem;">Edit</a>
                                <form action="{{ route('blogs.destroy', $blog->_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this story?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline" style="padding:.3rem .8rem; font-size:.7rem; color:#c0392b; border-color:#eab8b4;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        @else
            <div style="background:var(--card-bg); border-radius:1rem; padding:3rem; text-align:center; border:1px dashed var(--border-light);">
                <p style="color:var(--warm-gray); margin-bottom:1rem;">You haven't written any stories yet.</p>
                <a href="{{ route('blogs.create') }}" class="btn-gold">Write a Story</a>
            </div>
        @endif
    </div>

    {{-- LIKED BLOGS --}}
    <div style="margin-bottom:4rem;">
        <h2 class="serif" style="font-size:1.8rem; font-weight:600; color:var(--ink); margin-bottom:1.5rem; padding-bottom:.5rem; border-bottom:1px solid var(--border-light);">
            Stories You Liked
        </h2>
        @if($likedBlogs->isNotEmpty())
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:1.5rem;">
                @foreach($likedBlogs as $blog)
                <article class="card" onclick="window.location='{{ route('blogs.show', $blog->_id) }}'" style="cursor:pointer;">
                    <img src="{{ $blog->cover_image_url }}" alt="{{ $blog->title }}" class="card-img" style="height:120px;">
                    <div class="card-body" style="padding:1rem;">
                        <h3 class="card-title" style="font-size:1rem; margin-bottom:.3rem;">{{ $blog->title }}</h3>
                        <span class="card-meta" style="font-size:.7rem;">❤️ {{ $blog->likes ?? 0 }} likes</span>
                    </div>
                </article>
                @endforeach
            </div>
        @else
            <div style="background:var(--card-bg); border-radius:1rem; padding:3rem; text-align:center; border:1px dashed var(--border-light);">
                <p style="color:var(--warm-gray);">You haven't liked any stories yet.</p>
            </div>
        @endif
    </div>

    {{-- SETTINGS --}}
    <div>
        <h2 class="serif" style="font-size:1.8rem; font-weight:600; color:var(--ink); margin-bottom:1.5rem; padding-bottom:.5rem; border-bottom:1px solid var(--border-light);">
            Account Settings
        </h2>

        <div style="display:grid; grid-template-columns:1fr; gap:2rem;">

            {{-- Update Profile Info --}}
            <div style="background:var(--card-bg); border-radius:1.4rem; padding:2rem; border:1px solid var(--border-light); box-shadow:0 4px 24px rgba(26,18,9,.04);">
                <h3 class="serif" style="font-size:1.4rem; font-weight:600; color:var(--ink); margin-bottom:.5rem;">Profile Information</h3>
                <p style="color:var(--warm-gray); font-size:.85rem; margin-bottom:1.5rem;">Update your account's profile information and email address.</p>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div style="margin-bottom:1.2rem;">
                        <label for="name" class="field-label">Name</label>
                        <input id="name" name="name" type="text" class="field-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @error('name') <span style="color:#c0392b; font-size:.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <div style="margin-bottom:1.5rem;">
                        <label for="email" class="field-label">Email</label>
                        <input id="email" name="email" type="email" class="field-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @error('email') <span style="color:#c0392b; font-size:.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-gold">Save Changes</button>
                    @if (session('status') === 'profile-updated')
                        <span style="color:var(--gold-dark); font-size:.8rem; margin-left:.5rem;">Saved.</span>
                    @endif
                </form>
            </div>

            {{-- Update Password --}}
            <div style="background:var(--card-bg); border-radius:1.4rem; padding:2rem; border:1px solid var(--border-light); box-shadow:0 4px 24px rgba(26,18,9,.04);">
                <h3 class="serif" style="font-size:1.4rem; font-weight:600; color:var(--ink); margin-bottom:.5rem;">Update Password</h3>
                <p style="color:var(--warm-gray); font-size:.85rem; margin-bottom:1.5rem;">Ensure your account is using a long, random password to stay secure.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div style="margin-bottom:1.2rem;">
                        <label for="update_password_current_password" class="field-label">Current Password</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="field-input" autocomplete="current-password" />
                        @error('current_password', 'updatePassword') <span style="color:#c0392b; font-size:.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <div style="margin-bottom:1.2rem;">
                        <label for="update_password_password" class="field-label">New Password</label>
                        <input id="update_password_password" name="password" type="password" class="field-input" autocomplete="new-password" />
                        @error('password', 'updatePassword') <span style="color:#c0392b; font-size:.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <div style="margin-bottom:1.5rem;">
                        <label for="update_password_password_confirmation" class="field-label">Confirm Password</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="field-input" autocomplete="new-password" />
                        @error('password_confirmation', 'updatePassword') <span style="color:#c0392b; font-size:.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-gold">Update Password</button>
                    @if (session('status') === 'password-updated')
                        <span style="color:var(--gold-dark); font-size:.8rem; margin-left:.5rem;">Saved.</span>
                    @endif
                </form>
            </div>

            {{-- Delete Account --}}
            <div style="background:var(--card-bg); border-radius:1.4rem; padding:2rem; border:1px solid #eab8b4; box-shadow:0 4px 24px rgba(26,18,9,.04);">
                <h3 class="serif" style="font-size:1.4rem; font-weight:600; color:#c0392b; margin-bottom:.5rem;">Delete Account</h3>
                <p style="color:var(--warm-gray); font-size:.85rem; margin-bottom:1.5rem;">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

                <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    @method('delete')
                    <div style="margin-bottom:1.5rem;">
                        <label for="password" class="field-label">Confirm Password</label>
                        <input id="password" name="password" type="password" class="field-input" placeholder="Password" />
                        @error('password', 'userDeletion') <span style="color:#c0392b; font-size:.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-outline" style="color:#c0392b; border-color:#eab8b4;">Delete Account</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
