<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['roles'] = Role::get();

        return view('backend.roles.home', $data);
    }

    public function edit($id)
    {
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::get();
        $data['permissions_role'] = DB::table('permission_role')->where('role_id', $id)->get();

        return view('backend.roles.edit', $data);
    }

    public function update(Request $request)
    {
        $role_id = $request->input('id');
        $role_array = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];

        Role::where('id', $role_id)->update($role_array);
        $permissions = $request->input('permissions');
        DB::table('permission_role')->where('role_id', $role_id)->delete();
        foreach ($permissions as $permission) {

            DB::table('permission_role')->insert(['role_id' => $role_id, 'permission_id' => $permission]);
        }

        return redirect("admin/roles/edit/$role_id");
    }
}
