<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;
    protected $table = 'pekerjaan';

    public function users()
    {
        return $this->hasMany(User::class, 'pekerjaan_id');
    }

    public function pendaftaranEvents()
    {
        return $this->hasMany(PendaftaranEvents::class, 'pekerjaan_id');
    }
}
