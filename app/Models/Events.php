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
    protected $fillable = ['name', 'category_id', 'keterangan', 'qr_code', 'image'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($event) {
    //         // Meng-generate QR code dengan isi yang diinginkan
    //         $qr_code = QrCode::size(250)
    //                     ->format('png')
    //                     ->generate('Event: '.$event->name.' - '.$event->keterangan);

    //         // Menyimpan QR code ke dalam direktori storage/app/public/qr_codes
    //         $qr_code_path = 'qr_codes/'.$event->name.'.png';
    //         Storage::makeDirectory('public/qr_codes');
    //         Storage::put($qr_code_path, $qr_code);

    //         // Mengupdate kolom qr_code pada tabel events dengan path QR code yang disimpan
    //         $event->qr_code = $qr_code_path;
    //     });

    //     static::deleting(function ($event) {
    //         // Menghapus QR code jika event dihapus
    //         $qr_code_path = $event->qr_code;
    //         Storage::delete($qr_code_path);
    //     });
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
