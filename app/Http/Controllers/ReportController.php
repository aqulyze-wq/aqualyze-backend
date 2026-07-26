<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class ReportController extends Controller
{
    /**
     * Tampilkan halaman utama report & monitoring.
     */
    public function index(Request $request)
    {
        $totalDevice = Device::count();
        $online      = Device::where('status', 'online')->count();
        $offline     = Device::where('status', 'offline')->count();

        // Hitung Warning Hari Ini
        $warning = SensorData::whereDate('created_at', today())
            ->where(function ($query) {
                $query->where('status_suhu', 'Warning')
                      ->orWhere('status_ph', 'Warning')
                      ->orWhere('status_kekeruhan', 'Warning');
            })
            ->count();

        // Eager loading 'device' untuk cegah N+1 Query
        $query = SensorData::with('device')->latest();

        if ($request->filled('start')) {
            $query->whereDate('created_at', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->whereDate('created_at', '<=', $request->end);
        }

        if ($request->filled('device')) {
            $query->where('device_id', $request->device);
        }

        $data    = $query->paginate(15);
        $devices = Device::all();

        return view('report.index', compact(
            'totalDevice',
            'online',
            'offline',
            'warning',
            'data',
            'devices'
        ));
    }

    /**
     * Handler untuk Export Data (Excel, CSV, PDF)
     */
    public function export(Request $request)
    {
        $start  = $request->query('start');
        $end    = $request->query('end');
        $device = $request->query('device');
        $format = $request->query('format', 'csv');

        // Query data berdasarkan filter yang sedang aktif
        $query = SensorData::with('device')
            ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))
            ->when($device, fn($q) => $q->where('device_id', $device))
            ->latest();

        // Export PDF
        if ($format === 'pdf') {
            $data = $query->get();
            
            // Menggunakan facade Pdf jika barryvdh/laravel-dompdf terinstall
            if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                $pdf = Pdf::loadView('report.pdf', compact('data', 'start', 'end'));
                return $pdf->download('Report_Aqualyze_' . date('Ymd_His') . '.pdf');
            }

            return back()->with('error', 'Package DomPDF belum terinstall.');
        }

        // Export Excel / CSV
        $fileName = 'Report_Aqualyze_' . date('Ymd_His') . ($format === 'excel' ? '.xls' : '.csv');

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            
            // Header kolom spreadsheet
            fputcsv($handle, [
                'Waktu', 
                'Device', 
                'Suhu (°C)', 
                'pH', 
                'Kekeruhan (NTU)', 
                'Status Suhu', 
                'Status pH', 
                'Status Kekeruhan'
            ]);

            // Gunakan chunk agar ram server hemat saat data sangat besar
            $query->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '-',
                        optional($row->device)->nama_device ?? '-',
                        $row->suhu,
                        $row->ph,
                        $row->kekeruhan,
                        $row->status_suhu ?? 'Normal',
                        $row->status_ph ?? 'Normal',
                        $row->status_kekeruhan ?? 'Normal',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}