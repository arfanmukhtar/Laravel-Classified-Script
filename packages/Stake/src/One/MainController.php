<?php

namespace Laravelclassified\Stake\One;

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
use Mail;

class MainController extends Controller
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

    

    public function home()
    {
        $categories = Category::whereNull('parent_id')->get();
        $featured_posts = Post::with('mainPhoto')->whereNotNull('slug')->where('featured', 1)->limit(10)->orderBy("created_at" , "DESC")->get();
        $posts = Post::with('mainPhoto')->whereNotNull('slug')->orderBy('id', 'DESC')->limit(10)->get();
        $budgets = \App\Models\BudgetFilter::orderBy("id" , "DESC")->get();
        $cities = DB::table('cities')->where('active', 1)->orderBy('counter', 'DESC')->get();
        $videos = DB::table("home_videos")->limit(5)->orderBy("id" , "DESC")->get();
        return view('posts::home', compact('categories', 'posts', 'featured_posts', 'cities' , 'videos' , 'budgets'));
    }


    public function search(Request $request)
    {
        $search_ads_count = getSetting('search_ads_count');
        $load_more_count = getSetting('load_more_count');
        $itemsText = 'Items';
        $countryName = DB::table("countries")->where("id" , getSetting("op_country"))->value("name");
        if(!empty($countryName)) { 
            $locationText = json_decode($countryName)->en;
        } else { 
            $locationText = "your area";
        }

        $q = $request->get('q');
        $location = $request->get('l');
        $locationArea = $request->get('la');
        $category = $request->get('c');
        $subCategory = $request->get('sc');
        $price = $request->get('p');
        $sort_by = $request->get('sort');
        $city_ids = [];
        $category_ids = [];
        $minPrice = null;
        $maxPrice = null;

        if (! empty($price)) {
            $splitPrice = explode('_', $price);
            $minPrice = $splitPrice[0];
            $maxPrice = $splitPrice[1];
        }

        $childEnd = true;
        $custom_fields = array();
        if (isset($category)) {
            $category_names = explode('/', $category);
            $category_ids = Category::whereIn('slug', $category_names)->pluck('id');
            $categoryName = Category::whereIn('slug', $category_names)->pluck('name');
            $categoryName = json_decode(json_encode($categoryName), true);
            $itemsText = implode(', ', $categoryName);
            $catG = Category::whereIn('id' , $category_ids)->first();

            $fieldsIds = DB::table('custom_fields')->whereJsonContains('category_ids', "$catG->id")->pluck('id');
            $custom_fields = \App\Models\CustomField::whereIn('id', $fieldsIds)->get();

            if($catG->hasChildren()) {
                $categories = Category::whereIn('parent_id' , $category_ids)->orderBy("counter" , "DESC")->get();
            } else {  
                $childEnd = false;
                if($catG->parent_id > 0) {
                    $categories = Category::where('parent_id' , $catG->parent_id)->orderBy("counter" , "DESC")->get();
                } else { 
                    $categories = Category::whereNull('parent_id')->orderBy("counter" , "DESC")->get();
                }
                
            }
        } else {
            $categories = Category::whereNull('parent_id')->orderBy("counter" , "DESC")->get();
        }
        $cityNames = "";
        if (!empty($location)) {
            $city_names = explode('/', $location);
            $city_ids = City::whereIn('slug', $city_names)->pluck('id');
            $cityNames = City::whereIn('slug', $city_names)->pluck('name');
            $cityNames = json_decode(json_encode($cityNames), true);
            $locationText = implode(', ', $cityNames);
        }

        $posts = Post::with('mainPhoto')->whereNotNull('slug')->where("status" , 1);

        if (count($city_ids) > 0) {
            $city_ids = json_decode(json_encode($city_ids), true);
            $posts->whereIn('city_id', $city_ids);
        }
        $location_areas = [];
        if (isset($locationArea)) {
            $location_areas = explode('/', $locationArea);
            $posts->whereIn('area_id', $location_areas);
        }
        $sub_categories = [];
        if (isset($subCategory)) {
            $sub_categories = explode('/', $subCategory);
            $posts->whereIn('category_id', $sub_categories);
            $category_ids = json_decode(json_encode($category_ids), true);
        } else {
            if (count($category_ids) > 0) {
                $category_ids = json_decode(json_encode($category_ids), true);
                $childCategories = \App\Models\Category::whereIn('parent_id', $category_ids)->pluck('id');

                if (count($childCategories) > 0) {
                    $childCategories = $childCategories->toArray();
                    $categoryIds = array_merge($category_ids, $childCategories);
                } else {
                    $categoryIds = $category_ids;
                }

                $posts->whereIn('category_id', $categoryIds);
            }
        }

        if ($maxPrice > 0 and $minPrice > 0) {
            $posts->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($maxPrice > 0) {
            $posts->where('price', '<', $maxPrice);
        } elseif ($minPrice > 0) {
            $posts->where('price', '>', $minPrice);
        }

        if ($q) {
            $posts->where('title', 'LIKE', "%$q%");
        }
        
        if ($sort_by > 1) {
            if ($sort_by == 2) {
                $posts->orderBy('price', 'DESC');
            }
            if ($sort_by == 3) {
                $posts->orderBy('price', 'ASC');
            }
            if ($sort_by == 4) {
                $posts->orderBy('created_at', 'DESC');
            }
            if ($sort_by == 5) {
                $posts->orderBy('created_at', 'ASC');
            }
        } else { 
            $posts->orderBy('featured', "DESC")->orderBy('created_at', 'DESC');
        }

        $total_count = $posts->count();
        $posts = $posts->take($search_ads_count)->get();
        $cities = \App\Models\City::where('active', 1)->get();
        $title = "$itemsText for sale in $locationText";
        $title_page = "$itemsText for sale in <span class='opC'>$locationText</span>";

        
        if(count($location_areas) < 0) { 
            $location_areas = "";
        } else { 
            $location_areas = implode("," , $location_areas);
        }

       
        return view('posts::search', compact('title' , 'title_page','location', 'cityNames', 'custom_fields',  'childEnd', 'categories', 'sub_categories', 'posts', 'cities', 'location_areas', 'total_count', 'category_ids', 'city_ids', 'q', 'minPrice', 'maxPrice', 'sort_by'));
    }

    public function category($slug)
    {
        $countryName = DB::table("countries")->where("id" , getSetting("op_country"))->value("name");
        if(!empty($countryName)) { 
            $countryName = json_decode($countryName)->en;
        } else { 
            $countryName = "Area";
        }
        // $categories = Category::whereNull('parent_id')->get();
        $category = Category::where('slug', $slug)->first();
        if(empty($category)) abort(404);
        $childCategories = \App\Models\Category::where('parent_id', $category->id)->pluck('id');
        $category_ids = [$category->id];
        if (count($childCategories) > 0) {
            $childCategories = $childCategories->toArray();
            $categoryIds = array_merge($category_ids, $childCategories);
        } else {
            $categoryIds = $category_ids;
        }
        $childEnd = true;
        if($category->hasChildren()) {
            $categories = Category::whereIn('parent_id' , $category_ids)->orderBy("counter" , "DESC")->get();
        } else {  
            $childEnd = false;
            if($category->parent_id > 0) {
                $categories = Category::where('parent_id' , $category->parent_id)->orderBy("counter" , "DESC")->get();
            } else { 
                $categories = Category::whereNull('parent_id')->orderBy("counter" , "DESC")->get();
            }
            
        }
       
        $fieldsIds = DB::table('custom_fields')->whereJsonContains('category_ids', "$category->id")->pluck('id');
        $custom_fields = \App\Models\CustomField::whereIn('id', $fieldsIds)->get();
        $posts = Post::with('mainPhoto')->whereNotNull('slug')->whereIn('category_id', $categoryIds);
        $total_count = $posts->count();
        $posts = $posts->take(10)->get();
        $cities = DB::table('cities')->where('active', 1)->get();

        if($category->parent_id > 0) {
            $sub_categories = [$category->id];
        } else { 
            $sub_categories = [];
        }
       
        $city_ids = [];

        if (!empty($category->name)) {
            $title = $category->name." for sale in $countryName";
            $title_page = $category->name." for sale in <span class='opC'>$countryName</span>";
        } else { 
            $title = " Items for sale in $countryName";
            $title_page = "Items for sale in <span class='opC'>$countryName</span>";
        }

        $canonicalUrl = url('category/'.$slug);

        $sort_by = 1;
        
        $location_areas = "";
        return view('posts::search', compact('categories', 'title_page', 'location_areas', 'custom_fields','childEnd', 'sub_categories', 'sort_by', 'posts', 'cities', 'title', 'canonicalUrl', 'total_count', 'category_ids', 'city_ids'));
    }

    public function location($slug)
    {
        $q = '';
        $categories = Category::orderby('name', 'ASC')->whereNull('parent_id')->get();
        $city = City::where('slug', $slug)->first();
        $posts = Post::with('mainPhoto')->whereNotNull('slug')->where('city_id', $city->id);
        $total_count = $posts->count();
        $posts = $posts->take(10)->get();
        $cities = City::where('active', 1)->get();
        $category_ids = [];
        $city_ids = [$city->id];

       
        $title = 'Items For Sale in '.$city->name;
        $title_page = "Items for sale in <span class='opC'>$city->name</span>";
        $canonicalUrl = url('location/'.$slug);
        $sort_by = 1;
        $sub_categories = [];
        $childEnd = true;
        $location_areas = "";
        return view('posts::search', compact('categories', 'location_areas', 'childEnd', 'sub_categories', 'sort_by', 'posts', 'cities', 'title','title_page', 'canonicalUrl', 'total_count', 'category_ids', 'city_ids', 'q'));
    }


    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (empty($post)) {
            abort(404);
        }
        $images = DB::table('pictures')->where('post_id', $post->id)->get();
        $title = $post->title;
        $canonicalUrl = url('detail/'.$post->slug);

        $relatedAds = Post::with("mainPhoto")->where('category_id', $post->category_id)->limit(4)->get();
        return view('posts::detail', compact('post' , 'relatedAds', 'images', 'title', 'canonicalUrl'));
    }


    public function userAds($name)
    {
        $q = request()->get('q');
        $sort_by = request()->get('sort');
        $price = request()->get('p');
        $categories = Category::orderby('name', 'ASC')->whereNull('parent_id')->get();
        $ids = explode("-" , $name);
        $user = \App\Models\User::find($ids[0]);
        $posts = Post::with('mainPhoto')->whereNotNull('slug')->where('user_id', $ids[0]);
        if ($q) {
            $posts->where('title', 'LIKE', "%$q%");
        }

        $minPrice = null;
        $maxPrice = null;

        if (! empty($price)) {
            $splitPrice = explode('_', $price);
            $minPrice = $splitPrice[0];
            $maxPrice = $splitPrice[1];
        }

        if ($maxPrice > 0 and $minPrice > 0) {
            $posts->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($maxPrice > 0) {
            $posts->where('price', '<', $maxPrice);
        } elseif ($minPrice > 0) {
            $posts->where('price', '>', $minPrice);
        }

        if ($sort_by > 1) {
            if ($sort_by == 2) {
                $posts->orderBy('price', 'DESC');
            }
            if ($sort_by == 3) {
                $posts->orderBy('price', 'ASC');
            }
            if ($sort_by == 4) {
                $posts->orderBy('created_at', 'DESC');
            }
            if ($sort_by == 5) {
                $posts->orderBy('created_at', 'ASC');
            }
        } else { 
            $posts->orderBy('featured', "DESC")->orderBy('created_at', 'DESC');
        }
        
        $total_count = $posts->count();
        $posts = $posts->paginate(10);
        $cities = City::where('active', 1)->get();
        $category_ids = [];
        $city_ids = [];

        $title = 'Items for sale by ' . $user->name;
        $canonicalUrl = url('user/'.$name);
        $sort_by = 1;
        $sub_categories = [];
        $childEnd = true;
        
        return view('posts::user_ads', compact('categories', 'childEnd', 'sub_categories', 'sort_by', 'posts', 'cities', 'title', 'canonicalUrl', 'total_count', 'category_ids', 'city_ids', 'q'));
    }

    

}
