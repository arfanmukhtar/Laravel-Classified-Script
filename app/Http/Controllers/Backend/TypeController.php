<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $data = [
            'types' => Type::paginate(15),
        ];

        return view('backend.types.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'types' => Type::paginate(15),
        ];

        return view('backend.types.create', $data);
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
        unset($form['_token']);

        $category = Type::create($form);

        return redirect('admin/types')
            ->with('message-success', 'Type created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Type::findOrFail($id);

        return view('backend.types.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Type::findOrFail($id);

        return view('backend.types.edit', compact('category'));
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
        $category = Type::findOrFail($id);
        $category->update($form);

        return redirect('admin/types')
            ->with('message-success', 'Type updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Type::findOrFail($id);
        $customer->delete();

        return redirect('admin/types')
            ->with('message-success', 'Type deleted!');
    }
}
