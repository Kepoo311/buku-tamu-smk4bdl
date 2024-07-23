<?php

namespace App\Http\Controllers;

use App\Models\DataTamu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'dataTamu' => DataTamu::whereMonth('created_at', Carbon::now())->get(),
        ]);
    }

    public function filter(Request $request)
    {
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $dataTamu = DataTamu::whereDate('created_at', $date)->get();
        return view('dashboard', compact('dataTamu'));
    }

    public function exportAll()
    {
        return $this->exportData(null);
    }

   public function exportMonth()
    {
        $currentMonth = Carbon::now()->month;

        // Check if there is any data for the current month
        $dataTamu = DataTamu::whereMonth('created_at', $currentMonth)->get();
        if ($dataTamu->isEmpty()) {
            $monthName = Carbon::now()->locale('id')->month($currentMonth)->isoFormat('MMMM');
            return redirect()->back()->with('emptyData','Data untuk bulan '. $monthName . ' masi kosong!');
        }

        return $this->exportData($currentMonth);
    }

    private function exportData($month)
    {
        $query = DataTamu::query();
        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        $dataTamu = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['Foto Tamu', 'Nama Tamu', 'Tamu dari', 'Menemui', 'Alasan'];
        $columns = ['A', 'B', 'C', 'D', 'E'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValue($columns[$index] . '1', $header);
            $sheet->getColumnDimension($columns[$index])->setAutoSize(true);
        }

        // Set header style
        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFCCCCCC',
                ],
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($dataTamu as $tamu) {
            $photoPath = public_path('img/foto_tamu/' . $tamu->foto_tamu);
            if (file_exists($photoPath)) {
                $drawing = new Drawing();
                $drawing->setName('Foto Tamu');
                $drawing->setPath($photoPath);
                $drawing->setCoordinates('A' . $row);

                // Calculate height and width based on image size
                list($width, $height) = getimagesize($photoPath);
                $drawing->setHeight($height > 60 ? 60 : $height); // Set max height
                $sheet->getRowDimension($row)->setRowHeight($height > 60 ? 60 : $height);

                $drawing->setWorksheet($sheet);
            } else {
                $sheet->getRowDimension($row)->setRowHeight(20); // Default height if no image
            }

            $sheet->setCellValue('B' . $row, $tamu->nama_lengkap);
            $sheet->setCellValue('C' . $row, $tamu->asal_tamu);
            $sheet->setCellValue('D' . $row, $tamu->menemui);
            $sheet->setCellValue('E' . $row, $tamu->alasan);

            // Apply border to each row
            $rowCells = 'A' . $row . ':E' . $row;
            $sheet->getStyle($rowCells)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        if ($month) {
            $monthName = Carbon::now()->locale('id')->month($month)->isoFormat('MMMM');
            $fileName = 'data_tamu_' . $monthName . '.xlsx';
        } else {
            $year = Carbon::now()->year;
            $fileName = 'data_tamu_' . $year . '.xlsx';
        }
        $filePath = storage_path('app/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}