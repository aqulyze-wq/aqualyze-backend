<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Raw Data Monitoring</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            color: #0f172a;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            color: #64748b;
            font-size: 10px;
        }

        .meta-info {
            margin-bottom: 15px;
            font-size: 10px;
            color: #475569;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 6px 4px;
            border: 1px solid #0f172a;
            text-align: center;
        }

        td {
            padding: 5px;
            border: 1px solid #cbd5e1;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <!-- HEADER LAPORAN -->
    <div class="header">
        <h2>Laporan Raw Data Monitoring Sensor</h2>
        <p>Sistem Pemantauan Kualitas Air Kolam Ikan (ESP32 IoT System)</p>
    </div>

    <!-- INFORMASI CETAK -->
    <div class="meta-info">
        <strong>Tanggal Cetak:</strong> <?php echo date('d F Y, H:i:s'); ?> WIB <br>
        <strong>Total Data:</strong> <?php echo count($data); ?> Baris Rekaman
    </div>

    <!-- TABEL DATA SENSOR -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 18%;">LOKASI</th>
                <th style="width: 17%;">WAKTU</th>
                <th style="width: 12%;">SUHU (°C)</th>
                <th style="width: 12%;">STATUS SUHU</th>
                <th style="width: 10%;">PH</th>
                <th style="width: 12%;">STATUS PH</th>
                <th style="width: 14%;">KEKERUHAN (NTU)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ optional($item->device)->lokasi ?? 'Lokasi Tidak Diketahui' }}</strong></td>
                    <td class="text-center">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                    <td class="text-center">{{ $item->suhu }}°C</td>
                    <td class="text-center">{{ ucfirst($item->status_suhu ?? 'Warning') }}</td>
                    <td class="text-center">{{ $item->ph }}</td>
                    <td class="text-center">{{ ucfirst($item->status_ph ?? 'Warning') }}</td>
                    <td class="text-center">{{ $item->kekeruhan }} NTU</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data sensor yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini diunduh secara otomatis dari Sistem Monitoring Kualitas Air.
    </div>

</body>
</html>