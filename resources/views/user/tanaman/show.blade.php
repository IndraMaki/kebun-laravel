<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php
            $plantName = optional($plant->plantName)->name ?? $plant->name;
            $varietyName = optional($plant->variety)->name;
            $fullTitle = $varietyName ? $plantName . ' - Varietas ' . $varietyName : $plantName;
        @endphp
        <title>{{ $fullTitle }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-b from-emerald-50/60 to-white min-h-screen text-slate-900">
        <div class="min-h-screen flex flex-col">
            <header class="border-b border-emerald-100/70 bg-white/70 backdrop-blur-sm">
                <div class="max-w-5xl mx-auto flex items-center justify-between px-4 sm:px-6 py-3 sm:py-4">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-sm font-semibold">
                            K
                        </div>
                        <div>
                            <div class="text-sm font-semibold tracking-tight">Kebun App</div>
                            <div class="text-xs text-slate-500">Informasi tanaman di genggaman</div>
                        </div>
                    </div>
                    <button type="button" onclick="history.back()" class="inline-flex items-center gap-1.5 text-xs sm:text-sm rounded-full border border-slate-200 bg-white px-3 py-1.5 text-slate-600 hover:border-emerald-400 hover:text-emerald-700 hover:bg-emerald-50 transition">
                        <span class="text-lg leading-none">←</span>
                        <span>Kembali</span>
                    </button>
                </div>
            </header>

            <main class="flex-1">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
                    <div class="bg-white/80 border border-emerald-100 rounded-2xl shadow-sm shadow-emerald-100/50 p-5 sm:p-7 lg:p-8">
                        <div class="flex flex-col gap-3 sm:gap-4 border-b border-emerald-50 pb-5 sm:pb-6">
                            <div class="inline-flex items-center gap-2 self-start rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Detail Tanaman
                            </div>
                            <div class="space-y-1.5">
                                <div class="text-2xl sm:text-3xl lg:text-4xl font-semibold tracking-tight text-slate-900">
                                    {{ $plantName }}
                                </div>
                                @if($varietyName)
                                    <div class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 text-xs sm:text-sm text-slate-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Varietas: <span class="font-semibold">{{ $varietyName }}</span>
                                    </div>
                                @endif
                                @if($plant->latin_name)
                                    <div class="mt-1 text-sm sm:text-base text-slate-500 italic">
                                        {{ $plant->latin_name }}
                                    </div>
                                @endif
                                @if($plant->category)
                                    <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs sm:text-sm text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Kategori: <span class="font-medium">{{ $plant->category->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 lg:mt-8 grid grid-cols-1 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] gap-6 lg:gap-8 items-start">
                            <div>
                                @if($plant->main_photo_url)
                                    <div class="overflow-hidden rounded-xl border border-emerald-100 bg-emerald-50/40 shadow-sm">
                                        <img
                                            src="{{ $plant->main_photo_url }}"
                                            alt="{{ $fullTitle }}"
                                            class="w-full h-full max-h-[420px] object-cover transition duration-300 ease-out hover:scale-[1.02]"
                                        />
                                    </div>
                                @else
                                    <div class="flex aspect-[4/3] w-full items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-sm text-slate-400">
                                        Belum ada foto untuk tanaman ini
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                        Deskripsi
                                    </div>
                                    <div class="mt-2 rounded-xl bg-emerald-50/60 border border-emerald-100 px-4 py-3 text-sm sm:text-base leading-relaxed text-slate-700">
                                        @if($plant->description)
                                            <div class="whitespace-pre-line">
                                                {{ $plant->description }}
                                            </div>
                                        @else
                                            <div class="text-slate-400">
                                                Tidak ada deskripsi untuk tanaman ini.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex flex-col sm:flex-row gap-3">
                            @if($plant->benefits)
                                <button
                                    id="btnBenefits"
                                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 active:bg-emerald-800 transition"
                                >
                                    <span>Manfaat</span>
                                    <span class="text-base leading-none">→</span>
                                </button>
                            @endif
                            @if($plant->advantages)
                                <button
                                    id="btnAdvantages"
                                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-full border border-emerald-200 bg-white px-4 py-2.5 text-sm font-medium text-emerald-700 hover:border-emerald-400 hover:bg-emerald-50 active:bg-emerald-100 transition"
                                >
                                    <span>Keunggulan</span>
                                    <span class="text-base leading-none">→</span>
                                </button>
                            @endif
                            @if($plant->care)
                                <button
                                    id="btnCare"
                                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-full border border-emerald-200 bg-white px-4 py-2.5 text-sm font-medium text-emerald-700 hover:border-emerald-400 hover:bg-emerald-50 active:bg-emerald-100 transition"
                                >
                                    <span>Perawatan</span>
                                    <span class="text-base leading-none">→</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </main>

            <div id="modalBenefits" class="fixed inset-0 z-50 hidden items-center justify-center px-4 sm:px-6 py-6 sm:py-8">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                <div class="relative z-10 max-w-lg w-full bg-white rounded-2xl shadow-2xl border border-emerald-100">
                    <div class="flex items-center justify-between px-5 sm:px-6 pt-4 pb-3 border-b border-slate-100">
                        <div class="text-sm font-semibold tracking-tight text-slate-900">
                            Manfaat {{ $plantName }}@if($varietyName) (Varietas {{ $varietyName }})@endif
                        </div>
                        <button id="closeBenefits" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-500 hover:bg-slate-50 active:bg-slate-100 transition">
                            Tutup
                        </button>
                    </div>
                    <div class="px-5 sm:px-6 py-4 max-h-[70vh] sm:max-h-[75vh] overflow-y-auto text-sm sm:text-base leading-relaxed text-slate-700">
                        <div class="whitespace-pre-line">
                            {{ $plant->benefits }}
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalCare" class="fixed inset-0 z-50 hidden items-center justify-center px-4 sm:px-6 py-6 sm:py-8">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                <div class="relative z-10 max-w-lg w-full bg-white rounded-2xl shadow-2xl border border-emerald-100">
                    <div class="flex items-center justify-between px-5 sm:px-6 pt-4 pb-3 border-b border-slate-100">
                        <div class="text-sm font-semibold tracking-tight text-slate-900">
                            Perawatan {{ $plantName }}@if($varietyName) (Varietas {{ $varietyName }})@endif
                        </div>
                        <button id="closeCare" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-500 hover:bg-slate-50 active:bg-slate-100 transition">
                            Tutup
                        </button>
                    </div>
                    <div class="px-5 sm:px-6 py-4 max-h-[70vh] sm:max-h-[75vh] overflow-y-auto text-sm sm:text-base leading-relaxed text-slate-700">
                        <div class="whitespace-pre-line">
                            {{ $plant->care }}
                        </div>
                    </div>
                </div>
            </div>

            @if($plant->advantages)
                <div id="modalAdvantages" class="fixed inset-0 z-50 hidden items-center justify-center px-4 sm:px-6 py-6 sm:py-8">
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                    <div class="relative z-10 max-w-lg w-full bg-white rounded-2xl shadow-2xl border border-emerald-100">
                        <div class="flex items-center justify-between px-5 sm:px-6 pt-4 pb-3 border-b border-slate-100">
                            <div class="text-sm font-semibold tracking-tight text-slate-900">
                                Keunggulan {{ $plantName }}@if($varietyName) (Varietas {{ $varietyName }})@endif
                            </div>
                            <button id="closeAdvantages" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-500 hover:bg-slate-50 active:bg-slate-100 transition">
                                Tutup
                            </button>
                        </div>
                        <div class="px-5 sm:px-6 py-4 max-h-[70vh] sm:max-h-[75vh] overflow-y-auto text-sm sm:text-base leading-relaxed text-slate-700">
                            <div class="whitespace-pre-line">
                                {{ $plant->advantages }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <script>
                const btnBenefits = document.getElementById('btnBenefits');
                const btnAdvantages = document.getElementById('btnAdvantages');
                const btnCare = document.getElementById('btnCare');
                const modalBenefits = document.getElementById('modalBenefits');
                const modalAdvantages = document.getElementById('modalAdvantages');
                const modalCare = document.getElementById('modalCare');
                const closeBenefits = document.getElementById('closeBenefits');
                const closeAdvantages = document.getElementById('closeAdvantages');
                const closeCare = document.getElementById('closeCare');
                if (btnBenefits) btnBenefits.addEventListener('click', () => modalBenefits.classList.remove('hidden'));
                if (btnAdvantages) btnAdvantages.addEventListener('click', () => modalAdvantages.classList.remove('hidden'));
                if (btnCare) btnCare.addEventListener('click', () => modalCare.classList.remove('hidden'));
                if (closeBenefits) closeBenefits.addEventListener('click', () => modalBenefits.classList.add('hidden'));
                if (closeAdvantages) closeAdvantages.addEventListener('click', () => modalAdvantages.classList.add('hidden'));
                if (closeCare) closeCare.addEventListener('click', () => modalCare.classList.add('hidden'));
                [modalBenefits, modalAdvantages, modalCare].forEach(m => { if (m) m.addEventListener('click', e => { if (e.target === m) m.classList.add('hidden'); }); });
            </script>
        </div>
    </body>
</html>
