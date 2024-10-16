<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * rules validasi untuk data customers.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * setup variable mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'picture', 'slug', 'description', 'parent_id',
    ];

    public function parent()
    {
        return $this->belongsToOne(static::class, 'parent_id');
    }

    //each category might have multiple children
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
}
