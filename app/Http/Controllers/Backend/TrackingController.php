<?php

namespace App\Http\Controllers\Backend;

use App\Inventory;
use App\Product;
use App\Supplier;
use DB;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['products'] = Product::orderBy('name', 'ASC')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'ASC')->get();

        return view('backend.inventories.index', $data);
    }

    public function inventories(Request $request)
    {
        $keyword = $request->get('q', '');
        if (! empty($request->get('start_date'))) {
            $start_date = date('Y-m-d 00:00:00', strtotime($request->get('start_date')));
        }
        if (! empty($request->get('end_date'))) {
            $end_date = date('Y-m-d 23:59:59', strtotime($request->get('end_date')));
        }
        $data['q'] = $keyword;

        $products = Product::where('name', 'like', "%$keyword%")->get();
        $ids = [];
        $sids = [];
        foreach ($products as $product) {
            $ids[] = $product->id;
        }
        // $suppliers = Supplier::where("name","like" ,  "%$keyword%")->get();
        // foreach ($suppliers as $product) {
        //     $sids[] = $product->id;
        // }
        $query = Inventory::query();
        if (! empty($keyword)) {
            $query->whereIn('product_id', $ids);
        }

        $data['start_date'] = '';
        if (! empty($start_date)) {
            $query->where('created_at', '>=', $start_date);
            $data['start_date'] = date('d-m-Y', strtotime($start_date));
        }
        $data['end_date'] = '';
        if (! empty($end_date)) {
            $query->where('created_at', '<=', $end_date);
            $data['end_date'] = date('d-m-Y', strtotime($end_date));
        }
        $inventories = $query->orderBy('id', 'DESC')->paginate(25);

        foreach ($inventories as $inventory) {
            $inventory->supplier = Supplier::where('id', $inventory->supplier_id)->first();
            $inventory->product = Product::where('id', $inventory->product_id)->first();
        }
        $data['inventories'] = $inventories;

        return view('backend.inventories.inventory', $data);
    }

    public function updateQuantity(Request $request)
    {
        $products = $request->input('product_id');
        $types = $request->input('type');
        $quantity = $request->input('quantity');
        $suppliers = $request->input('supplier_id');
        $comments = $request->input('comments');
        foreach ($products as $k => $product) {
            $addsub = $types[$k];
            $pro = Product::find($product);
            if (! empty($product) and ! empty($quantity[$k])) {
                if ($addsub == 'add') {
                    $data = [
                        'quantity' => $pro->quantity + $quantity[$k],
                        'warehouse' => $pro->warehouse - $quantity[$k],
                    ];

                    $warehouse = $pro->warehouse - $quantity[$k];

                } else {
                    $data = [
                        'quantity' => $pro->quantity - $quantity[$k],
                        // "warehouse" => $pro->warehouse - $quantity[$k]
                    ];

                    $warehouse = $pro->warehouse;
                }

                Product::where('id', $product)->update($data);

                $inventory = [
                    // "supplier_id" => $suppliers[$k],
                    'quantity' => $quantity[$k],
                    'product_id' => $product,
                    'track_type' => $types[$k],
                    'comments' => $comments[$k],
                    'storeroom' => $warehouse,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                if ($quantity[$k] > 0) {
                    DB::table('inventories')->insert($inventory);
                }

            }

        }

        return redirect('update_inventory');
    }

    public function wherehouseInventory(Request $request)
    {
        $data['products'] = Product::orderBy('name', 'ASC')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'ASC')->get();

        return view('backend.inventories.wherehouse', $data);
    }

    public function updateWhereHouseQuantity(Request $request)
    {
        $products = $request->input('product_id');
        $types = $request->input('type');
        $quantity = $request->input('quantity');
        $suppliers = $request->input('supplier_id');
        $comments = $request->input('comments');
        foreach ($products as $k => $product) {
            $addsub = $types[$k];
            $pro = Product::find($product);
            if (! empty($product) and ! empty($quantity[$k])) {
                if ($addsub == 'add') {
                    $data = [
                        'warehouse' => $pro->warehouse + $quantity[$k],
                    ];

                    $warehouse = $pro->warehouse - $quantity[$k];

                } else {
                    $data = [
                        'warehouse' => $pro->warehouse - $quantity[$k],
                    ];

                    $warehouse = $pro->warehouse;
                }

                Product::where('id', $product)->update($data);

                $inventory = [
                    // "supplier_id" => $suppliers[$k],
                    'quantity' => $quantity[$k],
                    'product_id' => $product,
                    'type' => 'wherehouse',
                    'track_type' => $types[$k],
                    'comments' => $comments[$k],
                    'storeroom' => $warehouse,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                if ($quantity[$k] > 0) {
                    DB::table('inventories')->insert($inventory);
                }

            }

        }

        return redirect('update_werehouse_inventory');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    private function searchParams($request)
    {
        return [
            'date_range' => $request->get('date_range', null),
            'product' => $request->get('product', null),
        ];
    }
}
