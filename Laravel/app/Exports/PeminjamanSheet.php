<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PeminjamanSheet implements FromCollection, WithHeadings, WithEvents
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
        return Peminjaman::with('detailPeminjaman.buku', 'user')
            ->whereMonth('tanggal_pinjam', $this->bulan)
            ->whereYear('tanggal_pinjam', $this->tahun)
            ->get()
            ->flatMap(function ($item) {
                return $item->detailPeminjaman->map(function ($detail) use ($item) {
                    return [
                        'ID' => $item->id_peminjaman,
                        'Nama User' => $item->user->name ?? '-',
                        'Tanggal Pinjam' => $item->tanggal_pinjam,
                        'Tanggal Harus Kembali' => $item->tanggal_harus_kembali,
                        'Status' => $item->status,
                        'Judul Buku' => $detail->buku->judul,
                        'Stok' => $detail->buku->stok,
                    ];
                });
            });
    }


    public function headings(): array
    {
        return ['ID Peminjaman', 'Nama User', 'Tanggal Pinjam', 'Tanggal Harus Kembali', 'Status', 'Daftar Buku', 'Stok'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul
                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'Laporan Peminjaman');
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

                // Auto width
                foreach (range('A', 'Z') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // === MERGE KOLOM A-E (ID - Status) ===
                $data = $sheet->toArray(null, true, true, true);
                $rowStart = 3; // data mulai di baris 3 (setelah heading)

                while ($rowStart <= $lastRow) {
                    $id = $data[$rowStart]['A'];
                    $rowEnd = $rowStart;

                    // cari sampai row dengan ID sama
                    while ($rowEnd + 1 <= $lastRow && $data[$rowEnd + 1]['A'] == $id) {
                        $rowEnd++;
                    }

                    if ($rowEnd > $rowStart) {
                        // merge kolom A-E untuk baris dengan ID sama
                        foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
                            $sheet->mergeCells("{$col}{$rowStart}:{$col}{$rowEnd}");
                            $sheet->getStyle("{$col}{$rowStart}:{$col}{$rowEnd}")
                                ->getAlignment()->setVertical('center');
                        }
                    }

                    $rowStart = $rowEnd + 1;
                }
            }
        ];
    }
}
