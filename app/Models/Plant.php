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
        'advantages',
        'care',
        'main_photo_url',
        'category_id',
        'qr_code_path',
        'plant_name_id',
        'variety_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function plantName()
    {
        return $this->belongsTo(PlantName::class);
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class);
    }
}
