<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = ['name', 'category_id', 'keterangan',  'image', 'is_show', 'waktu_mulai', 'jam', 'pilih_keterangan', 'ondar'];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pendaftaranEvents()
    {
        return $this->hasMany(PendaftaranEvents::class);
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'event_id');
    }
}
