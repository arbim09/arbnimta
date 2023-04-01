<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    use HasFactory;
    protected $table = 'anggota';
    protected $guarded = ['id'];
    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'password',
        'email',
        'jenis_kelamin',
        'umur',
        'tempat_lahir',
        'tanggal_lahir',
        
    ];
}
