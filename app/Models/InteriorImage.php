<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class InteriorImage extends Model
{

    use HasFactory;
    protected $fillable = [
        'lot_id',
        'image_path',
    ];

    public function lot() 
    {
        return $this->belongsTo(Lot::class);
    }
}
