<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranEvents extends Model
{
    use HasFactory;

protected $table = 'pendaftaran_events';
    protected $fillable = ['name', 'user_id', 'event_id', 'email', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Events::class);
    }
}
