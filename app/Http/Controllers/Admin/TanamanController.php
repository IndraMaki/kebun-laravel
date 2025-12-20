<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class TanamanController extends Controller
{
    public function index()
    {
        $plants = Plant::with('category')->orderBy('name')->get();
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
            'name' => 'required|string|max:255',
            'latin_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'care' => 'nullable|string',
            'main_photo' => 'nullable|image|max:4096',
            'category_id' => 'required|exists:categories,id',
        ]);
        $data = $validated;

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
        return view('admin.tanaman.edit', [
            'plant' => $tanaman,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Plant $tanaman)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latin_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'care' => 'nullable|string',
            'main_photo' => 'nullable|image|max:4096',
            'category_id' => 'required|exists:categories,id',
        ]);
        $data = $validated;

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
}