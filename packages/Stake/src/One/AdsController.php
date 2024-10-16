<?php

namespace Laravelclassified\Stake\One;

use App\Models\Category;
use App\Models\City;
use App\Models\cityArea;
use App\Models\Post;
use App\Models\Type;
use App\Models\UserFavouriteAd;
use App\Models\NotificationEmail;
use Auth;
use DB;
use Log;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Str;
use Validator;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function postAd()
    {
        $categories = Category::whereNull("parent_id")->get();
        $cities = DB::table('cities')->where('active', 1)->orderBy('name', 'ASC')->get();
        $title = 'Post a Free Ad on '.setting_by_key('title');
        $canonicalUrl = url('post-an-ad');

        $childerns = Category::where("parent_id", ">" ,  0)->count();

        return view('posts::ads.postAd', compact('categories', 'cities', 'title', 'canonicalUrl' , "childerns"));
    }

    public function getChildCategories(Request $request)
    {
        $id = $request->id;
        $type = ! empty($request->type) ? 'version' : 'model';
        $categories = \App\Models\Category::with('children')->select('id', 'slug', 'name', 'picture')->where('parent_id', $id)->get();
        $html = ' <li class="heading"><h4></h4></li>';
        foreach ($categories as $cat) {
            $html .= '<li class="'.$type.'" data-id="'.$cat->id.'" data-name="'.$cat->name.'" data-model-active="true" id="model_'.$cat->id.'">
            <a href="javascript:;">'.$cat->name;
            if ($cat->children->count()) {
                $html .= ' <i class="fa fa-angle-right"></i></a></li>';
            }
        }

        return $html;
    }

    public function postAdSave(Request $request)
    {

        $rules = [
            'title' => 'required|max:100|min:20',
            'description' => 'required',
            'seller_name' => 'required',
            'sale_price' => 'required',
            'seller_number' => 'required',
            'file1' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'required' => 'The :attribute field is required.',
            'sale_price.required' => 'The Price field is required.',
            'file1.required' => 'Atleast 1 photo required',
            'title.min' => 'Title must be greater then 20 characters',
            'title.max' => 'Title must be less then 100 characters',
        ]);

        if ($validator->fails()) {
            $errorMsg = $validator->getMessageBag()->toArray();
            $errors = '';
            foreach ($errorMsg as $k => $v) {
                $errors .= $v[0].'<br>';
            }

            echo json_encode([
                'status' => false,
                'errors' => $errors,

            ]);
            exit;
        }

        $createAccount = ($request->createAccount == 'on') ? 1 : 0;
        $negotiable = ($request->negotiable == 'on') ? 1 : 0;
        $hidePhone = ($request->hidePhone == 'on') ? 1 : 0;
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
            'condition' => $request->condition,
            'description' => $request->description,
            'price' => $request->sale_price,
            'contact_name' => $request->seller_name,
            'email' => $request->seller_email,
            'phone' => $request->seller_number,
            'negotiable' => $negotiable,
            'phone_hidden' => $hidePhone,
            'city_id' => $request->city_id,
            'area_id' => $request->area_id,
        ];

        $data["country_code"] = City::where('id', $request->city_id)->value("country_code");

        $data["status"] = getSetting("new_post_status");

        $showListingArray = [];
        if (! empty($request->input('custom'))) {
            foreach ($request->input('custom') as $key => $new) {
                $cf = DB::table('custom_fields')->where('id', $key)->first();
                $show_in_listing = $cf->show_in_listing;
                $name = $cf->name;
                if ($show_in_listing) {
                    $showListingArray[$name] = $new;
                }
            }
        }

        if (! empty($request->input('custom'))) {
            $data['custom_data'] = json_encode($request->input('custom'));
        }
        if (! empty($showListingArray)) {
            $data['show_custom_data'] = json_encode($showListingArray);
        }
        $data['created_at'] = gmdate('Y-m-d H:i:s');
        $data['updated_at'] = gmdate('Y-m-d H:i:s');
        try {
            $post_id = Post::insertGetId($data);
            Post::where('id', $post_id)->update(['slug' => $post_id.'-'.Str::slug($request->title, '-')]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

       $file1 = $file2 = $file3 = $file4 = $file5 = '';
        try {
            mkdir("storage/files/pk/$post_id", 0755, true);
        } catch (\Exception $e) {
        }

        $post_photo_limit = getSetting("post_photo_limit");
        $post_photo_limit  = !empty($post_photo_limit) ? $post_photo_limit  : 5;
        for($i = 1; $i <= $post_photo_limit; $i++) {
            if ($request->file('file' . $i)) {
                $this->savePhoto($request, 'file' . $i, $post_id);
            }
        }
       

        if ($post_id) {
            City::where('id', $request->city_id)->update([
                'counter' => DB::raw('counter+1'),
            ]);
            if ($request->area_id) {
                cityArea::where('id', $request->area_id)->update([
                    'counter' => DB::raw('counter+1'),
                ]);
            }
            if (! empty($request->category_id)) {
                Category::where('id', $request->category_id)->update([
                    'counter' => DB::raw('counter+1'),
                ]);
                $parent_id = Category::where('id', $request->category_id)->value('parent_id');
                $this->updateChildValues('categories', $parent_id);
            }

            // Type::where("id" , $request->post_type_id)->update([
            //     "counter" => DB::raw('counter+1')
            // ]);
        }
        if ($post_id and ! empty($request->input('custom'))) {
            $ids = [];
            foreach ($request->input('custom') as $k => $c) {
                $ids[] = $k;
                if (! is_array($c)) {
                    \App\Models\customFieldValueCounter::updateOrCreate([
                        'c_value' => $c,
                        'custom_field_id' => $k,
                    ],
                        [
                            'counter' => DB::raw('counter+1'),
                            'updated_at' => gmdate('Y-m-d H:i:s'),
                        ]);
                }
            }

            if (count($ids) > 0) {
                \App\Models\CustomField::whereIn('id', $ids)->update([
                    'total_posts' => DB::raw('total_posts+1'),
                ]);
            }

            //// store data in new table with values...

        }
        $url = url('post-success/'.encrypt($post_id));
        try {
            $Edata["title"] = $request->title;
            $Edata["url"] = $url;
            NotificationEmail::insert(array(
                "user_id" => Auth::user()->id,
                "module_id" => 2,
                "data" => json_encode($Edata)
            ));
           
           
        } catch(\Exception $e) {
            Log::info($e->getMessage());
        }
        
        echo json_encode(['status' => true, 'url' => $url, 'errors' => 'Ad Posted Successfully']);
    }

    public function postSuccess($id)
    {
        try {
            $id = decrypt($id);
            $post = Post::find($id);
        } catch (\Exception $e) {
            // abort(404);
            $post = [];
        }
        $intent = [];
        if (request()->get('payment') == 'card') {
            $intent = auth()->user()->createSetupIntent();
        }

        $packages = \App\Models\PackageFeature::orderBy('price', 'ASC')->get();
        $title = 'Post Success';

        return view('posts::ads.postSuccess', compact('post', 'title', 'packages', 'intent'));
    }

    public function savePhoto($request, $name, $post_id)
    {
        $size = 250;
        $valid_exensions = ['jpg', 'bmp', 'png', 'jpeg', 'gif'];
        $attachment = $request->file($name);
        $extention = $attachment->extension();
        if ($request->hasfile("$name")) {
            if (! empty($attachment) && $attachment->isValid() && (in_array($attachment->extension(), $valid_exensions))) {
                $file1 = $request->file($name)->store("files/pk/$post_id", 'local');
                $data = ['post_id' => $post_id, 'filename' => $file1];
                DB::table('pictures')->insert($data);
                /// compresse image size
                $img = Image::make($request->file($name)->getRealPath());
                if ($img->exif('Orientation')) {
                    $img = orientate($img, $img->exif('Orientation'));
                }
                try {
                    mkdir("storage/files/pk/$post_id/resize", 0755, true);
                } catch (\Exception $e) {
                }
                $newpath = str_replace("$post_id/", "$post_id/resize/", $file1);
                $path2 = storage_path("$newpath");
                $img->fit($size)->save($path2);
            }
        }
    }

    public function postARequest()
    {
        $categories = Category::get();
        $cities = DB::table('cities')->where('active', 1)->orderBy('name', 'ASC')->get();

        return view('posts::ads.postARequest', compact('categories', 'cities'));
    }

    public function postARequestSave(Request $request)
    {
        $rules = [
            'title' => 'required|max:100|min:20',
            'description' => 'required',
            'seller_name' => 'required',
            'seller_number' => 'required',
            'seller_email' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMsg = $validator->getMessageBag()->toArray();
            $errors = '';
            foreach ($errorMsg as $k => $v) {
                $errors .= $v[0].'<br>';
            }

            echo json_encode([
                'status' => false,
                'errors' => $errors,

            ]);
            exit;
        }

        $createAccount = ($request->createAccount == 'on') ? 1 : 0;
        $negotiable = ($request->negotiable == 'on') ? 1 : 0;
        $hidePhone = ($request->hidePhone == 'on') ? 1 : 0;
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'contact_name' => $request->seller_name,
            'email' => $request->seller_email,
            'phone' => $request->seller_number,
            'phone_hidden' => $hidePhone,
            'city_id' => $request->city_id,
        ];

        $data['created_at'] = gmdate('Y-m-d H:i:s');
        $data['updated_at'] = gmdate('Y-m-d H:i:s');
        try {
            $post_id = DB::table('post_buyers')->insertGetId($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

       echo json_encode(['status' => true,  'errors' => 'Ad Posted Successfully']);
    }

    public function makeFavorite(Request $request)
    {
        $post_id = $request->input('post_id');
        $user_id = Auth::user()->id;
        $exists = UserFavouriteAd::where('user_id', $user_id)->where('post_id', $post_id)->exists();
        if ($exists) {
            echo 'already';
            exit;
        }
        UserFavouriteAd::insert([
            'post_id' => $post_id,
            'user_id' => $user_id,
        ]);
        echo 'success';
    }

    public function getCustomFields(Request $request)
    {
        $category_id = $request->input('category_id');
        $user_id = Auth::user()->id;
        $fieldsIds = DB::table('custom_fields')->whereJsonContains('category_ids', $category_id)->pluck('id');
        $custom_fields = \App\Models\CustomField::whereIn('id', $fieldsIds)->get();

        return view('posts::ads.custom_fields', compact('custom_fields'));
    }

    public function getCityAreas(Request $request)
    {
        $city_id = $request->input('city_id');
        $cityAreas = \App\Models\cityArea::where('city_id', $city_id)->get();
        $html = '';
        foreach ($cityAreas as $area) {
            $html .= '<option value="'.$area->id.'">  '.$area->name.' </option>';
        }

        echo $html;
    }

    public function updateChildValues($table, $parentId)
    {
        $children = DB::table($table)->where('parent_id', $parentId)->first();
        DB::table($table)->where('id', $children->id)->update(['counter' => DB::raw('counter+1')]);
        if ($children->parent_id > 0) {
            DB::table($table)->where('id', $children->parent_id)->update(['counter' => DB::raw('counter+1')]);
        }

    }
}
