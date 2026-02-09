<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cetak {{ $plant->name }}</title>
        <style>
            @page { size: 25cm 15cm; margin: 0; }
            html, body { height: 100%; }
            body { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
            .sheet {
                width: 25cm;
                height: 15cm;
                margin: 0 auto;
                position: relative;
                background: radial-gradient(circle at top left, #f0fdf4 0, #ffffff 45%);
                box-shadow: 0 0 0 1px #e5e7eb inset;
                padding: 1cm 1.5cm;
                display: flex;
                flex-direction: column;
                gap: 1cm;
            }
            .header {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                padding-bottom: 0.4cm;
                border-bottom: 1px solid #e5e7eb;
            }
            .logo-left,
            .logo-right {
                position: absolute;
                top: 0;
                width: 2.2cm;
                height: 2.2cm;
                object-fit: contain;
            }
            .logo-left { left: 0; }
            .logo-right { right: 0; }
            .brand-text {
                font-size: 11pt;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #047857;
            }
            .row {
                display: flex;
                gap: 1.4cm;
                align-items: center;
                flex: 1;
            }
            .details {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 0.5cm;
            }
            .name-block {
                padding-bottom: 0.3cm;
                border-bottom: 1px solid #e5e7eb;
            }
            .plant-name {
                font-size: 30pt;
                font-weight: 600;
                line-height: 1.1;
                color: #111827;
            }
            .latin {
                font-size: 15pt;
                color: #6b7280;
                font-style: italic;
                margin-top: 0.15cm;
            }
            .scan-block {
                font-size: 10pt;
                color: #374151;
            }
            .scan-label {
                font-weight: 500;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                font-size: 8.5pt;
                color: #059669;
            }
            .scan-url {
                margin-top: 0.1cm;
                font-size: 9pt;
                color: #6b7280;
            }
            .qr {
                width: 6cm;
                height: 6cm;
                border-radius: 16px;
                background: #ffffff;
                box-shadow: 0 10px 25px rgba(15, 118, 110, 0.12);
                display: flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #d1fae5;
            }
            @media print {
                .no-print { display: none; }
                body { margin: 0; background: #ffffff; }
                .sheet { box-shadow: none; }
            }
        </style>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-white">
        <div class="sheet">
            <div class="header">
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
                    <div class="logo-left" style="display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:999px;color:#6b7280;font-size:11px;padding:0.25cm;">Logo</div>
                @endif
                @if($logoRight)
                    <!-- <img src="{{ asset($logoRight) }}" alt="Logo kanan" class="logo-right"> -->
                @else
                    <div class="logo-right" style="display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:999px;color:#6b7280;font-size:11px;padding:0.25cm;">Logo</div>
                @endif

                <div class="brand-text">
                    Label Informasi Tanaman
                </div>
            </div>

            <div class="row">
                <div class="details">
                    <div class="name-block">
                        <div class="plant-name">{{ $plant->name }}</div>
                        @if($plant->latin_name)
                            <div class="latin">{{ $plant->latin_name }}</div>
                        @endif
                    </div>
                    <div class="scan-block">
                        <div class="scan-label">Scan untuk lihat detail tanaman</div>
                        <div class="scan-url">{{ route('user.tanaman.show', $plant) }}</div>
                    </div>
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
