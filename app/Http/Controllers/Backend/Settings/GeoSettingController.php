<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\cityArea;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use DB;

class GeoSettingController extends Controller
{
    public function countries()
    {
        $selectCountries = [];
        $op_country = getSetting('op_country');
        // if (! empty($op_country)) {
        //     $selectCountries = json_decode($op_country, true);
        // }

        $countries = Country::where('id', $op_country)->get();
        foreach ($countries as $country) {
            $country->total_cities = \App\Models\City::where('country_code', $country->code)->count();
        }

        return view('backend.settings.countries.countries', compact('countries'));
    }

    public function cities($code = '')
    {
        if ($code) {
            $cities = City::where('country_code', $code)->get();
        } else {
            $cities = City::get();
        }

        return view('backend.settings.countries.cities', compact('cities' , 'code'));
    }

    public function importCitiesList(Request $request) { 
        $code = $request->input("code");
        $cities_backup = DB::table("cities_backup")->where("country" , $code)->get();
        foreach($cities_backup as $c) { 
            $data = array(
                "country_code" => $code,
                "state_id" => $c->id,
                "slug" => Str::slug($c->name),
                "name" => $c->name,
                "longitude" => $c->lat,
                "latitude" => $c->lng
            );

            $exists = DB::table("cities")->where("country_code" , $code)->where("name" , $c->name)->exists();
            if(!$exists) { 
                DB::table("cities")->insert($data);
            }
        }
    }

    public function deleteCity(Request $request)
    {
        $id = $request->input('id');
        City::where('id', $id)->delete();
        echo 'success';
    }

    public function getCity(Request $request)
    {
        $id = $request->input('id');
        $city = City::where('id', $id)->first();
        echo json_encode($city);
    }

    public function saveCity(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        if ($request->input('id')) {
            City::where('id', $request->input('id'))->update($data);
            echo 'updated';
        } else {
            City::insert($data);
            echo 'saved';
        }
    }

    public function areas($id = '')
    {
        if ($id) {
            $state_id = DB::table("cities")->where("id" , $id)->value("state_id");
            $cities = cityArea::where('city_id', $id)->get();
        } else {
            $cities = cityArea::get();
        }

        

        return view('backend.settings.countries.areas', compact('cities' , 'id' , 'state_id'));
    }

    public function deleteArea(Request $request)
    {
        $id = $request->input('id');
        cityArea::where('id', $id)->delete();
        echo 'success';
    }

    public function getArea(Request $request)
    {
        $id = $request->input('id');
        $city = cityArea::where('id', $id)->first();
        echo json_encode($city);
    }

    public function saveArea(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        if ($request->input('id')) {
            cityArea::where('id', $request->input('id'))->update($data);
            echo 'updated';
        } else {
            cityArea::insert($data);
            echo 'saved';
        }
    }

    public function importAreasList(Request $request) { 
        $state_id = $request->input("state_id");
        $city_id = $request->input("city_id");
        $response = Http::post('https://laravelclassified.com/api/get-cities', [
            'state_id' => $state_id,
        ]);

        $batchArray = array();
        $cities = json_decode($response);
      
        
        foreach($cities as $city) { 
            $batchArray[] = array(
                "city_id" => $city_id,
                "name" => $city->name,
                "slug" => Str::slug($city->name),
                "latitude" => $city->latitude,
                "longitude" => $city->longitude,
            );
        }

        DB::table("cities_areas")->insert($batchArray);
        echo "success";
       
    }

    public function timezones()
    {
        $timezones = Timezone::get();

        return view('backend.settings.timezones.timezones', compact('timezones'));
    }

    public function editTimezone(Request $request)
    {
        $id = $request->input('id');
        $timezone = Timezone::where('id', $id)->first();
        echo json_encode($timezone);
    }

    public function storeTimezone(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        if ($request->input('id')) {
            Timezone::where('id', $request->input('id'))->update($data);

            return redirect('admin/settings/timezones')
                ->with('message-success', 'Updated Successfully');
        } else {
            Timezone::insert($data);

            return redirect('admin/settings/timezones')
                ->with('message-success', 'Expense created!');
        }
    }

    public function currencies()
    {
        $currencies = Currency::get();

        return view('backend.settings.currencies.currencies', compact('currencies'));
    }

    public function editCurrency(Request $request)
    {
        $id = $request->input('id');
        $currency = Currency::where('id', $id)->first();
        echo json_encode($currency);
    }

    public function storeCurrency(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        if ($request->input('id')) {
            Currency::where('id', $request->input('id'))->update($data);

            return redirect('admin/settings/currencies')
                ->with('message-success', 'Updated Successfully');
        } else {
            Currency::insert($data);

            return redirect('admin/settings/currencies')
                ->with('message-success', 'Expense created!');
        }
    }


   
    
}
