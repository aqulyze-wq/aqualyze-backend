<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report Aqualyze</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { margin-bottom: 2px; text-align: center; }
        p.subtitle { text-align: center; color: #666; font-size: 11px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        th { background-color: #0ea5e9; color: #ffffff; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h2>LAPORAN MONITORING AQUALYZE</h2>
    <p class="subtitle">Dicetak pada: {{ date('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Waktu</th>
                <th>Device</th>
                <th>Suhu (°C)</th>
                <th>pH</th>
                <th>Kekeruhan (NTU)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ optional($item->device)->nama_device ?? '-' }}</td>
                    <td class="text-center">{{ $item->suhu }} °C</td>
                    <td class="text-center">{{ $item->ph }}</td>
                    <td class="text-center">{{ $item->kekeruhan }} NTU</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html> 