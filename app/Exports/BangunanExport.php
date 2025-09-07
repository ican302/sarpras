<?php

namespace App\Exports;

use App\Models\Bangunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BangunanExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    private $no = 1;

    public function collection()
    {
        return Bangunan::all();
    }

    public function headings(): array
    {
        return [
            [
                'No',
                'Nama/Jenis Bangunan',
                'Nomor',
                '',
                'Kondisi',
                'Konstruksi Bangunan',
                '',
                'Luas Lantai (M2)',
                'Lokasi',
                'Dokumen Gedung',
                '',
                'Luas (M2)',
                'Status Tanah',
                'Nomor Kode Tanah',
                'Asal Usul',
                'Harga',
                'Keterangan',
                'Pemeliharaan',
            ],
            [
                '',
                '',
                'Kode Bangunan',
                'Register',
                '',
                'Bertingkat/Tidak',
                'Beton/Tidak',
                '',
                '',
                'Nomor',
                'Tanggal',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
        ];
    }

    public function map($bangunan): array
    {
        return [
            $this->no++,
            $bangunan->nama_bangunan,
            $bangunan->kode_bangunan,
            $bangunan->nomor_register,
            $bangunan->kondisi,
            $bangunan->bertingkat,
            $bangunan->beton,
            $bangunan->luas_lantai,
            $bangunan->lokasi,
            $bangunan->nomor,
            \Carbon\Carbon::parse($bangunan->tanggal)->format('d/m/Y'),
            $bangunan->luas,
            $bangunan->status_tanah,
            $bangunan->kode_tanah,
            $bangunan->asal_usul,
            'Rp ' . number_format($bangunan->harga, 0, ',', '.'),
            $bangunan->keterangan,
            $bangunan->pemeliharaan,
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
            'G' => 20,
            'H' => 15,
            'I' => 35,
            'J' => 25,
            'K' => 25,
            'L' => 12,
            'M' => 20,
            'N' => 25,
            'O' => 20,
            'P' => 20,
            'Q' => 35,
            'R' => 35,
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function ($event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:R1');
                $sheet->mergeCells('A2:R2');
                $sheet->mergeCells('A3:R3');
                $sheet->mergeCells('A4:R4');

                $sheet->setCellValue('A1', '');
                $sheet->setCellValue('A2', 'Laporan Data Bangunan');
                $sheet->setCellValue('A3', 'Sarpras SMKN 1 TIRTAMULYA');
                $sheet->setCellValue('A4', '');

                $sheet->getStyle('A1:A4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },

            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A5:A6');
                $sheet->mergeCells('B5:B6');
                $sheet->mergeCells('C5:D5');
                $sheet->mergeCells('E5:E6');
                $sheet->mergeCells('F5:G5');
                $sheet->mergeCells('H5:H6');
                $sheet->mergeCells('I5:I6');
                $sheet->mergeCells('J5:K5');
                $sheet->mergeCells('L5:L6');
                $sheet->mergeCells('M5:M6');
                $sheet->mergeCells('N5:N6');
                $sheet->mergeCells('O5:O6');
                $sheet->mergeCells('P5:P6');
                $sheet->mergeCells('Q5:Q6');
                $sheet->mergeCells('R5:R6');

                $sheet->getStyle('A5:R6')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                $sheet->getStyle('A7:R' . $sheet->getHighestRow())->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'wrapText' => true,
                    ],
                ]);
            },
        ];
    }
}
