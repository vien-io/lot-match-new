<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;
    
    protected $table = 'lots';


    protected $fillable = [
        'name', 
        'description', 
        'size', 
        'price', 
        'block_id',
        'lot_area',
        'floor_area',
    ]; 
    
 
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'block_id', 'block_id');
    }
    public function interiorImages() {
        return $this->hasMany(InteriorImage::class);
    }
    
}
