<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromQuery, WithMapping, WithHeadings
{
    private $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function query()
    {
        return Absensi::query()
            ->where('event_id', $this->eventId)
            ->with('user');
    }

    public function map($absensi): array
    {
        return [
            $absensi->user->name,
            $absensi->user->email,
            $absensi->user->jenis_kelamin,
            $absensi->user->pendidikan,
            $absensi->user->pekerjaan ? $absensi->user->pekerjaan->nama : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Jenis Kelamin',
            'Pendidikan',
            'Pekerjaan',
        ];
    }
}
