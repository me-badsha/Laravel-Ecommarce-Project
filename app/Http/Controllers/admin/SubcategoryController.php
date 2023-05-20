<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $data = DB::table('subcategories')->leftjoin('categories', 'subcategories.category_id', 'categories.id')
        ->select('subcategories.*', 'categories.category_name')->get();
        $category =  DB::table('categories')->get();

        // $data = Subcategory::all();
        // $category = Category::all();
        return view('admin.category.subcategory.index', compact('data', 'category'));
    }

    public function store(Request $request){
        // $data = array();
        // $data['category_id'] = $request->category_id;
        // $data['subcategory_name'] = $request->subcategory_name;
        // $data['subcat_slug'] = Str::slug($request->subcategory_name, '-');
        // DB::table('subcategories')->insert($data);

        Subcategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'subcat_slug'=>Str::slug($request->subcategory_name, '-'),
        ]);

        $notification = array('messege'=>'subcategory inserted', 'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
    public function destroy($id){
        DB::table('subcategories')->where('id', $id)->delete();
        $notification = array('messege'=>'subcategory Deleted', 'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $data = DB::table('subcategories')->where('id', $id)->first();
        // $data = Subcategory::find($id);
        $category = DB::table('categories')->get();
        return view('admin.category.subcategory.edit', compact('data', 'category'));
    }

    public function update(Request $request){
        // $data = array();
        // $data['category_id'] = $request->category_id;
        // $data['subcategory_name'] = $request->subcategory_name;
        // $data['subcat_slug'] = Str::slug($request->subcategory_name, '-');
        // DB::table('subcategories')->where('id', $request->id)->update($data);

        $subcategory = Subcategory::where('id', $request->id)->first();
        $subcategory->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'subcat_slug'=>Str::slug($request->subcategory_name, '-'),
        ]);
        
        $notification = array('messege'=>'subcategory updated', 'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
