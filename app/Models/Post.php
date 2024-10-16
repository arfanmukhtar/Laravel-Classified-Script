<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
    public function area()
    {
        return $this->hasOne(cityArea::class, 'id', 'area_id');
    }

    public function photos()
    {
        return $this->hasMany(Picture::class);
    }

    public function mainPhoto()
    {
        return $this->hasOne(Picture::class)->where('position', 0)->latest();
        // or any orderBy/Where condition according to your filter requirements.
    }
}
