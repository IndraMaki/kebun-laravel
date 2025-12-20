@extends('layouts.admin')

@section('content')
        <div>
            <h1 class="text-xl font-semibold mb-6">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border rounded-lg p-5">
                    <div class="text-sm text-gray-500">Total Tanaman</div>
                    <div class="text-3xl font-semibold mt-1">{{ $plantCount }}</div>
                </div>
                <div class="bg-white border rounded-lg p-5">
                    <div class="text-sm text-gray-500">Total Kategori</div>
                    <div class="text-3xl font-semibold mt-1">{{ $categoryCount }}</div>
                </div>
            </div>
        </div>
@endsection

