<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranEvents extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_events';
    protected $fillable = ['name', 'user_id', 'event_id', 'email', 'no_hp', 'pekerjaan_id', 'pendidikan', 'organisasi', 'nama_event'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Events::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    function absensi()
    {
        return $this->hasOne(PendaftaranEvents::class);
    }
}
