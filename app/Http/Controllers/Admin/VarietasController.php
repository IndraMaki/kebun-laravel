<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PlantName;
use App\Models\Variety;
use Illuminate\Http\Request;

class VarietasController extends Controller
{
    public function index()
    {
        $varieties = Variety::with(['plantName.category'])->orderBy('name')->get();
        return view('admin.varietas.index', compact('varieties'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.varietas.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant_name_id' => 'required|exists:plant_names,id',
            'name' => 'required|string|max:255',
        ]);

        Variety::create($validated);

        return redirect()->route('varietas.index')->with('status', 'Varietas berhasil dibuat');
    }

    public function edit(Variety $varieta)
    {
        $categories = Category::orderBy('name')->get();
        $selectedCategoryId = $varieta->plantName ? $varieta->plantName->category_id : null;
        $plants = $selectedCategoryId
            ? PlantName::where('category_id', $selectedCategoryId)->orderBy('name')->get()
            : collect();

        return view('admin.varietas.edit', [
            'variety' => $varieta,
            'categories' => $categories,
            'plants' => $plants,
            'selectedCategoryId' => $selectedCategoryId,
        ]);
    }

    public function update(Request $request, Variety $varieta)
    {
        $validated = $request->validate([
            'plant_name_id' => 'required|exists:plant_names,id',
            'name' => 'required|string|max:255',
        ]);

        $varieta->update($validated);

        return redirect()->route('varietas.index')->with('status', 'Varietas berhasil diperbarui');
    }

    public function destroy(Variety $varieta)
    {
        $varieta->delete();

        return redirect()->route('varietas.index')->with('status', 'Varietas berhasil dihapus');
    }
}
