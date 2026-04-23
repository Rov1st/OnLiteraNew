<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanBulananExport implements WithMultipleSheets
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function sheets(): array
    {
        return [
            new PeminjamanSheet($this->bulan, $this->tahun),
            new PengembalianSheet($this->bulan, $this->tahun),
            new StatistikSheet($this->bulan, $this->tahun),
        ];
    }
}
