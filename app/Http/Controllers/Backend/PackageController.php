<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageFeature;
use Auth;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $packages = Package::get();

        return view('backend.packages.index', ['title' => 'Packages', 'packages' => $packages]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        // print_r($data); exit;
        unset($data['_token']);
        $data['user_id'] = Auth::user()->id;
        if ($request->input('id')) {
            Package::where('id', $request->input('id'))->update($data);
        } else {
            Package::insert($data);
        }

        return redirect('admin/packages');
    }

    public function get(Request $request)
    {
        $id = $request->input('id');
        $proeprty = Package::where('id', $id)->first();
        echo json_encode($proeprty);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $property = Package::where('id', $id)->delete();
        echo 'success';
    }

    public function featuredPackages()
    {
        $packages = PackageFeature::get();

        return view('backend.packages.featured', ['title' => 'Featured Post', 'packages' => $packages]);
    }

    public function saveFeatured(Request $request)
    {
        $data = $request->all();
        // print_r($data); exit;
        unset($data['_token']);

        $data['user_id'] = Auth::user()->id;

        if ($request->input('id')) {
            PackageFeature::where('id', $request->input('id'))->update($data);
        } else {
            PackageFeature::insert($data);
        }

        return redirect('admin/featured-packages');
    }

    public function getFeatured(Request $request)
    {
        $id = $request->input('id');
        $proeprty = PackageFeature::where('id', $id)->first();
        echo json_encode($proeprty);
    }

    public function deleteFeatured(Request $request)
    {
        $id = $request->input('id');
        $property = PackageFeature::where('id', $id)->delete();
        echo 'success';
    }
}
