<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pages'] = DB::table('seo_pages_meta')->get();

        return view('backend.settings.pages', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        if ($request->input('id')) {
            DB::table('seo_pages_meta')->where('id', $request->input('id'))->update($data);

            return redirect('admin/settings/pages')
                ->with('message-success', 'Updated Successfully');
        } else {
            DB::table('seo_pages_meta')->insert($data);

            return redirect('admin/settings/pages')
                ->with('message-success', 'Expense created!');
        }

    }

    public function get(Request $request)
    {
        $id = $request->input('id');
        $expnese = DB::table('seo_pages_meta')->where('id', $id)->first();
        echo json_encode($expnese);
    }
}
