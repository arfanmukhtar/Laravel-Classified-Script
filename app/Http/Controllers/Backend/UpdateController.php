<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;
use Artisan;

class UpdateController extends Controller
{
    public function index() { 
        return view("backend.update.index");
    }
   
    public function downloadUpdate(Request $request) { 
        $license_key = $request->input("license_key");
        $host_name = "https://laravelclassified.com";
        $src_file = "$host_name/license/downloads/{$license_key}.zip?t=" . time();

        $dest_file = base_path() . '/storage/updates/classified.zip';

        copy($src_file, $dest_file);
         $download = "$host_name/license/update.php?license_key={$license_key}&del=yes";
         $this->requestCurl($download);
    }
    public function copyFiles(Request $request) { 
        $dest_file = base_path() . '/storage/updates/classified.zip';
        $destination = base_path();
        $this->extractZipArchiveFiles($dest_file , $destination);
        unlink("storage/updates/classified.zip");
        try { 
            Artisan::call("view:clear");
            Artisan::call("route:clear");
            Artisan::call("config:cache");
        } catch(\Exception $e) {}
        
    }

    public function extractZipArchiveFiles($archive, $destination)
    {
        // Check if webserver supports unzipping.
        if (!class_exists('ZipArchive')) {
        $GLOBALS['status'] = array('error' => 'Error: Your PHP version does not support unzip functionality.');
        return;
        }
        $zip = new ZipArchive;
        // Check if archive is readable.
        if ($zip->open($archive) === TRUE) {
        // Check if destination is writable
        if (is_writeable($destination . '/')) {
            $zip->extractTo($destination);
            $zip->close();
            $GLOBALS['status'] = array('success' => 'Files unzipped successfully');
        }
        else {
            $GLOBALS['status'] = array('error' => 'Error: Directory not writeable by webserver.');
        }
        }
        else {
            $GLOBALS['status'] = array('error' => 'Error: Cannot read .zip archive.');
        }
    }


    public function requestCurl($url_curl, $params = null, $request_type = 'get')
    {

        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_curl);
            if ($request_type == 'post') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

            $result = curl_exec($ch);

        } catch (\Exception $e) {

            $result = false;

        }

        return $result;

    }


}
