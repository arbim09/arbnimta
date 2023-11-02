<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensis';
    protected $fillable = ['name', 'user_id', 'event_id', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Events::class);
    }

    public function pendaftaranEvents()
    {
        return $this->belongsTo(PendaftaranEvents::class);
    }
}
