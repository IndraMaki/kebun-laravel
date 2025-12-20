<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $plant->name }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white min-h-screen text-[#111827]">
        <div class="max-w-4xl mx-auto p-6">
            <div class="bg-[#ECFDF5] rounded-lg shadow-sm p-6 md:p-8">
            <div class="text-center mb-6">
                <div class="text-3xl font-semibold">{{ $plant->name }}</div>
                @if($plant->latin_name)
                    <div class="text-gray-500">{{ $plant->latin_name }}</div>
                @endif
                @if($plant->category)
                    <div class="text-sm text-gray-600 mt-1">Kategori: {{ $plant->category->name }}</div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <div>
                    @if($plant->main_photo_url)
                        <img src="{{ $plant->main_photo_url }}" alt="{{ $plant->name }}" class="w-full aspect-square object-cover rounded border" />
                    @else
                        <div class="w-full aspect-square rounded border bg-gray-200"></div>
                    @endif

                    <div class="mt-4 space-x-3">
                        @if($plant->benefits)
                            <button id="btnBenefits" class="px-4 py-2 bg-black text-white rounded">Manfaat →</button>
                        @endif
                        @if($plant->care)
                            <button id="btnCare" class="px-4 py-2 bg-black text-white rounded">Perawatan →</button>
                        @endif
                    </div>
                </div>

                <div>
                    @if($plant->description)
                        <div class="text-lg font-medium mb-2">Deskripsi</div>
                        <div class="leading-relaxed whitespace-pre-line">{{ $plant->description }}</div>
                    @else
                        <div class="text-gray-500">Tidak ada deskripsi</div>
                    @endif

                </div>
            </div>
            </div>

            <div id="modalBenefits" class="fixed inset-0 hidden">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative max-w-xl mx-auto mt-24 bg-white rounded shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-lg font-semibold">Manfaat</div>
                        <button id="closeBenefits" class="px-3 py-1 rounded bg-gray-200">Tutup</button>
                    </div>
                    <div class="leading-relaxed whitespace-pre-line">{{ $plant->benefits }}</div>
                </div>
            </div>

            <div id="modalCare" class="fixed inset-0 hidden">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative max-w-xl mx-auto mt-24 bg-white rounded shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-lg font-semibold">Perawatan</div>
                        <button id="closeCare" class="px-3 py-1 rounded bg-gray-200">Tutup</button>
                    </div>
                    <div class="leading-relaxed whitespace-pre-line">{{ $plant->care }}</div>
                </div>
            </div>
        </div>

        <script>
            const btnBenefits = document.getElementById('btnBenefits');
            const btnCare = document.getElementById('btnCare');
            const modalBenefits = document.getElementById('modalBenefits');
            const modalCare = document.getElementById('modalCare');
            const closeBenefits = document.getElementById('closeBenefits');
            const closeCare = document.getElementById('closeCare');
            if (btnBenefits) btnBenefits.addEventListener('click', () => modalBenefits.classList.remove('hidden'));
            if (btnCare) btnCare.addEventListener('click', () => modalCare.classList.remove('hidden'));
            if (closeBenefits) closeBenefits.addEventListener('click', () => modalBenefits.classList.add('hidden'));
            if (closeCare) closeCare.addEventListener('click', () => modalCare.classList.add('hidden'));
            [modalBenefits, modalCare].forEach(m => { if (m) m.addEventListener('click', e => { if (e.target === m) m.classList.add('hidden'); }); });
        </script>
    </body>
</html>