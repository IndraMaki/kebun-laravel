@extends('layouts.admin')

@section('content')
        <div class="max-w-md mx-auto">
            <h1 class="text-xl font-semibold mb-4">Edit Kategori</h1>
            <form action="{{ route('kategori.update', $category) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm mb-1">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded px-3 py-2">
                    @error('name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    <a href="{{ route('kategori.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                </div>
            </form>
        </div>
@endsection