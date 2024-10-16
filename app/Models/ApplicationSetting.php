<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            writeApplicationSettingsToFile($model);
        });


        self::saved(function($model)
        {
            writeApplicationSettingsToFile($model);
        });

        self::updated(function($model)
        {
            writeApplicationSettingsToFile($model);
        });

    }


    

}
