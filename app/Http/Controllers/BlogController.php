<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    // All available categories
    public static array $categories = [
        'Italian'           => '🍝',
        'Asian'             => '🍜',
        'Mexican'           => '🌮',
        'Indian'            => '🍛',
        'French'            => '🥐',
        'Mediterranean'     => '🫒',
        'American'          => '🍔',
        'Middle Eastern'    => '🧆',
        'Japanese'          => '🍱',
        'Thai'              => '🍲',
        'Baking & Pastry'   => '🥧',
        'Vegan & Plant-Based' => '🥗',
        'Street Food'       => '🌯',
        'Desserts'          => '🍰',
        'Breakfast & Brunch'=> '🥞',
        'Seafood'           => '🦞',
        'BBQ & Grilling'    => '🔥',
        'Drinks & Cocktails'=> '🍹',
        'Food Science'      => '🔬',
        'Tips & Techniques' => '🔪',
        'Meal Planning'     => '📅',
        'Food Travel'       => '✈️',
        'Personal Stories'  => '📖',
    ];

    public function index(Request $request)
    {
        $featuredBlog = Blog::orderBy('likes', 'desc')->first();

        $query = Blog::query();

        // Exclude featured from the grid
        if ($featuredBlog) {
            $query->where('_id', '!=', $featuredBlog->_id);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Full-text search (title + content)
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'regex', "/$term/i")
                  ->orWhere('content', 'regex', "/$term/i")
                  ->orWhere('tags', 'elemMatch', ['$regex' => $term, '$options' => 'i']);
            });
        }

        // Sort
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'likes':
                $query->orderBy('likes', 'desc');
                break;
            case 'read_time':
                $query->orderBy('read_time_min', 'asc');
                break;
            default: // newest
                $query->latest();
        }

        $blogs = $query->get();

        return view('blogs.index', compact('blogs', 'featuredBlog'))
            ->with('categories', self::$categories)
            ->with('currentSort', $request->get('sort', 'newest'))
            ->with('currentCategory', $request->get('category', ''))
            ->with('currentSearch', $request->get('search', ''));
    }

    public function show(string $id)
    {
        $blog     = Blog::findOrFail($id);
        $related  = Blog::where('category', $blog->category)
                        ->where('_id', '!=', $blog->_id)
                        ->latest()
                        ->limit(3)
                        ->get();

        return view('blogs.show', compact('blog', 'related'))
            ->with('categories', self::$categories);
    }

    public function create()
    {
        return view('blogs.create')->with('categories', self::$categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string',
            'tags'           => 'nullable|string',
            'content'        => 'required|string',
            'cover_image_url'=> 'nullable|url',
            'read_time_min'  => 'required|integer|min:1',
        ]);

        // Parse comma-separated tags
        $tags = [];
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_filter($tags);
        }

        Blog::create([
            'title'          => $request->title,
            'category'       => $request->category,
            'tags'           => array_values($tags),
            'content'        => $request->content,
            'cover_image_url'=> $request->cover_image_url
                ?? 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1200&q=80',
            'read_time_min'  => $request->read_time_min,
            'likes'          => 0,
            'user_id'        => auth()->id(),
            'liked_by'       => [],
        ]);

        return redirect()->route('blogs.index')->with('success', 'Your story has been published!');
    }

    public function like(string $id)
    {
        $blog = Blog::findOrFail($id);
        $userId = auth()->id();
        
        $likedBy = $blog->liked_by ?? [];
        if (!in_array($userId, $likedBy)) {
            $likedBy[] = $userId;
            $blog->liked_by = $likedBy;
            $blog->likes = count($likedBy);
            $blog->save();
        } else {
            $likedBy = array_diff($likedBy, [$userId]);
            $blog->liked_by = array_values($likedBy);
            $blog->likes = count($blog->liked_by);
            $blog->save();
        }
        
        return response()->json(['likes' => $blog->likes]);
    }

    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->user_id !== auth()->id()) abort(403);
        
        return view('blogs.edit', compact('blog'))->with('categories', self::$categories);
    }

    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->user_id !== auth()->id()) abort(403);

        $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string',
            'tags'           => 'nullable|string',
            'content'        => 'required|string',
            'cover_image_url'=> 'nullable|url',
            'read_time_min'  => 'required|integer|min:1',
        ]);

        $tags = [];
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_filter($tags);
        }

        $blog->update([
            'title'          => $request->title,
            'category'       => $request->category,
            'tags'           => array_values($tags),
            'content'        => $request->content,
            'cover_image_url'=> $request->cover_image_url ?: $blog->cover_image_url,
            'read_time_min'  => $request->read_time_min,
        ]);

        return redirect()->route('blogs.show', $blog->_id)->with('success', 'Blog updated successfully!');
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->user_id !== auth()->id()) abort(403);
        
        $blog->delete();
        return redirect()->route('profile.edit')->with('success', 'Blog deleted successfully!');
    }
}
