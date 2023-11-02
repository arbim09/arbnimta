<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\PendaftaranEvents;
use Maatwebsite\Excel\Concerns\FromQuery;

class PendaftaranExport implements FromQuery, WithMapping, WithHeadings
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }
    public function query()
    {
        return PendaftaranEvents::query()
            ->where('event_id', $this->eventId)
            ->with('user');
    }


    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }
    public function map($pendaftaran): array
    {
        return [
            $pendaftaran->name,
            $pendaftaran->email,
            $pendaftaran->event->name,
            $pendaftaran->no_hp,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Pendaftar',
            'Email',
            'Nama Event',
            'No HP',
        ];
    }
}
