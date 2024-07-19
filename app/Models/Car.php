<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'deleted_at',
    ];

    protected $casts = [
        'created_at_format' => 'datetime:d.m.Y H:i'
    ];
}
