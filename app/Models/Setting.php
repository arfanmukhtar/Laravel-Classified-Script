<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * setup variable mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'label',
        'value',
    ];
}
