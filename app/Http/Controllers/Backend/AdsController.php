<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use DB;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'title' => 'Listings',
        ];

        return view('backend.listings.index', $data);
    }

    public function getListings(Request $request)
    {
        // get Administrators from user table
        $aColumns = ['posts.id', 'posts.title', 'posts.category_id', 'posts.city_id', 'posts.tags', 'posts.created_at', 'posts.status'];
        $result = Post::select($aColumns);

        $status = $request->input('status');
        $iStart = $request->get('iDisplayStart');
        $iPageSize = $request->get('iDisplayLength');

        $order = 'posts.created_at';
        $sort = ' DESC';

        if ($request->get('iSortCol_0') || $request->get('iSortCol_0') == 0) { //iSortingCols
            $sOrder = 'ORDER BY  ';

            for ($i = 0; $i < intval($request->get('iSortingCols')); $i++) {
                if ($request->get('bSortable_'.intval($request->get('iSortCol_'.$i))) == 'true') {
                    $sOrder .= $aColumns[intval($request->get('iSortCol_'.$i))].' '.$request->get('sSortDir_'.$i).', ';
                }
            }

            $sOrder = substr_replace($sOrder, '', -2);
            if ($sOrder == 'ORDER BY') {
                $sOrder = ' id ASC';
            }

        }

        $sKeywords = $request->get('sSearch');
        if ($sKeywords != '') {

            $result->Where(function ($query) use ($sKeywords) {
                $query->orWhere('posts.title', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('posts.tags', 'LIKE', "%{$sKeywords}%");
            });
        }
        if ($status != '') {
            $result->where('posts.status', $status);
        }
        for ($i = 0; $i < count($aColumns); $i++) {
            $request->get('sSearch_'.$i);
            if ($request->get('bSearchable_'.$i) == 'true' && $request->get('sSearch_'.$i) != '') {
                $result->orWhere($aColumns[$i], 'LIKE', '%'.$request->orWhere('sSearch_'.$i).'%');
            }
        }
        $iFilteredTotal = $result->count();

        if ($iStart != null && $iPageSize != '-1') {
            $result->skip($iStart)->take($iPageSize);
        }

        $result->orderBy($order, trim($sort));
        $result->limit($request->get('iDisplayLength'));

        $postsData = $result->get();

        $iTotal = $iFilteredTotal;
        $output = [
            'sEcho' => intval($request->get('sEcho')),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => [],
        ];
        $i = 0;
        foreach ($postsData as $row) {
            $sOptions = '<a  href="'.url('admin/listings/view/'.$row->id).'" > <i  class="fa fa-eye" title="Preview Ad"></i></a>';

            $statusArray = [
                0 => '<button type="button" class="btn waves-effect waves-light btn-info btn-sm">Pending </button>',
                1 => '<button type="button" class="btn waves-effect waves-light btn-success btn-sm">Published</button>',
                2 => '<button type="button" class="btn waves-effect waves-light btn-warning btn-sm">Rejected</button>',
                3 => '<button type="button" class="btn waves-effect waves-light btn-danger btn-sm">Archived</button>',
            ];
            $title = $row->title;
            $status = $statusArray[$row->status];
            $output['aaData'][] = [
                'DT_RowId' => "row_{$row->id}",
                // ($checkbox),

                ($title),
                '',
                '',
                //($row->category->name),
                //($row->city->name),
                $status,
                (date('d M Y, h:iA', strtotime($row->created_at))),
                $sOptions,
            ];

            $i++;
        }
        echo json_encode($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Post::findOrFail($id);
        $images = DB::table('pictures')->where('post_id', $id)->get();

        return view('backend.listings.preview', compact('item', 'images'));
    }

    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $product = Post::find($id);
        $product->status = $status;
        $product->save();
    }
}
