<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnggotaExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::where('role', 'anggota')->get();
    }

    public function map($anggota): array
    {
        return [
            $anggota->name,
            $anggota->email,
            $anggota->jenis_kelamin,
            $anggota->tempat_lahir,
            $anggota->tanggal_lahir,
            $anggota->umur,
            $anggota->alamat,
            $anggota->agama,
            $anggota->pendidikan,
            $anggota->pekerjaan->nama,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Anggota',
            'Email',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Alamat',
            'Agama',
            'Pendidikan',
            'Pekerjaan',
        ];
    }
}
