<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latin_name',
        'description',
        'benefits',
        'care',
        'main_photo_url',
        'category_id',
        'qr_code_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}