<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;
    protected $table = 'dokumentasi';
    protected $fillable = ['event_id', 'gambar1', 'gambar2', 'gambar3', 'gambar4', 'gambar5'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
