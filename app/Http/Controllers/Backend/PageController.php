<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Str;
use Intervention\Image\ImageManagerStatic as Image;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Page Lisitng on admin.
     */
    public function index()
    {

        $pages = Page::where('title', '!=', 'footer')->paginate(25);

        return view('backend.pages.home', ['pages' => $pages, 'title' => 'Pages']);
    }

    /**
     * Page Add Form.
     */
    public function add()
    {
        $pages = Page::where('is_delete', 0)->get();

        return view('backend.pages.form', ['pages' => $pages, 'title' => 'Add New Page']);
    }

    /**
     * Page Edit.
     */
    public function edit($id)
    {
        $page = Page::find($id);

        return view('backend.pages.edit', ['page' => $page, 'title' => 'Edit Page']);
    }

    /**
     * Property Store.
     */
    public function save(Request $request)
    {
        $id = $request->input('id');
        $data = [
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'body' => $request->input('body'),
        ];

        if ($id) {
            $file_name = "page$id.jpg";
            // $data['image'] =  $file_name;
            if ($request->file('file')) {
                $file1 = $request->file('file')->store('pages', 'local');
                $data['image'] = $file1;
            }

            \Session::flash('flash_message', 'Updated Successfully');
            Page::where('id', $id)->update($data);

        } else {
            $file_name = 'page'.rand(1, 999).'.jpg';
            // $data['image'] = $file_name;
            if ($request->file('file')) {
                $file1 = $request->file('file')->store('pages', 'local');
                $data['image'] = $file1;
            }

            $insert_id = Page::insertGetId($data);
            \Session::flash('flash_message', 'Page Successfully Added.');

        }

        return redirect('admin/pages');
    }

    /**
     * Delete Page.
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        Page::where('id', $id)->update(['is_delete' => 1]);
    }

    public function footer(Request $request)
    {
        $page = Page::where('title', 'footer')->first();

        return view('backend.pages.footer', ['page' => $page, 'title' => 'Footer Page']);
    }

    public function saveFooter(Request $request)
    {
        $id = $request->input('id');
        $content = json_encode($request->content);
        Page::where('title', 'footer')->update(['body' => $content]);
    }
}
