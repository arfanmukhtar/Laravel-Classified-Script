<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'categories' => Category::paginate(15),
        ];

        return view('backend.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'parent_categories' => Category::with("children")->whereNull('parent_id')->get(),
        ];

     

        return view('backend.category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $form = $request->all();

        $form['slug'] = Str::slug($form['name'], '-');
        $category = Category::create($form);
        $post_id = $category->id;

        $size = 150;
        $width = 700;
        if ($request->file('cat_image')) {
            $file1 = $request->file('cat_image')->store("categories/$post_id", 'local');
            $data = ['picture' => $file1];
            Category::where('id', $post_id)->update($data);

            /// compresse image size
            $img = Image::make($request->file('cat_image')->getRealPath());
            if ($img->exif('Orientation')) {
                $img = orientate($img, $img->exif('Orientation'));
            }

            try {
                mkdir("storage/categories/$post_id/resize", 0755, true);
            } catch (\Exception $e) {

            }

             $newpath = str_replace("$post_id", "$post_id/resize", $file1);
            $path2 = storage_path("$newpath");
            $img->fit($size)->save($path2);
        }

        // if (file_exists("storage/categories/temp.jpg")) {
        //     rename("storage/categories/temp.jpg", "storage/categories/$name.jpg");
        //     rename("storage/categories/thumb/temp.jpg", "storage/categories/thumb/$name.jpg");
        // }
        return redirect('admin/categories')
            ->with('message-success', 'Category created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('backend.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =

        $data = [
            'parent_categories' => Category::with("children")->whereNull('parent_id')->get(),
            'category' => Category::findOrFail($id),
        ];

        return view('backend.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = $request->all();

        $customer = Category::findOrFail($id);
        $customer->update($form);

        $size = 150;
        $post_id = $id;
        if ($request->file('cat_image')) {
            $file1 = $request->file('cat_image')->store("categories/$post_id", 'local');
            $data = ['picture' => $file1];
            Category::where('id', $post_id)->update($data);

            /// compresse image size
            $img = Image::make($request->file('cat_image')->getRealPath());
            if ($img->exif('Orientation')) {
                $img = orientate($img, $img->exif('Orientation'));
            }

            try {
                mkdir("storage/categories/$post_id/resize", 0755, true);
            } catch (\Exception $e) {

            }

             $newpath = str_replace("$post_id", "$post_id/resize", $file1);
            $path2 = storage_path("$newpath");
            $img->fit($size)->save($path2);
        }

        return redirect('admin/categories')
            ->with('message-success', 'Customer updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Category::findOrFail($id);
        $customer->delete();

        return redirect('admin/categories')
            ->with('message-success', 'Category deleted!');
    }

    ////// User upload photo and resize to 145x145 to Thumb
    public function updatePhotoCrop(Request $request)
    {
        $cropped_value = $request->input('cropped_value');
        $image_edit = $request->input('image_edit');
        $cp_v = explode(',', $cropped_value);

        $file = $request->file('file');
        $file_name = $image_edit.'.jpg';
        if (empty($image_edit)) {
            $file_name = 'temp.jpg';
        }

        if ($request->hasFile('file')) {

            $extension = $file->getClientOriginalExtension();
            $store_path = 'storage/categories/';
            $path = $file->move($store_path, $file_name);
            $img = Image::make($store_path."/$file_name");
            if ($img->exif('Orientation')) {
                $img = orientate($img, $img->exif('Orientation'));
            }

            $path2 = $store_path."thumb/$file_name";
            $img->rotate($cp_v[4] * -1);
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
            $img->fit(265, 205)->save($path2);

            echo url("storage/categories/thumb/$file_name");
            exit;
        }

        if ($image_edit != '') {
            $path = $store_path.$file_name;
            $img = Image::make($path);
            $path2 = $store_path."thumb/$file_name";
            $img->rotate($cp_v[4] * -1);
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
            $img->fit(265, 205)->save($path2);
            echo url("storage/categories/thumb/$file_name");
            exit;
        }

    }
}
