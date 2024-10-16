<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\UserProfile;
use Auth;
use DB;
use Image;
use Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $title = 'Personal Home';
        $user = User::find(Auth::user()->id);

        return view('account.home', compact('title', 'user'));
    }

    public function myAds()
    {
        // Get the user's ads (paginate them)
        $ads = Post::with('mainPhoto')->where('user_id', Auth::user()->id)->orderBy("id" , "DESC")->paginate(5);
        // Set the page title
        $title = 'My Ads';
        // Prepare data to be passed to the view
        $data = [
            'title' => $title,
            'ads' => $ads,
        ];

        // Return the view with the data
        return view('account.my_ads', $data);
    }

    public function favouriteAds()
    {
        $favoriteAds = DB::table('user_favourite_ads')->where('user_id', Auth::user()->id)->pluck('id');
        $ads = Post::with('mainPhoto')->whereIn('id', $favoriteAds)->orderBy("id" , "DESC")->paginate(5);
        foreach ($ads as $ad) {
            $ad->image = DB::table('pictures')->where('position', 0)->where('post_id', $ad->id)->value('filename');
        }

        $title = 'Favourite Ads';
        $data['title'] = $title;
        $data['ads'] = $ads;

        return view('account.favourite_ads', $data);
    }

    public function savedSearch()
    {
        $title = 'Saved Search';

        return view('account.saved_search', compact('title'));
    }

    public function archivedAds()
    {
        $ads = Post::with('mainPhoto')->where('user_id', Auth::user()->id)->where('status', 3)->orderBy("id" , "DESC")->paginate(5);
        foreach ($ads as $ad) {
            $ad->image = DB::table('pictures')->where('position', 0)->where('post_id', $ad->id)->value('filename');
        }
        $title = 'Archived Ads';
        $data['title'] = $title;
        $data['ads'] = $ads;

        return view('account.archived_ads', $data);
    }

    public function pendingApproval()
    {

        $ads = Post::with('mainPhoto')->where('user_id', Auth::user()->id)->where('status', 0)->orderBy("id" , "DESC")->paginate(5);
        foreach ($ads as $ad) {
            $ad->image = DB::table('pictures')->where('position', 0)->where('post_id', $ad->id)->value('filename');
        }
        $title = 'Pending Approval';
        $data['title'] = $title;
        $data['ads'] = $ads;

        return view('account.pending_approval', $data);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        unset($data['_token']);
        unset($data['email']);
        unset($data['name']);
        User::where('id', Auth::user()->id)->update($data);
        // UserProfile::updateOrCreate(['user_id' => Auth::user()->id], $data);

        echo 'success';
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        if (! empty($data['password']) and $data['password'] != $data['conf_password']) {
            echo 'not';
            exit;
        }
        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($request->input('password')),
        ]);

        echo 'success';
    }

    public function editAd($id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if (empty($post)) {
            return back();
        }
        $data['categories'] = Category::get();
        $data['cities'] = \App\Models\City::get();
        $data['post'] = $post;
        $data['title'] = 'Update post';

        return view('account.edit_ad', $data);
    }

    public function getCustomFields(Request $request)
    {
        $category_id = $request->input('id');
        $post_id = $request->input('post_id');
        $fieldsIds = DB::table('custom_fields')->whereJsonContains('category_ids', $category_id)->pluck('id');
        $custom_fields = \App\Models\CustomField::whereIn('id', $fieldsIds)->get();
        $post = Post::find($post_id);

        return view('account.custom_fields', compact('custom_fields', 'post'));

    }

    public function saveAd(Request $request)
    {
        $inputs = $request->all();
        $post_id = $request->input('post_id');
        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'city_id' => $request->city_id,
        ];
        if (! empty($request->input('custom'))) {
            $data['custom_data'] = json_encode($request->input('custom'));
        }
        $data['updated_at'] = gmdate('Y-m-d H:i:s');

        if ($post_id) {
            \App\Models\Post::where('id', $post_id)->update($data);
        }
        echo 'success';
        // print_r($inputs); exit;
    }

    public function editPhotos(Request $request, $id)
    {
        $data['title'] = 'Update Photos';
        $data['post'] = Post::find($id);
        $data['photos'] = \App\Models\Picture::where('post_id', $id)->get();

        $photo_id = $request->get("p");
        if($photo_id) { 
            $data['photo'] = \App\Models\Picture::where('id', $photo_id)->first();
        }
       

        return view('account.edit_photos', $data);
    }

    public function uploadPhoto($id)
    {
        $data['title'] = 'Update Photos';
        $data['post'] = Post::find($id);
        $data['photos'] = \App\Models\Picture::where('post_id', $id)->get();

        return view('account.edit_photos', $data);
    }
    public function deletePhoto(Request $request)
    {
        $id = $request->input("photo_id");
         \App\Models\Picture::where('id', $id)->delete();
         echo "success";
    }
    public function updatePhoto(Request $request)
    {
        $cropped_value = $request->input('value');
        $photo_id = $request->input('photo_id');
        $post_id = $request->input('post_id');
        $cp_v = explode(',', $cropped_value);
        $store_path = 'storage/';
        $file_name = \App\Models\Picture::where('id', $photo_id)->value("filename");
        $path2 = $store_path.$file_name;
        $img = Image::make($path2);
        $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
        $img->fit($cp_v[0],$cp_v[1])->save($path2);

        /// thumb Image
        // $size = 250;
        // $newpath = str_replace("$post_id/", "$post_id/resize/", $path2); 
        // $img = Image::make($newpath);
        // $img->fit($size, $size)->save($newpath);

        echo "success";
    }

    public function uploadUserPhoto(Request $request) { 
        $user_id = Auth::user()->id;
        $validation = Validator::make($request->all(), [
            'profile_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
           ]);
           if($validation->passes())
           {
            try {
                mkdir("storage/users/$user_id", 0755, true);
            } catch (\Exception $e) {
            }
            $image = $request->file('profile_img');
            $new_name = $user_id. '.jpg';
            $store_path = 'storage/users/' . $user_id . "/";
            $image->move( $store_path, $new_name);
           }
    }

}
