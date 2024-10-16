<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
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

        return view('backend.customers.index', $data);
    }

    public function getUsers(Request $request)
    {
        // get Administrators from user table
        $aColumns = ['users.name', 'users.status', 'users.account_type', 'users.city', 'users.country', 'users.created_at'];
        $result = User::select($aColumns);

        $iStart = $request->get('iDisplayStart');
        $iPageSize = $request->get('iDisplayLength');

        $order = 'users.id';
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
                $query->orWhere('users.name', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('users.account_type', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('users.city', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('users.country', 'LIKE', "%{$sKeywords}%");
            });
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

        $postsData = $result->where('role_id', 3)->get();

        $iTotal = $iFilteredTotal;
        $output = [
            'sEcho' => intval($request->get('sEcho')),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => [],
        ];
        $i = 0;
        foreach ($postsData as $row) {

            $sOptions = '';

            $statusArray = [
                0 => '<button type="button" class="btn waves-effect waves-light btn-info btn-sm">Pending </button>',
                1 => '<button type="button" class="btn waves-effect waves-light btn-success btn-sm">Active</button>',
                2 => '<button type="button" class="btn waves-effect waves-light btn-warning btn-sm">Inactive</button>',
                3 => '<button type="button" class="btn waves-effect waves-light btn-danger btn-sm">Suspended</button>',
            ];
            $title = $row->name;
            $status = $statusArray[rand(0, 3)];
            $output['aaData'][] = [
                'DT_RowId' => "row_{$row->id}",
                ($title),
                ($row->account_type),
                ($row->city),
                $status,
                (date('d M Y, h:iA', strtotime($row->created_at))),
                $sOptions,
            ];

            $i++;
        }
        echo json_encode($output);
    }
}
