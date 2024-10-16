<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    public function photos()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
}
