<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailWithCode;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['email_verified_at'];
    protected $fillable = [
        'name', 'email', 'password', 'role', 'alamat', 'verification_code',
        'no_hp',
        'password',
        'email',
        'jenis_kelamin',
        'umur',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pekerjaan_id',
        'pendidikan',
        'foto_profil',
        'point',
        'badge'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getEnumValues($users, $role)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $users WHERE Field = '$role'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }
        return $enum;
    }

    public static function getAgama($users, $agama)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $users WHERE Field = '$agama'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }
        return $enum;
    }

    public static function getPendidikan($users, $pendidikan)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $users WHERE Field = '$pendidikan'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }
        return $enum;
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function pendaftaranEvents()
    {
        return $this->hasMany(PendaftaranEvents::class);
    }

    // public function events()
    // {
    //     return $this->hasMany(Events::class);
    // }
}
