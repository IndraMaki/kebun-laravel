@extends('layouts.admin')

@section('content')
        <div class="max-w-5xl mx-auto">
            @if (session('status'))
                <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">{{ session('status') }}</div>
            @endif
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold">Nama Tanaman</h1>
                <a href="{{ route('nama.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Tambah Nama</a>
            </div>
            <div class="overflow-x-auto bg-white rounded border">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 py-2">Nama</th>
                            <th class="text-left px-4 py-2">Kategori</th>
                            <th class="text-right px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($names as $name)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $name->name }}</td>
                                <td class="px-4 py-2">{{ optional($name->category)->name }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('nama.edit', $name) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                                    <form action="{{ route('nama.destroy', $name) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">Belum ada nama</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection

