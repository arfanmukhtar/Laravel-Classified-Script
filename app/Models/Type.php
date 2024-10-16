<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'post_types';

    public $timestamps = true;

    protected $fillable = [
        'name',
    ];

    use HasFactory;
}
