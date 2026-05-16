<?php

namespace App\Http\Controllers;

use App\Mail\RecipeAddedMail;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::latest()->get();

        $search = trim((string) $request->query('search', ''));

        if ($search !== '') {
            $needle = Str::lower($search);

            $recipes = $recipes->filter(function ($recipe) use ($needle) {
                $haystack = Str::lower(implode(' ', array_filter([
                    $recipe->title,
                    $recipe->origin,
                    $recipe->description,
                ])));

                return Str::contains($haystack, $needle);
            })->values();
        }

        return view('dashboard', compact('recipes'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'ingredients' => 'required',
            'process' => 'required',
            'origin' => 'required',
            'rating' => 'required',
            'image' => 'required|url',
        ]);

        Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'process' => $request->process,
            'origin' => $request->origin,
            'rating' => $request->rating,
            'image' => $request->image,
        ]);

        Mail::to('pathaniadeepti05@gmail.com')->send(new RecipeAddedMail($request->title));

        return redirect('/')->with('success', 'Recipe Added Successfully');
    }

    public function show($id)
    {
        $recipe = Recipe::find($id);

        return view('show', compact('recipe'));
    }

    public function edit($id)
    {
        $recipe = Recipe::find($id);

        return view('edit', compact('recipe'));
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'ingredients' => 'required',
            'process' => 'required',
            'origin' => 'required',
            'rating' => 'required',
            'image' => 'nullable|url',
        ]);

        if ($request->filled('image')) {
            $recipe->image = $request->image;
        }

        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->ingredients = $request->ingredients;
        $recipe->process = $request->process;
        $recipe->origin = $request->origin;
        $recipe->rating = $request->rating;

        $recipe->save();

        return redirect('/')->with('success', 'Recipe Updated Successfully');
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if ($recipe) {
            $recipe->delete();
        }

        return redirect('/')->with('success', 'Recipe Deleted Successfully');
    }

    public function sort($origin)
    {
        $recipes = Recipe::where('origin', $origin)->get();

        return view('home', compact('recipes'));
    }
}
