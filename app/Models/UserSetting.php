<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'show_owner_tags',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

