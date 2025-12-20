@extends('layouts.admin')

@section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="text-xl font-semibold mb-4">Tambah Tanaman</h1>
            <form action="{{ route('tanaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
                    @error('name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Nama Latin</label>
                    <input type="text" name="latin_name" value="{{ old('latin_name') }}" class="w-full border rounded px-3 py-2">
                    @error('latin_name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Kategori</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
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
@endsection