<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'role', 'action', 'table_name', 'record_id', 
        'old_data', 'new_data', 'ip_address'
    ];

}
