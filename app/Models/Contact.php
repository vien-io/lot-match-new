<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Allow mass assignment for only the required fields
    protected $fillable = ['name', 'email', 'message'];
}
