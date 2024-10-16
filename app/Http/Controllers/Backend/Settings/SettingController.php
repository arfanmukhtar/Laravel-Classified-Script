<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\BudgetFilter;
use Artisan;
use DB;
use File;
use Config, Mail;
use Illuminate\Http\Request;
use Symfony\Component\Mime\Crypto\DkimOptions;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Crypto\DkimSigner;

class SettingController extends Controller
{
    public function generalSetting()
    {
        $timezones = DB::table('timezones')->get();

        return view('backend.settings.general', compact('timezones'));
    }

    public function branding()
    {
        return view('backend.settings.branding');
    }

    public function payments()
    {
        return view('backend.settings.payments');
    }

    public function seoSettings()
    {
        return view('backend.settings.seo');
    }

    public function advertisements()
    {
        return view('backend.settings.advertise');
    }

    public function pagesView()
    {
        return view('backend.settings.pages_views');
    }

    public function saveBranding(Request $request)
    {
        try {
            $page = $request->input('page');
            $inputs = $request->all();
            unset($inputs['page']);
            unset($inputs['_token']);
            foreach ($inputs as $filename => $file) {
                $this->savePhoto($request, "$filename");
            }

            // Artisan::call("config:cache");
            session()->flash('msg', trans('Saved Successfully'));

            return redirect("admin/settings/branding?p=$page")->with('message-success', 'Saved Successfully!');
        } catch (\Exception $e) {

        }
    }

    public function savePhoto($request, $name , $path = 'storage/branding')
    {
        $valid_exensions = ['jpg', 'bmp', 'png', 'jpeg', 'gif'];

        if ($request->hasfile("$name")) {
            $attachment = $request->file($name);
            $extention = $attachment->extension();
            $fileName = time()."$name.$extention";
            $setting = ApplicationSetting::where('key', "$name")->first();
            if (is_null($setting)) {
                $setting = new ApplicationSetting();
            }
            $setting->fill(['key' => "$name", 'value' => $fileName])->save();
            // get attached files

            // attachment directory path for template
            $attachment_destination = $path;

            if (! empty($attachment) && $attachment->isValid() && (in_array($attachment->extension(), $valid_exensions))) {
                // if directory not exist;
                if (! is_dir($attachment_destination)) {
                    File::makeDirectory($attachment_destination, 0777, true);
                }
                $attachment->move($attachment_destination, $fileName);
            } else { 
                echo "failed";
            }
        }
    }

    public function saveSetting(Request $request)
    {
        $settingsData = $request->all();
        $excludeArray = array("home_ad_image1" , "detail_right_ad" , "home_ad_image2" , "search_top_ad" , "detail_top_ad");

        if ($request->file('home_ad_image1')) { 
            $this->savePhoto($request, "home_ad_image1" ,  "storage/images/advertisements");
        }
        if ($request->file('home_ad_image2')) {
            $this->savePhoto($request, "home_ad_image2" , "storage/images/advertisements");
        }
        if ($request->file('search_top_ad')) {
            $this->savePhoto($request, "search_top_ad" , "storage/images/advertisements");
        }
        if ($request->file('detail_top_ad')) {
            $this->savePhoto($request, "detail_top_ad" , "storage/images/advertisements");
        }
        if ($request->file('detail_right_ad')) {
            $this->savePhoto($request, "detail_right_ad" , "storage/images/advertisements");
        }

        if (!empty($request->input('currency'))) {
            $currency = $request->input('currency');
            $currency = explode('-', $currency);
            $settingsData['currency'] = ! empty($currency[0]) ? $currency[0] : 153;
            $settingsData['currency_symbol'] = ! empty($currency[1]) ? $currency[1] : '$';
        }
        if (!empty($request->input('op_country'))) {
            $settingsData['op_country'] =  $request->input('op_country');
        }
        if (!empty($request->input('filters_list'))) {
            $settingsData['filters_list'] =  json_encode($request->input('filters_list'));
        }

        unset($settingsData['_token']);
        foreach ($settingsData as $key => $value) {
            if(!in_array($key , $excludeArray)) { 
                ApplicationSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
           
        }

        $flag = 0;
        if ($request->input('facebook_switch') == 'on') {
            if (! empty($request->input('fb_app_id'))) {
                $envParams['FB_CLIENT_ID'] = $request->input('fb_app_id');
            }
            if (! empty($request->input('fb_secret'))) {
                $envParams['FB_CLIENT_SECRET'] = $request->input('fb_secret');
            }
            if (! empty($request->input('fb_callback'))) {
                $envParams['FB_REDIRECT'] = $request->input('fb_callback');
            }
            $flag = 1;
        }

        if ($request->input('google_switch') == 'on') {
            if (! empty($request->input('google_app_id'))) {
                $envParams['GOOGLE_CLIENT_ID'] = $request->input('google_app_id');
            }
            if (! empty($request->input('google_secret'))) {
                $envParams['GOOGLE_CLIENT_SECRET'] = $request->input('google_secret');
            }
            if (! empty($request->input('google_callback'))) {
                $envParams['GOOGLE_REDIRECT'] = $request->input('google_callback');
            }
            $flag = 1;
        }

        if (! empty($request->input('robotstxt'))) {
            $this->updateRobotsFile($request->input('robotstxt'));
        }

        // if($request->input("linkedin_switch") == "on") {
        //     if(!empty($request->input("linkedin_login_key"))) {
        //         $envParams['LI_CLIENT_ID'] =  $request->input("linkedin_login_key");
        //     }
        //     if(!empty($request->input("linkedin_login_secret"))) {
        //         $envParams['LI_CLIENT_SECRET'] =  $request->input("linkedin_login_secret");
        //     }
        //     if(!empty($request->input("linkedin_callback"))) {
        //         $envParams['LI_REDIRECT'] =  $request->input("linkedin_callback");
        //     }
        //     $flag = 1;
        // }

        if ($flag == 1) {
            $this->updateEnv($envParams);
        }

        try { 
            Artisan::call("config:cache");
        } catch(\Exception $e) {}

        echo 'success';
    }

    public function updateRobotsFile($data)
    {
        $robotsTxt = base_path().'/robots.txt';
        $newContent = $data;
        file_put_contents($robotsTxt, $newContent);
    }

    public function updateEnv($data = [])
    {
        if (! count($data)) {
            return;
        }

        $notmached = [];

        $pattern = '/([^\=]*)\=[^\n]*/';

        $envFile = base_path().'/.env';
        $lines = file($envFile);
        $newLines = [];

        $lines = file($envFile);
        foreach ($lines as $line) {

            preg_match($pattern, $line, $matches);

            if (! count($matches)) {
                $newLines[] = $line;

                continue;
            }

            if (! array_key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;

                continue;
            } else {
                $notmached[] = $matches[1];
            }

            $line = trim($matches[1])."={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }
        $moreLines = '';
        foreach ($data as $k => $val) {
            if (! in_array($k, $notmached)) {
                $val = str_replace(' ', '', $val);
                $moreLines .= trim($k).'='.trim($val)."\n";
            }
        }

        $newContent = implode('', $newLines);
        if ($moreLines) {
            $newContent .= "\n\n";
            $newContent .= $moreLines;
        }

        file_put_contents($envFile, $newContent);
        Artisan::call('config:cache');
    }


    public function homeVideos() { 
        $data["title"] = "Home Videos";
        $data["videos"] = DB::table("home_videos")->orderBy("id" , "DESC")->get();
        return view('backend.settings.home.index', $data);
    }
  
    public function deleteVideo(Request $request) { 
        DB::table("home_videos")->where('id', $request->input('id'))->delete();
    }
    public function saveVideo(Request $request) { 
        $data = $request->all();
        unset($data['_token']);

        if ($request->input('id')) {
            DB::table("home_videos")->where('id', $request->input('id'))->update($data);
        } else {
            DB::table("home_videos")->insert($data);
        }

        return redirect('admin/settings/home-videos');
    }


    
    public function homeBudgets() { 
        $data["title"] = "Home Budget Links";
        $data["rows"] = BudgetFilter::orderBy("id" , "DESC")->get();
        $data["categories"] = DB::table("categories")->orderBy("id" , "DESC")->get();
        $data["locations"] = DB::table("cities")->orderBy("id" , "DESC")->get();
        return view('backend.settings.home.budget', $data);
    }
  
    public function deleteBudget(Request $request) { 
        DB::table("budget_filters")->where('id', $request->input('id'))->delete();
    }
    public function saveBudget(Request $request) { 
        $data = $request->all();
        unset($data['_token']);

        if ($request->input('id')) {
            DB::table("budget_filters")->where('id', $request->input('id'))->update($data);
        } else {
            DB::table("budget_filters")->insert($data);
        }

        return redirect('admin/settings/home-budget-filters');
    }
    public function validate_smtp(Request $request) { 


        $mail_host = $request->input("mail_host");
        $mail_port = $request->input("mail_port");
        $mail_username = $request->input("mail_username");
        $mail_password = $request->input("mail_password");

        $mail_encryption = "tls";
        $verify_peer = false;
        $allow_self_signed = true;
        $verify_peer_name = false;

        try { 
            $dsn = getDsn($mail_host, $mail_port, $mail_username, $mail_password, 'smtp', $mail_encryption, '', $verify_peer, $allow_self_signed, $verify_peer_name);
            $transport = \Symfony\Component\Mailer\Transport::fromDsn($dsn);
            $mailer = new \Symfony\Component\Mailer\Mailer($transport);
            $email = new Email();
            $content = "this is a content for email senidng";
            $email->from("Arfan <support@quickdeal.online>")->to("support@quickdeal.online")->html($content) //->text($content_text)
            ->replyTo("arfan67@gmail.com")->subject("This is a Suject");
            $mailer->send($email);
        } catch(\Exception $e) { 
            echo $e->getMessage();
        }
    }
    

   

}
