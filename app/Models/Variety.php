<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plant_name_id',
    ];

    public function plantName()
    {
        return $this->belongsTo(PlantName::class);
    }

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
