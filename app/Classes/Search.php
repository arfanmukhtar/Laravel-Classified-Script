<?php

namespace App\Classes;

class Search
{
    

    public static function loadCategories($category_ids)
    {
        $categories = \App\Models\Category::whereNull('parent_id')->orderBy('counter', 'DESC')->get();
        $html = '';
        foreach ($categories as $category) {
            $cSelected = '';
            if (in_array($category->id, $category_ids)) {
                $cSelected = 'checked';
            }
            $html .= "<li> <input data-name='".$category->name."' data-id='".$category->id."' class='categoryList'".$cSelected." type='checkbox' value='".$category->slug."' name='c' id='make_".$category->id."'><label for='make_".$category->id."' class='title text-link'> ".$category->name." </label><span class='count'><small> ".$category->counter.'</small></span></li>';

        }

        echo $html;

    }


    public static function loadCities($city_ids)
    {
        $cities = \App\Models\City::whereIn("id" , $city_ids)->orderBy('counter', 'DESC')->limit(8)->get();
        $html = '';
        foreach ($cities as $city) {
            $cSelected = '';
            if (in_array($city->id, $city_ids)) {
                $cSelected = 'checked';
            }
            $html .= "<li> <input data-name='".$city->name."' data-id='".$city->state_id."' class='locationList'".$cSelected." type='checkbox' value='".$city->slug."' name='l' id='city".$city->id."'><label for='city".$city->id."' class='title text-link'> ".$city->name." </label><span class='count'><small> ".$city->counter.'</small></span></li>';

        }
        echo $html;

    }
}
