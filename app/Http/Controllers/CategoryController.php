<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()
            ->paginate(20);
    
        return view(
            'categories.index',
            compact('categories')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'categories.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
    
            'name' => 'required'
    
        ]);
    
        Category::create([
    
            'name' => $request->name,
    
            'is_active' =>
                $request->has('is_active')
    
        ]);
    
        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category Created Successfully'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $category->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);
    
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
{
    $category->delete();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category Deleted Successfully');
}
}
