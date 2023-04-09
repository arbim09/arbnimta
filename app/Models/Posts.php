<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Posts extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'posts';
    protected $fillable = [
        'title', 'content', 'slug', 'image', 'category_id', 'penulis'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "images/posts";

        if (!empty($value)) {
            // generate unique file name
            $file_name = Str::slug(pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . uniqid() . '.' . $value->getClientOriginalExtension();
            // move file to storage
            $value->storeAs($destination_path, $file_name, $disk);
            // set image attribute
            $this->attributes[$attribute_name] = "$destination_path/$file_name";
        }
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
