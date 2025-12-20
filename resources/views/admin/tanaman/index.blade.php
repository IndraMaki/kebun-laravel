@extends('layouts.admin')

@section('content')
        <div class="max-w-5xl mx-auto">
            @if (session('status'))
                <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">{{ session('status') }}</div>
            @endif
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold">Tanaman</h1>
                <a href="{{ route('tanaman.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Tambah Tanaman</a>
            </div>
            <div class="overflow-x-auto bg-white rounded border">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 py-2">Nama</th>
                            <th class="text-left px-4 py-2">Nama Latin</th>
                            <th class="text-left px-4 py-2">Kategori</th>
                            <th class="text-left px-4 py-2">QR</th>
                            <th class="text-right px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($plants as $plant)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <a href="{{ route('user.tanaman.show', $plant) }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $plant->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">{{ $plant->latin_name }}</td>
                                <td class="px-4 py-2">{{ $plant->category?->name }}</td>
                                <td class="px-4 py-2">
                                    @if($plant->qr_code_path)
                                        <a href="{{ $plant->qr_code_path }}" target="_blank" class="inline-block">
                                            <img src="{{ $plant->qr_code_path }}" alt="QR {{ $plant->name }}" class="h-10 w-10 object-contain border rounded">
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-sm">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('tanaman.edit', $plant) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                                    <a href="{{ route('tanaman.print', $plant) }}" target="_blank" class="px-3 py-1 bg-gray-800 text-white rounded">Cetak</a>
                                    <form action="{{ route('tanaman.destroy', $plant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t">
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada tanaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection