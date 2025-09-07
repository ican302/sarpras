<?php

namespace App\Exports;

use App\Models\Tanah;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TanahExport implements FromCollection, WithMapping, WithColumnWidths, WithEvents, WithStyles, WithCustomStartCell
{
    private $no = 1;

    public function collection()
    {
        return Tanah::all();
    }

    public function map($tanah): array
    {
        return [
            $this->no++,
            $tanah->nama,
            $tanah->kode,
            $tanah->nomor_register,
            $tanah->luas,
            $tanah->tahun_pengadaan,
            $tanah->lokasi,
            $tanah->status_tanah,
            \Carbon\Carbon::parse($tanah->tanggal)->format('d/m/Y'),
            $tanah->nomor,
            $tanah->penggunaan,
            $tanah->asal_usul,
            'Rp ' . number_format($tanah->harga, 0, ',', '.'),
            $tanah->keterangan,
            $tanah->pemeliharaan,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama/Jenis Tanah',
            'Kode',
            'Nomor Register',
            'Luas (m2)',
            'Tahun Pengadaan',
            'Lokasi',
            'Status Tanah',
            'Tanggal',
            'Nomor',
            'Penggunaan',
            'Asal Usul',
            'Harga',
            'Keterangan',
            'Pemeliharaan',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 35,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 20,
            'G' => 35,
            'H' => 20,
            'I' => 25,
            'J' => 25,
            'K' => 35,
            'L' => 20,
            'M' => 25,
            'N' => 35,
            'O' => 35,
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:O1');
                $sheet->mergeCells('A2:O2');
                $sheet->mergeCells('A3:O3');
                $sheet->mergeCells('A4:O4');

                $sheet->setCellValue('A1', '');
                $sheet->setCellValue('A2', 'Laporan Data Tanah');
                $sheet->setCellValue('A3', 'Sarpras SMKN 1 TIRTAMULYA');
                $sheet->setCellValue('A4', '');

                $sheet->getStyle('A1:A4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->mergeCells('A5:A7');
                $sheet->mergeCells('B5:B7');
                $sheet->mergeCells('C5:D5');
                $sheet->mergeCells('E5:E7');
                $sheet->mergeCells('F5:F7');
                $sheet->mergeCells('G5:G7');
                $sheet->mergeCells('H5:J5');
                $sheet->mergeCells('K5:K7');
                $sheet->mergeCells('L5:L7');
                $sheet->mergeCells('M5:M7');
                $sheet->mergeCells('N5:N7');
                $sheet->mergeCells('O5:O7');

                $sheet->setCellValue('A5', 'No');
                $sheet->setCellValue('B5', 'Nama/Jenis Tanah');
                $sheet->setCellValue('C5', 'Nomor');
                $sheet->setCellValue('E5', 'Luas (M2)');
                $sheet->setCellValue('F5', 'Tahun Pengadaan');
                $sheet->setCellValue('G5', 'Lokasi');
                $sheet->setCellValue('H5', 'Status Tanah');
                $sheet->setCellValue('K5', 'Penggunaan');
                $sheet->setCellValue('L5', 'Asal-Usul');
                $sheet->setCellValue('M5', 'Harga');
                $sheet->setCellValue('N5', 'Keterangan');
                $sheet->setCellValue('O5', 'Pemeliharaan');

                $sheet->mergeCells('C6:C7');
                $sheet->mergeCells('D6:D7');
                $sheet->setCellValue('C6', 'Kode Tanah');
                $sheet->setCellValue('D6', 'Register');

                $sheet->mergeCells('H6:H7');
                $sheet->setCellValue('H6', 'Hak');

                $sheet->mergeCells('I6:J6');
                $sheet->setCellValue('I6', 'Sertifikat');

                $sheet->setCellValue('I7', 'Tanggal');
                $sheet->setCellValue('J7', 'Nomor');

                $sheet->getStyle('A5:O7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A5:O7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A5:O7')->getFont()->setBold(true);
            },
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A8:O' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A8:O' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A5:O7' => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
        ];
    }
}
