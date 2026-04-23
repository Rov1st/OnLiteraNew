<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PengembalianSheet implements FromCollection, WithHeadings, WithEvents
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Pengembalian::with('peminjaman.user')
            ->whereMonth('tanggal_kembali', $this->bulan)
            ->whereYear('tanggal_kembali', $this->tahun)
            ->get()
            ->map(function ($item) {
                return [
                    'ID' => $item->id_pengembalian,
                    'Nama User' => $item->peminjaman->user->name ?? '-',
                    'Tanggal Pinjam' => $item->peminjaman->tanggal_pinjam,
                    'Tanggal Harus Kembali' => $item->peminjaman->tanggal_harus_kembali,
                    'Tanggal Kembali' => $item->tanggal_kembali,
                    'Status' => $item->peminjaman->status,
                    'Denda' => $item->denda ?? 0,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID Pengembalian', 'Nama User', 'Tanggal Pinjam', 'Tanggal Harus Kembali', 'Tanggal Kembali', 'Status', 'Total Denda'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul
                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'Laporan Pengembalian');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '1F4E78']
                    ]
                ]);

                // Header tabel
                $sheet->getStyle('A2:G2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '70AD47']
                    ]
                ]);

                // Border semua data
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A2:G{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                    ]
                ]);

                foreach (range('A', 'Z') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
