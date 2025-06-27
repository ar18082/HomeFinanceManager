<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Auth::user()
            ->categories()
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Auth::user()
            ->categories()
            ->whereNull('parent_id')
            ->get();

        return view('categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(Category::TYPES)],
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $parent = Category::find($value);
                        if ($parent->user_id !== Auth::id()) {
                            $fail('La catégorie parente sélectionnée est invalide.');
                        }
                    }
                }
            ],
            'active' => 'boolean'
        ]);

        Auth::user()->categories()->create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $this->authorize('view', $category);

        $category->load(['parent', 'children', 'transactions' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        $parentCategories = Auth::user()
            ->categories()
            ->where('id', '!=', $category->id)
            ->whereNull('parent_id')
            ->get();

        return view('categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(Category::TYPES)],
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value) {
                        if ($value === $category->id) {
                            $fail('Une catégorie ne peut pas être sa propre catégorie parente.');
                            return;
                        }
                        $parent = Category::find($value);
                        if ($parent->user_id !== Auth::id()) {
                            $fail('La catégorie parente sélectionnée est invalide.');
                        }
                    }
                }
            ],
            'active' => 'boolean'
        ]);

        $category->update($validated);

        return redirect()->route('categories.show', $category)
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        // Vérifier si la catégorie a des transactions
        if ($category->transactions()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Cette catégorie contient des transactions et ne peut pas être supprimée.');
        }

        // Vérifier si la catégorie a des sous-catégories
        if ($category->children()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Cette catégorie contient des sous-catégories et ne peut pas être supprimée.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
