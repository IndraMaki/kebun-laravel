<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PlantName;
use Illuminate\Http\Request;

class NamaController extends Controller
{
    public function index()
    {
        $names = PlantName::with('category')->orderBy('name')->get();
        return view('admin.nama.index', compact('names'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.nama.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        PlantName::create($validated);

        return redirect()->route('nama.index')->with('status', 'Nama tanaman berhasil dibuat');
    }

    public function edit(PlantName $nama)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.nama.edit', [
            'nameModel' => $nama,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, PlantName $nama)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $nama->update($validated);

        return redirect()->route('nama.index')->with('status', 'Nama tanaman berhasil diperbarui');
    }

    public function destroy(PlantName $nama)
    {
        $nama->delete();

        return redirect()->route('nama.index')->with('status', 'Nama tanaman berhasil dihapus');
    }
}

