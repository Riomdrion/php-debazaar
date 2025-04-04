<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Contract - {{ $bedrijf }}</title>
    <style>
        @page { margin: 2cm; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            height: 80px;
            margin-bottom: 10px;
        }
        h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin-top: 0;
        }
        .contract-details {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 30px 0;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #4b5563;
        }
        .detail-value {
            flex: 1;
        }
        .signature-section {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px dashed #d1d5db;
        }
        .signature-line {
            width: 300px;
            border-top: 1px solid #333;
            margin-top: 60px;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .price {
            font-size: 20px;
            color: #10b981;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="header">
    <!-- Voeg hier je eigen logo toe als je die hebt -->
    <!-- <img src="{{ public_path('images/logo.png') }}" class="logo"> -->

    <h1>Contractovereenkomst</h1>
    <p class="subtitle">{{ $titel }}</p>
</div>

<div class="contract-details">
    <div class="detail-row">
        <div class="detail-label">Bedrijf:</div>
        <div class="detail-value">{{ $bedrijf }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Contractdatum:</div>
        <div class="detail-value">{{ date('d-m-Y') }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Contractnummer:</div>
        <div class="detail-value">CT-{{ str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT) }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Huisstijl:</div>
        <div class="detail-value">{{ $huisstijl }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Website slug:</div>
        <div class="detail-value">{{ $slug }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Bijlage:</div>
        <div class="detail-value">{{ $bestand }}</div>
    </div>
</div>

<h2>Overeenkomst</h2>
<p>Hierbij wordt de overeenkomst bevestigd tussen {{ $bedrijf }} en [Jouw Bedrijfsnaam] voor de hierboven genoemde diensten.</p>

<div class="detail-row" style="margin-top: 30px;">
    <div class="detail-label">Overeengekomen prijs:</div>
    <div class="detail-value price">€{{ number_format($prijs, 2, ',', '.') }}</div>
</div>

<div class="signature-section">
    <p>Getekend voor akkoord,</p>

    <div style="display: flex; justify-content: space-between; margin-top: 40px;">
        <div>
            <p>Namens {{ $bedrijf }}</p>
            <div class="signature-line"></div>
            <p style="margin-top: 5px;">Handtekening en datum</p>
        </div>

        <div>
            <p>Namens [Jouw Bedrijfsnaam]</p>
            <div class="signature-line"></div>
            <p style="margin-top: 5px;">Handtekening en datum</p>
        </div>
    </div>
</div>

<div class="footer">
    <p>Dit document is automatisch gegenereerd op {{ date('d-m-Y H:i') }}</p>
    <p>Voor vragen kunt u contact opnemen via [contactgegevens]</p>
</div>
</body>
</html>
