@extends('layouts.admin')

@section('content')
        <div class="max-w-xl mx-auto">
            <h1 class="text-xl font-semibold mb-4">Tambah Varietas</h1>
            <form action="{{ route('varietas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-1">Kategori</label>
                    <select id="categorySelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Nama</label>
                    <select name="plant_name_id" id="plantSelect" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Nama</option>
                    </select>
                    @error('plant_name_id')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Nama Varietas</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
                    @error('name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    <a href="{{ route('varietas.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                </div>
            </form>
        </div>

        <script>
            const categorySelect = document.getElementById('categorySelect');
            const plantSelect = document.getElementById('plantSelect');

            async function loadPlants(categoryId) {
                plantSelect.innerHTML = '<option value=\"\">Memuat nama...</option>';
                if (!categoryId) {
                    plantSelect.innerHTML = '<option value=\"\">Pilih Nama</option>';
                    return;
                }
                try {
                    const res = await fetch(`/admin/api/plants-by-category/${categoryId}`);
                    const data = await res.json();
                    plantSelect.innerHTML = '<option value=\"\">Pilih Nama</option>';
                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.id;
                        opt.textContent = p.name;
                        plantSelect.appendChild(opt);
                    });
                } catch (e) {
                    plantSelect.innerHTML = '<option value=\"\">Gagal memuat tanaman</option>';
                }
            }

            if (categorySelect) {
                categorySelect.addEventListener('change', (e) => {
                    loadPlants(e.target.value);
                });
            }
        </script>
@endsection
