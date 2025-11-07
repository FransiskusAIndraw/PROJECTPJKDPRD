<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class SuratMasukExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $periode;

    public function __construct(string $periode = 'all')
    {
        $this->periode = $periode;
    }

    protected function startDateForPeriode(): ?Carbon
    {
        switch ($this->periode) {
            case '1_week':
                return Carbon::now()->subWeek();
            case '1_month':
                return Carbon::now()->subMonth();
            case '3_months':
                return Carbon::now()->subMonths(3);
            case '6_months':
                return Carbon::now()->subMonths(6);
            case '1_year':
                return Carbon::now()->subYear();
            case 'all':
            default:
                return null;
        }
    }

    public function query()
    {
        $query = SuratMasuk::query();

        $start = $this->startDateForPeriode();
        if ($start) {
            $query->where('tanggal_surat', '>=', $start->toDateString());
        }

        // Pilih kolom yang ingin diexport — sesuaikan dengan struktur DBmu
        return $query->select('id', 'nomor_surat', 'perihal', 'tanggal_surat', 'pengirim', 'file_surat', 'status', 'status_screening');
    }

    public function map($surat): array
    {
        return [
            $surat->id,
            $surat->nomor_surat,
            $surat->perihal,
            optional($surat->tanggal_surat) ? Carbon::parse($surat->tanggal_surat)->format('Y-m-d') : '',
            $surat->pengirim,
            $surat->file_surat,
            $surat->status,
            $surat->status_screening,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nomor Surat',
            'Perihal',
            'Tanggal Surat',
            'Pengirim',
            'File Surat (path)',
            'Status',
            'Status Screening',
        ];
    }
}
