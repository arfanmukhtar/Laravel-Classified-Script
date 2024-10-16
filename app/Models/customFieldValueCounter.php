<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customFieldValueCounter extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'c_value',
        'custom_field_id',
        'updated_at',
        'counter',
    ];
}
