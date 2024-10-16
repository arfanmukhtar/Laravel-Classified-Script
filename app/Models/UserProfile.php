<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address', 'city', 'country', 'facebook_id', 'google_id', 'provider', 'last_loggedin', 'phone', 'postcode'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
