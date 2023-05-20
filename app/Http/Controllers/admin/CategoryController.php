<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        // query builder
        // $data = DB::table('categories')->get();
        $data = Category::all(); 
        return view('admin.category.category.index', compact('data'));
    }
    public function store(Request $request){
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['category_slug'] = Str::slug($request->category_name , '-');
        // DB::table('categories')->insert($data);
        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name , '-')
        ]);

        $notification = array('messege'=>'Category Added Successfully !..','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $data = DB::table('categories')->where('id', $id)->first();
        // $data = Category::findorfail($id);
        return response()->json($data);
    }

    public function update(Request $request){
        // $data = array();
        // $data['category_name'] = $request->e_category_name;
        // $data['category_slug'] = Str::slug($request->e_category_name, '-');
        // DB::table('categories')->where('id', $request->id)->update($data);

        $data = Category::where('id', $request->id)->first();
        $data->update([
            'category_name' => $request->e_category_name,
            'category_slug' => Str::slug($request->e_category_name, '-')
        ]);
        $notification = array('messege'=>'Category Updated Successfully !..','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        // $data = Category::findorfail($id);
        // $data->delete();

        DB::table('categories')->where('id', $id)->delete();
        $notification = array('messege'=>'Category Deleted Successfully by query builder !','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    // // get child category 
    // public function GetChildCategory($id){
    //     $data = DB::table('childcategories')->where('subcategory_id', $id)->get();
    //     return response()->json($data);
    // }
    //get child category
    public function GetChildCategory($id)  //subcategory_id
    {
        $data=DB::table('childcategories')->where('subcategory_id',$id)->get();
        return response()->json($data);
    }

}
