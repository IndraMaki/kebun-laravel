<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Category;
use App\Models\PlantName;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class TanamanController extends Controller
{
    public function index()
    {
        $plants = Plant::with(['category', 'plantName', 'variety'])->orderBy('name')->get();
        return view('admin.tanaman.index', compact('plants'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.tanaman.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant_name_id' => 'required|exists:plant_names,id',
            'variety_id' => 'required|exists:varieties,id',
            'latin_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'advantages' => 'nullable|string',
            'care' => 'nullable|string',
            'main_photo' => 'nullable|image|max:4096',
        ]);
        $data = $validated;

        $plantName = PlantName::with('category')->findOrFail($validated['plant_name_id']);
        $variety = Variety::where('id', $validated['variety_id'])
            ->where('plant_name_id', $plantName->id)
            ->firstOrFail();

        $data['name'] = $plantName->name.' '.$variety->name;
        $data['category_id'] = $plantName->category_id;
        $data['plant_name_id'] = $plantName->id;
        $data['variety_id'] = $variety->id;

        if ($request->hasFile('main_photo')) {
            $path = $request->file('main_photo')->store('plants', 'public');
            $data['main_photo_url'] = '/storage/'.$path;
        }

        $plant = Plant::create($data);

        $qrTargetUrl = route('user.tanaman.show', $plant);
        $qrResponse = Http::get('https://api.qrserver.com/v1/create-qr-code/', [
            'size' => '300x300',
            'data' => $qrTargetUrl,
        ]);
        if ($qrResponse->successful()) {
            $qrPath = 'qrcodes/plant-'.$plant->id.'.png';
            Storage::disk('public')->put($qrPath, $qrResponse->body());
            $plant->update(['qr_code_path' => '/storage/'.$qrPath]);
        }

        return redirect()->route('tanaman.index')->with('status', 'Tanaman berhasil dibuat');
    }

    public function edit(Plant $tanaman)
    {
        $categories = Category::orderBy('name')->get();
        $selectedPlantName = $tanaman->plantName;
        $selectedVariety = $tanaman->variety;
        $plantNames = $selectedPlantName
            ? PlantName::where('category_id', $selectedPlantName->category_id)->orderBy('name')->get()
            : collect();
        $varieties = $selectedPlantName
            ? Variety::where('plant_name_id', optional($selectedPlantName)->id)->orderBy('name')->get()
            : collect();
        return view('admin.tanaman.edit', [
            'plant' => $tanaman,
            'categories' => $categories,
            'plantNames' => $plantNames,
            'varieties' => $varieties,
        ]);
    }

    public function update(Request $request, Plant $tanaman)
    {
        $validated = $request->validate([
            'plant_name_id' => 'required|exists:plant_names,id',
            'variety_id' => 'required|exists:varieties,id',
            'latin_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'advantages' => 'nullable|string',
            'care' => 'nullable|string',
            'main_photo' => 'nullable|image|max:4096',
        ]);
        $data = $validated;

        $plantName = PlantName::with('category')->findOrFail($validated['plant_name_id']);
        $variety = Variety::where('id', $validated['variety_id'])
            ->where('plant_name_id', $plantName->id)
            ->firstOrFail();

        $data['name'] = $plantName->name.' '.$variety->name;
        $data['category_id'] = $plantName->category_id;
        $data['plant_name_id'] = $plantName->id;
        $data['variety_id'] = $variety->id;

        if ($request->hasFile('main_photo')) {
            $path = $request->file('main_photo')->store('plants', 'public');
            $data['main_photo_url'] = '/storage/'.$path;
        }

        $tanaman->update($data);

        if (!$tanaman->qr_code_path) {
            $qrTargetUrl = route('user.tanaman.show', $tanaman);
            $qrResponse = Http::get('https://api.qrserver.com/v1/create-qr-code/', [
                'size' => '300x300',
                'data' => $qrTargetUrl,
            ]);
            if ($qrResponse->successful()) {
                $qrPath = 'qrcodes/plant-'.$tanaman->id.'.png';
                Storage::disk('public')->put($qrPath, $qrResponse->body());
                $tanaman->update(['qr_code_path' => '/storage/'.$qrPath]);
            }
        }

        return redirect()->route('tanaman.index')->with('status', 'Tanaman berhasil diperbarui');
    }

    public function destroy(Plant $tanaman)
    {
        $tanaman->delete();
        return redirect()->route('tanaman.index')->with('status', 'Tanaman berhasil dihapus');
    }

    public function print(Plant $tanaman)
    {
        return view('admin.tanaman.print', ['plant' => $tanaman]);
    }

    public function plantNamesByCategory(Category $category)
    {
        return PlantName::where('category_id', $category->id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function varietiesByPlantName(PlantName $plantName)
    {
        return Variety::where('plant_name_id', $plantName->id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
