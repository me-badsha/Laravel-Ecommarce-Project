<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class warehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $data = DB::table('warehouses')->latest()->get();
            
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionbtn = '<a href="" class="btn btn-success btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#cat_edit"><i class="fa fa-edit"></i></a>
                        <a href="'. route('warehouse.delete', [$row->id]) .'" id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                        return $actionbtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.category.warehouse.index');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'warehouse_name' => 'required|unique:warehouses',
        ]);
        $data=array();
        $data['warehouse_name']=$request->warehouse_name;
        $data['warehouse_address']=$request->warehouse_address;
        $data['warehouse_phone']=$request->warehouse_phone;
        DB::table('warehouses')->insert($data);
        $notification = array('messege'=>'Warehouse Added','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        DB::table('warehouses')->where('id', $id)->delete();
        $notification = array('messege'=>'Warehouse Deleted','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $warehouse = DB::table('warehouses')->where('id', $id)->first();
        return view('admin.category.warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request){
        $data=array();
        $data['warehouse_name']=$request->warehouse_name;
        $data['warehouse_address']=$request->warehouse_address;
        $data['warehouse_phone']=$request->warehouse_phone;
        DB::table('warehouses')->where('id', $request->id)->update($data);
        $notification = array('messege'=>'Warehouse updated','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
