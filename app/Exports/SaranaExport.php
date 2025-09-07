<?php

namespace App\Exports;

use App\Models\Sarana;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class SaranaExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithEvents
{
    private $no = 1;

    public function collection()
    {
        return Sarana::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Kategori',
            'Kode Barang',
            'Kode Sekolah',
            'Spesifikasi',
            'Satuan',
            'Sumber Dana',
            'Harga',
            'Tanggal Masuk',
            'Lokasi',
            'Kondisi',
            'Jumlah',
            'Keterangan',
        ];
    }

    public function map($sarana): array
    {
        return [
            $this->no++,
            $sarana->nama_barang,
            $sarana->kategori,
            $sarana->kode_barang,
            $sarana->kode_sekolah,
            $sarana->spesifikasi,
            $sarana->satuan,
            $sarana->sumber_dana,
            'Rp ' . number_format($sarana->harga, 0, ',', '.'),
            \Carbon\Carbon::parse($sarana->tanggal_masuk)->format('d/m/Y'),
            $sarana->lokasi,
            $sarana->kondisi,
            $sarana->jumlah,
            $sarana->keterangan,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 20,
            'D' => 25,
            'E' => 25,
            'F' => 30,
            'G' => 15,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 30,
            'L' => 15,
            'M' => 15,
            'N' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A5:{$highestColumn}{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'wrapText'   => true,
            ],
        ]);

        $sheet->getStyle('A5:' . $highestColumn . '5')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:N1');
                $sheet->mergeCells('A2:N2');
                $sheet->mergeCells('A3:N3');
                $sheet->mergeCells('A4:N4');

                $sheet->setCellValue('A1', '');
                $sheet->setCellValue('A2', 'Laporan Data Sarana');
                $sheet->setCellValue('A3', 'Sarpras SMKN 1 TIRTAMULYA');
                $sheet->setCellValue('A4', '');

                $sheet->getStyle('A1:A4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
