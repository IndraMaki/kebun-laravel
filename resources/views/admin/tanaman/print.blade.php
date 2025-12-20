<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cetak {{ $plant->name }}</title>
        <style>
            @page { size: 25cm 15cm; margin: 0; }
            html, body { height: 100%; }
            .sheet {
                width: 25cm;
                height: 15cm;
                margin: 0 auto;
                position: relative;
                background: #fff;
                box-shadow: 0 0 0 1px #e5e7eb inset;
                padding: 1cm 1.2cm;
                display: flex;
                flex-direction: column;
                gap: 0.6cm;
            }
            .header { position: relative; }
            .logo-left, .logo-right { position: absolute; top: 0; width: 2.2cm; height: 2.2cm; object-fit: contain; }
            .logo-left { left: 0; }
            .logo-right { right: 0; }
            .row { display: flex; gap: 1cm; align-items: flex-start; }
            .qr { width: 6cm; height: 6cm; border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
            .plant-name { font-size: 28pt; font-weight: 600; line-height: 1.1; }
            .latin { font-size: 14pt; color: #6b7280; font-style: italic; margin-top: 0.2cm; }
            @media print { .no-print { display: none; } body { margin: 0; } .sheet { box-shadow: none; } }
        </style>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-white">
        <div class="sheet">
            <div class="header" style="height:2.2cm;">
                @php
                    $leftCandidates = [
                        'images/logo_kementan.png',
                        'images/logo-left.png',
                    ];
                    $rightCandidates = [
                        'images/logo_brmp.png',
                        'images/logo_taman.png',
                    ];
                    $logoLeft = null;
                    foreach ($leftCandidates as $p) { if (file_exists(public_path($p))) { $logoLeft = $p; break; } }
                    $logoRight = null;
                    foreach ($rightCandidates as $p) { if (file_exists(public_path($p))) { $logoRight = $p; break; } }
                @endphp
                @if($logoLeft)
                    <img src="{{ asset($logoLeft) }}" alt="Logo kiri" class="logo-left">
                @else
                    <div class="logo-left" style="display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:6px;color:#6b7280;font-size:12px;">Logo</div>
                @endif
                @if($logoRight)
                    <img src="{{ asset($logoRight) }}" alt="Logo kanan" class="logo-right">
                @else
                    <div class="logo-right" style="display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:6px;color:#6b7280;font-size:12px;">Logo</div>
                @endif
            </div>

            <div class="row">
                <div style="flex:1">
                    <div class="plant-name">{{ $plant->name }}</div>
                    @if($plant->latin_name)
                        <div class="latin">{{ $plant->latin_name }}</div>
                    @endif
                    <div style="margin-top:0.6cm" class="text-sm text-gray-700">Scan untuk lihat detail tanaman</div>
                    <div class="text-xs text-gray-500 mt-1">{{ route('user.tanaman.show', $plant) }}</div>
                </div>
                <div class="qr">
                    @if($plant->qr_code_path)
                        <img src="{{ $plant->qr_code_path }}" alt="QR {{ $plant->name }}" style="max-width:100%;max-height:100%;object-fit:contain;border-radius:4px;" />
                    @else
                        <div class="text-gray-500 text-sm">QR tidak tersedia</div>
                    @endif
                </div>
            </div>

            <div class="no-print" style="margin-top:auto;">
                <button onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white rounded">Print / Simpan PDF</button>
            </div>
        </div>
    </body>
</html>