<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithEvents
{
    private $no = 1;
    private $day;
    private $month;
    private $year;

    public function __construct($day = null, $month = null, $year = null)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $query = Transaksi::with('penyewaan');

        if ($this->day) {
            $query->whereDay('tanggal_transaksi', $this->day);
        }

        if ($this->month) {
            $query->whereMonth('tanggal_transaksi', $this->month);
        }

        if ($this->year) {
            $query->whereYear('tanggal_transaksi', $this->year);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Transaksi',
            'Nama Sarana/Prasarana',
            'Nama Peminjam',
            'Jumlah',
            'Harga',
            'Tanggal Transaksi',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $this->no++,
            $transaksi->id_transaksi,
            $transaksi->penyewaan->penyewaanable->nama ?? '-',
            $transaksi->peminjam,
            $transaksi->jumlah,
            'Rp ' . number_format($transaksi->harga, 0, ',', '.'),
            \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 30,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A4:{$highestColumn}{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'wrapText'   => true,
            ],
        ]);
        $sheet->getStyle('A4:' . $highestColumn . '4')->applyFromArray([
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

                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');
                $sheet->mergeCells('A3:J3');
                $sheet->mergeCells('A4:J4');

                $sheet->setCellValue('A1', '');
                $sheet->setCellValue('A2', 'Laporan Transaksi Penyewaan Sarana & Prasarana');
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
