<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    public function index()
    {

        $custom_fields = CustomField::paginate(15);
        foreach ($custom_fields as $c) {
            $cc = json_decode($c->category_ids);
            if (! empty($cc)) {
                $c->categories = \App\Models\Category::whereIn('id', json_decode($c->category_ids))->pluck('name')->implode(', ');
            } else {
                $c->categories = '';
            }

        }
        $data = [
            'title' => 'Custom Fields',
            'custom_fields' => $custom_fields,
        ];

        return view('backend.customfields.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Custom Fields',
            'categories' => \App\Models\Category::orderBy('id', 'DESC')->get(),
        ];

        return view('backend.customfields.create', $data);
    }

    public function edit($id)
    {

        $data = [
            'title' => 'Update Custom Fields',
            'custom_field' => CustomField::where('id', $id)->first(),
            'categories' => \App\Models\Category::orderBy('id', 'DESC')->get(),
        ];

        return view('backend.customfields.edit', $data);
    }

    public function store(Request $request)
    {

        $id = $request->input('id');
        $data = [
            'name' => $request->input('name'),
            'is_required' => $request->input('required'),
            'field_length' => $request->input('field_length'),
            'default_value' => $request->input('default_value'),
            'type' => $request->input('type'),
            'category_ids' => json_encode($request->input('category_ids')),
        ];
        $options = [];
        foreach ($request->input('repeater-group') as $val) {
            $options[] = $val['option'];
        }

        $data['options'] = json_encode($options);

        if ($id) {
            CustomField::where('id', $id)->update($data);
        } else {
            CustomField::insert($data);
        }

        return redirect('admin/customfields');
    }
}
