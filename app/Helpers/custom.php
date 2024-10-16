<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

function getApplicationSettings($key = null)
{
    if (isset($key)) {
        $value = Config::get("appSettings.$key");
        if (empty($value)) {
            $value = \App\Models\ApplicationSetting::where('key', $key)->value('value');
        }
    } else {
        $value = Config::get('appSettings');
        if (! is_array($value) || empty($value) || $value == 1) {
            $value = \App\Models\ApplicationSetting::pluck('value', 'key')->toArray();
        }
    }

    return $value;
}


function writeApplicationSettingsToFile($model)
{
    $vars =  $model::all([
        'key','value'
    ])
        ->keyBy('key') // key every setting by its name
        ->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray(); // make it an array
    $str = "<?php \n ".'$settings ='." \n [ \n";
    foreach ($vars as $key => $var) {
        if($var==null)
            $str .=  "'$key' =>"."null,"."\n";
        else
            $str .=  "'$key' =>"."'".addcslashes($var, "'")."',"."\n"; // Escaping single quotes
    }
    $str .= ' ];';
    $dirPath = storage_path('framework/settings');
    createDir($dirPath,0777);
    file_put_contents("$dirPath/app.php", $str);
}

function createDir($path, $mode, $recursive = false)
{
    if (! file_exists($path)) {
        $oldmask = umask(0);
        mkdir($path, $mode, $recursive);
        umask($oldmask);
    }
}


function getCount($table, $field, $value)
{
    $totalCount = DB::table($table)->where("$field", $value)->count();

    return $totalCount;
}

function getTableData($table)
{
    $data = DB::table($table)->get();

    return $data;
}

function getTableFieldData($table, $where, $value, $field = '')
{
    if ($field) {
        $data = DB::table($table)->where("$where", "$value")->value($field);
    } else {
        $data = DB::table($table)->where("$where", "$value")->first();
    }

    return $data;
}
function getUserFavorite($user_id)
{
  
    $users = DB::table("user_favourite_ads")->where("user_id" , $user_id)->pluck("post_id");
    $users = json_decode(json_encode($users) , true);
   
    return $users;
}

function getSetting($key)
{
    $value = Config::get("appSettings.$key"); 
    if (empty($value)) {
        $value = \App\Models\ApplicationSetting::where('key', $key)->value('value');
    }
    return $value;
}

function setting_by_key($key)
{
    $value = Config::get("appSettings.$key");
    if (empty($value)) {
        $value = \App\Models\ApplicationSetting::where('key', $key)->value('value');
    }
    return $value;
}

function getParentCategories()
{
    $categories = \App\Models\Category::with('children')->select('id', 'slug', 'name', 'counter', 'picture')->whereNull('parent_id')->get();

    return $categories;
}

function getCities($country_code = "")
{
    $citiesArray = [];
    
    $countries = DB::table('cities')->select('slug', 'name');
    if(!empty($country_code)) { 
        $countries->where('country_code', $country_code);
    }
    $countries = $countries->get();
    foreach ($countries as $country) {
        $citiesArray["$country->slug"] = $country->name;
    }
    echo json_encode($citiesArray);
}

function saveSettings($fieldName, $value, $clear_config = 0)
{
    $settingData = [
        'key' => $fieldName,
        'value' => $value,
    ];
    $records = \App\Models\ApplicationSetting::where('key', $fieldName);
    $cnt = $records->count();
    if ($cnt > 1 || $cnt == 0) {
        $records->delete();
        $objAppSettings = new \App\Models\ApplicationSetting();
    } else {
        $objAppSettings = \App\Models\ApplicationSetting::where('key', $fieldName)->first();
    }
    $objAppSettings->fill($settingData);
    $objAppSettings->save();

    if ($clear_config === 1) {
        callConfig('config:cache');
    }
}

function callConfig($command)
{
    //   Artisan::call($command);
    open_url(route('executeCommand', "$command"));
}

function open_url($url)
{
    $start = microtime(true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'?is_authenticated_request=1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    $output = curl_exec($ch);
    $errno = curl_errno($ch);
    if ($errno > 0) {
        if ($errno === 28) {
            return 'running';
        } else {
            return 'Error #'.$errno.': '.curl_error($ch);
        }
    } else {
        return $output;
    }
    $end = microtime(true);
    curl_close($ch);
    // return "$url\n" /*. ($end - $start)*/;
}

function file_upload_max_size()
{
    static $max_size = -1;

    if ($max_size < 0) {
        // Start with post_max_size.
        $post_max_size = parse_size(ini_get('post_max_size'));
        if ($post_max_size > 0) {
            $max_size = $post_max_size;
        }

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $upload_max = parse_size(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }

    return $max_size;
}

function parse_size($size)
{
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
    if ($unit) {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } else {
        return round($size);
    }
}

function humanPrice($value) {
    $currency_view = getSetting("currency_view"); 
    if( $currency_view != "HumanReadable") { 
        return number_format($value);
    }
    if ($value > 999 && $value <= 999999) {
        $result = number_format($value / 1000,2) . 'K';
    } elseif ($value > 999999) {
        $result = number_format($value / 1000000, 2) . 'M';
    } else {
        $result = number_format($value);
    }

    return $result;
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k.' '.$v.($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (! $full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string).' ago' : 'just now';
}

function orientate($image, $orientation)
{
    switch ($orientation) {

        // 888888
        // 88
        // 8888
        // 88
        // 88
        case 1:
            return $image;

            // 888888
            //     88
            //   8888
            //     88
            //     88
        case 2:
            return $image->flip('h');

            //     88
            //     88
            //   8888
            //     88
            // 888888
        case 3:
            return $image->rotate(180);

            // 88
            // 88
            // 8888
            // 88
            // 888888
        case 4:
            return $image->rotate(180)->flip('h');

            // 8888888888
            // 88  88
            // 88
        case 5:
            return $image->rotate(-90)->flip('h');

            // 88
            // 88  88
            // 8888888888
        case 6:
            return $image->rotate(-90);

            //         88
            //     88  88
            // 8888888888
        case 7:
            return $image->rotate(-90)->flip('v');

            // 8888888888
            //     88  88
            //         88
        case 8:
            return $image->rotate(90);

        default:
            return $image;
    }
}

function role_permission($permission_id)
{
    $role_id = Auth::user()->role_id;
    $check = DB::table('permission_role')->where('role_id', $role_id)->where('permission_id', $permission_id)->exists();
    if ($check) {
        return true;
    }

    return false;
}

function seoSiteVerification($app_setting): string
{

    $engines = [
        'google' => [
            'name' => 'google-site-verification',
            'content' => ! empty($app_setting['google_site_verify']) ? $app_setting['google_site_verify'] : '',
        ],
        'bing' => [
            'name' => 'bing-verification',
            'content' => ! empty($app_setting['bing_site_verify']) ? $app_setting['bing_site_verify'] : '',
        ],
        'yandex' => [
            'name' => 'yandex-verification',
            'content' => ! empty($app_setting['yandex_site_verification']) ? $app_setting['yandex_site_verification'] : '',
        ],
        'alexa' => [
            'name' => 'elexa-verification',
            'content' => ! empty($app_setting['alexa_site_verify']) ? $app_setting['alexa_site_verify'] : '',
        ],
    ];

    $out = '';
    foreach ($engines as $engine) {
        if (isset($engine['name'], $engine['content']) && $engine['content']) {
            if (preg_match('|<meta[^>]+>|i', $engine['content'])) {
                $out .= $engine['content']."\n";
            } else {
                $out .= '<meta name="'.$engine['name'].'" content="'.$engine['content'].'" />'."\n";
            }
        }
    }

    return $out;
}
