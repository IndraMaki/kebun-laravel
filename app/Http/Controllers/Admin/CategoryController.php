<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil dibuat');
    }

    public function edit(Category $kategori)
    {
        return view('admin.kategori.edit', ['category' => $kategori]);
    }

    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $kategori->id,
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil dihapus');
    }
}