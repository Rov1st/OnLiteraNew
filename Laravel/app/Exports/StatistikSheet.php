<?php

namespace App\Exports;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StatistikSheet implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
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
        $totalDipinjam = Peminjaman::whereMonth('tanggal_pinjam', $this->bulan)
            ->whereYear('tanggal_pinjam', $this->tahun)
            ->count();

        $totalDikembalikan = Pengembalian::whereMonth('tanggal_kembali', $this->bulan)
            ->whereYear('tanggal_kembali', $this->tahun)
            ->count();

        $totalDenda = Pengembalian::whereMonth('tanggal_kembali', $this->bulan)
            ->whereYear('tanggal_kembali', $this->tahun)
            ->sum('denda');

        $topUsers = Peminjaman::select('users.name', DB::raw('COUNT(peminjaman.id_peminjaman) as total'))
            ->join('users', 'users.id', '=', 'peminjaman.id_user')
            ->whereMonth('peminjaman.tanggal_pinjam', $this->bulan)
            ->whereYear('peminjaman.tanggal_pinjam', $this->tahun)
            ->groupBy('users.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topBooks = DetailPeminjaman::select('buku_offline.judul', DB::raw('SUM(detail_peminjaman.stok) as total'))
            ->join('buku_offline', 'buku_offline.id_buku', '=', 'detail_peminjaman.id_buku')
            ->join('peminjaman', 'peminjaman.id_peminjaman', '=', 'detail_peminjaman.id_peminjaman')
            ->whereMonth('peminjaman.tanggal_pinjam', $this->bulan)
            ->whereYear('peminjaman.tanggal_pinjam', $this->tahun)
            ->groupBy('buku_offline.judul')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $data = collect([
            ['Total Buku Dipinjam', $totalDipinjam],
            ['Total Buku Dikembalikan', $totalDikembalikan],
            ['Total Denda', $totalDenda],
        ]);

        $data->push(['', '']);
        $data->push(['Top 5 User Aktif', '']);
        $data->push(['No', 'Nama User', 'Jumlah']);
        foreach ($topUsers as $i => $user) {
            $data->push([$i + 1, $user->name, $user->total]);
        }

        $data->push(['', '']);
        $data->push(['Top 5 Buku Terpopuler', '']);
        $data->push(['No', 'Judul Buku', 'Jumlah']);
        foreach ($topBooks as $i => $book) {
            $data->push([$i + 1, $book->judul, $book->total]);
        }

        return $data;
    }

    public function headings(): array
    {
        return ['Statistik', 'Nilai', ''];
    }

    public function columnWidths(): array
    {
        return ['A' => 25, 'B' => 30, 'C' => 15];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul utama
                $sheet->mergeCells('A1:C1');
                $sheet->setCellValue('A1', 'Laporan Statistik Perpustakaan');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '1F4E78'] // biru tua
                    ]
                ]);

                $lastRow = $sheet->getHighestRow();

                // Border semua data
                $sheet->getStyle("A2:C{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                    ]
                ]);

                // === Highlight biru cerah untuk Statistik Utama ===
                // Cari baris sampai ketemu 3 label utama
                for ($row = 2; $row <= $lastRow; $row++) {
                    $val = $sheet->getCell("A{$row}")->getValue();

                    // Statistik utama
                    if (in_array($val, ['Total Buku Dipinjam', 'Total Buku Dikembalikan', 'Total Denda'])) {
                        $sheet->getStyle("A{$row}")->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => '4A86E8']
                            ]
                        ]);
                    }

                    // Section header
                    elseif (in_array($val, ['Top 5 User Aktif', 'Top 5 Buku Terpopuler'])) {
                        $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => '4A86E8']
                            ]
                        ]);

                        // styling header tabel (baris setelahnya)
                        $headerRow = $row + 1;
                        $sheet->getStyle("A{$headerRow}:C{$headerRow}")->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                            'alignment' => ['horizontal' => 'center'],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => '70AD47']
                            ]
                        ]);
                    }
                }


                foreach (range('A', 'C') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                foreach (['A', 'C'] as $col) {
                    $sheet->getStyle("{$col}1:{$col}{$lastRow}")
                        ->getAlignment()->setHorizontal('center');
                }

                foreach (range(2, 4) as $r) {
                    $sheet->mergeCells("B{$r}:C{$r}");
                    $sheet->getStyle("B{$r}:C{$r}")->getAlignment()->setHorizontal('center');
                }

                $sheet->getStyle('B2:C4')->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
