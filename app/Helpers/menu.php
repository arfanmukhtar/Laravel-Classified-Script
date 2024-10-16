<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

function mainMenu()
{   
    try { 
        $filename = "assets/menu.json";
        $jsonData = file_get_contents($filename);
        $jsonData = json_decode($jsonData , true);
    } catch(\Exception $e) { 
        $jsonData = array();
    }
    
    $categories = getParentCategories();
    if(!empty($jsonData)) { 
        $menu = "";
        foreach($jsonData as $json) {
            if($json["id"] == "category") { 
                $menu .= '<li class="dropdown no-arrow nav-item">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="dropdown-nav-01" data-bs-toggle="dropdown" aria-expanded="false">
                Category
                <span></span> <i class=" icon-down-open-big fa"></i></a>
                <ul class="dropdown-menu user-menu dropdown-menu-right" aria-labelledby="dropdown01">';
                foreach($categories as $category) { 
                    $menu .='<li class="dropdown-item">';
        
                    $menu .='<a href="' . url("category/" . $category->slug) . '">' . $category->name . '<small>(' . $category->counter . ')</small></a>';
                    $menu .='</li>';
                }
                
                $menu .=' </ul></li>';
            } else { 

                $menu .= '<li class="dropdown no-arrow nav-item">
                <a href="' . url($json['id']) . '" class="nav-link " id="home">
                    ' . trans($json['name']) . '
                </a>
            </li>';

                
            }
           
        }
    } else { 
        $menu = '<li class="dropdown no-arrow nav-item">
            <a href="/" class="nav-link active" id="home">
                ' . trans('menu.home') . '
            </a>
        </li>';

        $menu .= '<li class="dropdown no-arrow nav-item">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="dropdown-nav-01" data-bs-toggle="dropdown" aria-expanded="false">
        Category
        <span></span> <i class=" icon-down-open-big fa"></i></a>
        <ul class="dropdown-menu user-menu dropdown-menu-right" aria-labelledby="dropdown01">';
        foreach($categories as $category) { 
            $menu .='<li class="dropdown-item">';

            $menu .='<a href="' . url("category/" . $category->slug) . '">' . $category->name . '<small>(' . $category->counter . ')</small></a>';
            $menu .='</li>';
        }
        
        $menu .=' </ul></li>';
            
    }

    return $menu;
}
