<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function home()
    {
        $filename = "assets/menu.json";
        $jsonData = file_get_contents($filename);
        $jsonData = json_decode($jsonData , true);
        
        $jsonArray = array();
        foreach($jsonData as $k=>$js) { 
            $jsonArray[] = $js["id"];
        }
       
        return view('backend.menu.home' , compact("jsonArray" , "jsonData"));
    }
    public function saveMenu(Request $request)
    {
        $json = $request->input("json");
        $filename = "assets/menu.json";
        file_put_contents($filename , $json);
        echo "success";

    }
}
