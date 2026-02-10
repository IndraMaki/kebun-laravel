<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18]">
        <div class="min-h-screen flex">
            <aside class="w-64 bg-white border-r">
                <div class="p-4 text-lg font-semibold">Admin</div>
                <nav class="space-y-1 p-2">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">Dashboard</a>
                    <a href="{{ route('kategori.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('kategori.*') ? 'bg-gray-100' : '' }}">Kategori</a>
                    <a href="{{ route('nama.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('nama.*') ? 'bg-gray-100' : '' }}">Nama</a>
                    <a href="{{ route('tanaman.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('tanaman.*') ? 'bg-gray-100' : '' }}">Tanaman</a>
                    <a href="{{ route('varietas.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('varietas.*') ? 'bg-gray-100' : '' }}">Varietas</a>
                </nav>
            </aside>
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </body>
</html>
