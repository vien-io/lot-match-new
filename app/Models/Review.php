<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;


class Review extends Model
{
    use LogsActivity;
    protected $fillable = ['user_id', 'block_id', 'rating', 'comment'];

    
    public function user() {
        return $this->belongsTo(User::class);
    }

    
    public function block() {
        return $this->belongsTo(Block::class);
    }
}
