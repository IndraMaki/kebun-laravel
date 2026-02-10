@extends('layouts.admin')

@section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="text-xl font-semibold mb-4">Edit Tanaman</h1>
            <form action="{{ route('tanaman.update', $plant) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm mb-1">Nama Latin</label>
                    <input type="text" name="latin_name" value="{{ old('latin_name', $plant->latin_name) }}" class="w-full border rounded px-3 py-2">
                    @error('latin_name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Kategori</label>
                    <select id="categorySelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(optional($plant->plantName)->category_id == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Nama</label>
                    <select name="plant_name_id" id="plantNameSelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Nama</option>
                        @foreach ($plantNames as $name)
                            <option value="{{ $name->id }}" @selected(optional($plant->plantName)->id == $name->id)>{{ $name->name }}</option>
                        @endforeach
                    </select>
                    @error('plant_name_id')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Varietas</label>
                    <select name="variety_id" id="varietySelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Varietas</option>
                        @foreach ($varieties as $variety)
                            <option value="{{ $variety->id }}" @selected(optional($plant->variety)->id == $variety->id)>{{ $variety->name }}</option>
                        @endforeach
                    </select>
                    @error('variety_id')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $plant->description) }}</textarea>
                    @error('description')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Manfaat</label>
                    <textarea name="benefits" rows="4" class="w-full border rounded px-3 py-2">{{ old('benefits', $plant->benefits) }}</textarea>
                    @error('benefits')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Keunggulan</label>
                    <textarea name="advantages" rows="4" class="w-full border rounded px-3 py-2">{{ old('advantages', $plant->advantages) }}</textarea>
                    @error('advantages')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Perawatan</label>
                    <textarea name="care" rows="4" class="w-full border rounded px-3 py-2">{{ old('care', $plant->care) }}</textarea>
                    @error('care')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Foto Utama</label>
                    <input type="file" name="main_photo" accept="image/*" class="w-full border rounded px-3 py-2">
                    @error('main_photo')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    <a href="{{ route('tanaman.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                </div>
            </form>
            @if($plant->qr_code_path)
                <div class="mt-6">
                    <div class="text-sm text-gray-500 mb-2">QR Code</div>
                    <a href="{{ $plant->qr_code_path }}" target="_blank" class="inline-block">
                        <img src="{{ $plant->qr_code_path }}" alt="QR {{ $plant->name }}" class="h-40 w-40 object-contain border rounded">
                    </a>
                </div>
            @endif
        </div>
        <script>
            const categorySelect = document.getElementById('categorySelect');
            const plantNameSelect = document.getElementById('plantNameSelect');
            const varietySelect = document.getElementById('varietySelect');

            async function loadPlantNames(categoryId, selectedId) {
                plantNameSelect.innerHTML = '<option value="">Memuat nama...</option>';
                varietySelect.innerHTML = '<option value="">Pilih Varietas</option>';
                if (!categoryId) {
                    plantNameSelect.innerHTML = '<option value="">Pilih Nama</option>';
                    return;
                }
                try {
                    const res = await fetch(`/admin/api/plants-by-category/${categoryId}`);
                    const data = await res.json();
                    plantNameSelect.innerHTML = '<option value="">Pilih Nama</option>';
                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.id;
                        opt.textContent = p.name;
                        if (selectedId && Number(selectedId) === Number(p.id)) {
                            opt.selected = true;
                        }
                        plantNameSelect.appendChild(opt);
                    });
                } catch (e) {
                    plantNameSelect.innerHTML = '<option value="">Gagal memuat nama</option>';
                }
            }

            async function loadVarieties(plantNameId, selectedId) {
                varietySelect.innerHTML = '<option value="">Memuat varietas...</option>';
                if (!plantNameId) {
                    varietySelect.innerHTML = '<option value="">Pilih Varietas</option>';
                    return;
                }
                try {
                    const res = await fetch(`/admin/api/varieties-by-plant-name/${plantNameId}`);
                    const data = await res.json();
                    varietySelect.innerHTML = '<option value="">Pilih Varietas</option>';
                    data.forEach(v => {
                        const opt = document.createElement('option');
                        opt.value = v.id;
                        opt.textContent = v.name;
                        if (selectedId && Number(selectedId) === Number(v.id)) {
                            opt.selected = true;
                        }
                        varietySelect.appendChild(opt);
                    });
                } catch (e) {
                    varietySelect.innerHTML = '<option value="">Gagal memuat varietas</option>';
                }
            }

            if (categorySelect) {
                categorySelect.addEventListener('change', (e) => {
                    loadPlantNames(e.target.value, null);
                });
            }
            if (plantNameSelect) {
                plantNameSelect.addEventListener('change', (e) => {
                    loadVarieties(e.target.value, null);
                });
            }
        </script>
@endsection
