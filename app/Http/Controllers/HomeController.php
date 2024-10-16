<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Category;
use App\Models\City;
use App\Models\Post;
use Artisan;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function page($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->first();
        if (empty($page)) {
            abort(404);
        }
        if ($page->image) {
            return view('pages.dynamic_image', ['page' => $page]);
        }

        return view('pages.dynamic', ['page' => $page]);

    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSave(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');
        $content = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
        ];
        Mail::to('arfan67@gmail.com')->send(new Contact($content));
        Mail::to($email)->send(new Contact($content));
        echo 'success';
    }

    public function clearCache()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
        } catch (\Exception $e) {

        }
        echo 'Done';
        //DB::unprepared(file_get_contents('db/pos.sql'));
    }

    // public function createJsonLink()
    // {
    //     $data = [];
    //     $data[] = 'https://changanautoparts.com/post-an-ad';
    //     $data[] = 'https://changanautoparts.com/post-a-request';
    //     $categories = DB::table('categories')->get();
    //     foreach ($categories as $cat) {
    //         $data[] = secure_url("category/$cat->slug");
    //     }
    //     $locations = DB::table('cities')->get();
    //     foreach ($locations as $cat) {
    //         $data[] = secure_url("location/$cat->slug");
    //     }
    //     $posts = DB::table('posts')->get();
    //     foreach ($posts as $cat) {
    //         $data[] = secure_url("detail/$cat->slug");
    //     }

    //     echo '<pre>';
    //     print_r($data);

    //     file_put_contents('gindexing/urls.json', json_encode($data));
    // }

    public function executeCommand($command)
    {

        try {
            Artisan::call($command);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function configCache()
    {
        Artisan::call('config:cache');
    }
}
