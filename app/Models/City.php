<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function updateChildValues($parentId)
    {
        $children = self::where('id', $parentId)->get();

        foreach ($children as $child) {
            self::where('id', $child->id)->update([
                'counter' => DB::raw('counter+1'),
            ]);

            // Recursively update the child's children
            updateChildValues($child->id);
        }
    }

    public static function totalAreas($city_id)
    {
        return DB::table('cities_areas')->where('city_id', $city_id)->count();
    }

    public static function totalPosts($city_id)
    {
        return DB::table('posts')->where('city_id', $city_id)->count();
    }

    public static function totalRequestedPosts($city_id)
    {
        return DB::table('post_requested')->where('city_id', $city_id)->count();
    }
}
