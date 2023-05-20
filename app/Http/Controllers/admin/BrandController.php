<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $data = DB::table('brands')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionbtn = '<a href="" class="btn btn-success btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#cat_edit"><i class="fa fa-edit"></i></a>
                    <a href="'.route('brand.delete', [$row->id]).'" id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $actionbtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.category.brand.index');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|max:55'
        ]);

        $slug=Str::slug($request->brand_name, '-');

        $data = array();
        $data['brand_name'] = $request->brand_name;
        $data['brand_slug'] = Str::slug($request->brand_name, '-');
        // working with image 
        $photo = $request->brand_logo;
        $photoname = $slug.'.'.$photo->getClientOriginalExtension();
        // $photo->move('public/files/brand/', $photoname); //without image intervention
        Image::make($photo)->resize(240,120)->save('public/files/brand/'.$photoname);

        $data['brand_logo'] = 'public/files/brand/'.$photoname;
        DB::table('brands')->insert($data);

        $notification = array('messege'=>'Brand Inserted','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function destroy($id){
        $data = DB::table('brands')->where('id', $id)->first();
        $image = $data->brand_logo;

        if(File::exists($image)){
            unlink($image);
        }

        DB::table('brands')->where('id', $id)->delete();
        $notification = array('messege'=>'Brand Deleted','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $data = DB::table('brands')->where('id', $id)->first();
        return view('admin.category.brand.edit', compact('data'));
    }

    public function update(Request $request){

        $slug=Str::slug($request->brand_name, '-');

        $data = array();
        $data['brand_name'] = $request->brand_name;
        $data['brand_slug'] = Str::slug($request->brand_name, '-');

        if($request->brand_logo){
            if(File::exists($request->old_logo)){
                unlink($request->old_logo);
            }
            $photo = $request->brand_logo;
            $photoname = $slug.'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->resize(240,120)->save('public/files/brand/'.$photoname);
            $data['brand_logo'] = 'public/files/brand/'.$photoname;
            DB::table('brands')->where('id', $request->id)->update($data);

            $notification = array('messege'=>'Brand Updated','alert-type'=>'success');
            return redirect()->back()->with($notification);
        }else{
            $data['brand_logo'] = $request->old_logo;
            DB::table('brands')->where('id',$request->id)->update($data);

            $notification = array('messege'=>'Brand Updated','alert-type'=>'success');
            return redirect()->back()->with($notification);

        }
        
    }


}
