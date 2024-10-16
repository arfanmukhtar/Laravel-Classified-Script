<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Post;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = date('Y-m-d 23:59:59');
        $yersterday = date('Y-m-d 00:00:00', strtotime('- 1 day'));
        $today_date = date('Y-m-d 00:00:00');
        $last_month = date('Y-m-d h:i:s', strtotime('- 1 month'));
        $last_2month = date('Y-m-d h:i:s', strtotime('- 2 month'));
        $this_month_start = date('Y-m-d h:i:s', strtotime('first day of this month'));
        $previous_month_start = date('Y-m-d h:i:s', strtotime('first day of previous month'));
        $last_week = date('Y-m-d h:i:s', strtotime('- 1 week'));
        $last_month = date('Y-m-d h:i:s', strtotime('- 1 month'));
        $total_date = date('Y-m-d h:i:s', strtotime('- 100 month'));


        $last_3_month = date('Y-m-d h:i:s', strtotime('-3 month'));

        $last_6_month = date('Y-m-d h:i:s', strtotime('-6 month'));
        $last_1_year = date('Y-m-d h:i:s', strtotime('-1 year'));


        $data['today'] = $this->getSalesPrice($today_date, $now);
        $data['yesterday'] = $this->getSalesPrice($yersterday, $today_date);
        $data['last_week'] = $this->getSalesPrice($last_week, $now);
        $data['last_month'] = $this->getSalesPrice($last_month, $now);
        
        $data['last_3_month'] = $this->getSalesPrice($last_3_month, $now);
        $data['last_6_month'] = $this->getSalesPrice($last_6_month, $now);
        $data['last_1_year'] = $this->getSalesPrice($last_1_year, $now);

        $data['total_earning'] = $this->getSalesPrice($total_date, $now);

        $data['total_pending'] = $this->getSalesPrice($total_date, $now , 0);
        $data['total_active'] = $this->getSalesPrice($total_date, $now , 1);
        $data['total_rejected'] = $this->getSalesPrice($total_date, $now , 2);
        $data['total_archived'] = $this->getSalesPrice($total_date, $now , 3);


        $data['lastest_users'] = \App\Models\User::orderBy("id" , "DESC")->limit(10)->get();
        $data['lastest_posts'] = \App\Models\Post::orderBy("id" , "DESC")->limit(10)->get();
      


        $where = 'created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()';

        $posts_count = DB::select("SELECT COUNT(id) as total, DATE_FORMAT(created_at,'%d') as day_number, created_at as dated FROM `posts` WHERE   ".$where.' GROUP BY DAY(created_at) ORDER BY created_at DESC');
        $postarray = array();
        foreach($posts_count as $count) { 
            $postarray[] = array(
                "date" => $count->dated,
                "visits" => $count->total
            );
        }

        $data["postarray"] = $postarray;

        return view('backend.dashboard.home' , $data);
    }

    public function sortBy($a, $b)
    {
        return strcmp($a->total_sales, $b->total_sales);
    }

    public function getSalesPrice($start, $end , $status = "")
    {
        if($status != "") { 
            $query = DB::table('posts')->where("status" , $status)->count();
        } else { 
            $query = DB::table('posts')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->count();
        }
       

        return $query;
    }


}
