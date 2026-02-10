@extends('layouts.admin')

@section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="text-xl font-semibold mb-4">Tambah Tanaman</h1>
            <form action="{{ route('tanaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-1">Nama Latin</label>
                    <input type="text" name="latin_name" value="{{ old('latin_name') }}" class="w-full border rounded px-3 py-2">
                    @error('latin_name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Kategori</label>
                    <select id="categorySelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Nama</label>
                    <select name="plant_name_id" id="plantNameSelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Nama</option>
                    </select>
                    @error('plant_name_id')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Varietas</label>
                    <select name="variety_id" id="varietySelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Varietas</option>
                    </select>
                    @error('variety_id')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Manfaat</label>
                    <textarea name="benefits" rows="4" class="w-full border rounded px-3 py-2">{{ old('benefits') }}</textarea>
                    @error('benefits')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Keunggulan</label>
                    <textarea name="advantages" rows="4" class="w-full border rounded px-3 py-2">{{ old('advantages') }}</textarea>
                    @error('advantages')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Perawatan</label>
                    <textarea name="care" rows="4" class="w-full border rounded px-3 py-2">{{ old('care') }}</textarea>
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
        </div>
        <script>
            const categorySelect = document.getElementById('categorySelect');
            const plantNameSelect = document.getElementById('plantNameSelect');
            const varietySelect = document.getElementById('varietySelect');

            async function loadPlantNames(categoryId) {
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
                        plantNameSelect.appendChild(opt);
                    });
                } catch (e) {
                    plantNameSelect.innerHTML = '<option value="">Gagal memuat nama</option>';
                }
            }

            async function loadVarieties(plantNameId) {
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
                        varietySelect.appendChild(opt);
                    });
                } catch (e) {
                    varietySelect.innerHTML = '<option value="">Gagal memuat varietas</option>';
                }
            }

            if (categorySelect) {
                categorySelect.addEventListener('change', (e) => {
                    loadPlantNames(e.target.value);
                });
            }
            if (plantNameSelect) {
                plantNameSelect.addEventListener('change', (e) => {
                    loadVarieties(e.target.value);
                });
            }
        </script>
@endsection
