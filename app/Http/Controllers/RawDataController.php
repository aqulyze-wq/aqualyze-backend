<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\SensorData;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class RawDataController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $direction = strtolower($request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $sensorData = $this->getFilteredData($request)->paginate(15)->withQueryString();

        return view('raw-data', [
            'sensorData' => $sensorData,
            'search'     => $search,
            'direction'  => $direction,
        ]);
    }

    // Helper Query Filter (Diubah agar menampilkan seluruh data)
    private function getFilteredData(Request $request)
    {
        $search = $request->query('search');
        $direction = strtolower($request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        return SensorData::with('device')
            // BARIS ->whereHas('device') DIHAPUS AGAR DATA TIDAK TERPANGGAS
            ->when($search, function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->whereHas('device', function ($deviceQuery) use ($value) {
                        // FILTER BERDASARKAN LOKASI DEVICE
                        $deviceQuery->where('lokasi', 'like', "%{$value}%");
                    })
                    ->orWhere('suhu', 'like', "%{$value}%")
                    ->orWhere('ph', 'like', "%{$value}%")
                    ->orWhere('kekeruhan', 'like', "%{$value}%")
                    ->orWhere('status_suhu', 'like', "%{$value}%")
                    ->orWhere('status_ph', 'like', "%{$value}%")
                    ->orWhere('status_kekeruhan', 'like', "%{$value}%");
                });
            })
            ->orderBy('created_at', $direction);
    }

    // 1. Export CSV (Menggunakan Lokasi)
    public function exportCsv(Request $request): StreamedResponse
    {
        $fileName = 'raw_sensor_data_' . date('Y-m-d_H-i-s') . '.csv';
        $data = $this->getFilteredData($request)->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $columns = ['Lokasi', 'Waktu', 'Suhu (C)', 'Status Suhu', 'pH', 'Status pH', 'Kekeruhan (NTU)', 'Status Kekeruhan'];

        return response()->stream(function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, $columns);

            foreach ($data as $row) {
                fputcsv($file, [
                    optional($row->device)->lokasi ?? 'Lokasi Tidak Diketahui',
                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '-',
                    $row->suhu,
                    $row->status_suhu ?? 'Warning',
                    $row->ph,
                    $row->status_ph ?? 'Warning',
                    $row->kekeruhan,
                    $row->status_kekeruhan ?? 'Normal',
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }

    // 2. Export Excel (Menggunakan Lokasi)
    public function exportExcel(Request $request): StreamedResponse
    {
        $fileName = 'raw_sensor_data_' . date('Y-m-d_H-i-s') . '.xls';
        $data = $this->getFilteredData($request)->get();

        $headers = [
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($data) {
            $file = fopen('php://output', 'w');
            fputs($file, "Lokasi\tWaktu\tSuhu (C)\tStatus Suhu\tpH\tStatus pH\tKekeruhan (NTU)\tStatus Kekeruhan\n");

            foreach ($data as $row) {
                fputs($file, implode("\t", [
                    optional($row->device)->lokasi ?? 'Lokasi Tidak Diketahui',
                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '-',
                    $row->suhu,
                    $row->status_suhu ?? 'Warning',
                    $row->ph,
                    $row->status_ph ?? 'Warning',
                    $row->kekeruhan,
                    $row->status_kekeruhan ?? 'Normal',
                ]) . "\n");
            }
            fclose($file);
        }, 200, $headers);
    }

    // 3. Export PDF
    public function exportPdf(Request $request)
    {
        $data = $this->getFilteredData($request)->get();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('raw-data-pdf', compact('data'));
            return $pdf->download('raw_sensor_data_' . date('Y-m-d_H-i-s') . '.pdf');
        }

        return view('raw-data-pdf', compact('data'));
    }
}