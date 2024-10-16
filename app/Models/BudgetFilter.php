<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetFilter extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'location_id');
    }

}
