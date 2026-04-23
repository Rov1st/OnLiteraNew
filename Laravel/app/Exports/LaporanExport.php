<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    /**
     * Ambil semua data dari tabel peminjaman
     */
    public function collection()
    {
        return Peminjaman::all([
            'id_peminjaman',
            'tanggal_pinjam',
            'tanggal_harus_kembali',
            'status',
            'id_user'
        ]);
    }

    /**
     * Tambahkan header di Excel
     */
    public function headings(): array
    {
        return [
            'id_peminjaman',
            'tanggal_pinjam',
            'tanggal_harus_kembali',
            'status',
            'id_user'
        ];
    }
}
