<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $page = DB::table('pages')->latest()->get();
        return view('admin.setting.page.index', compact('page'));
    }

    public function create(){
        return view('admin.setting.page.create');
    }

    public function store(Request $request){
        $data = array();
        $data['page_position'] = $request->page_position;
        $data['page_name'] = $request->page_name;
        $data['page_slug'] = Str::slug($request->page_name, '-');
        $data['page_title'] = $request->page_title;
        $data['page_description'] = $request->page_description;

        DB::table('pages')->insert($data);
        $notification = array('messege'=>'page created','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        DB::table('pages')->where('id', $id)->delete();
        $notification = array('messege'=>'page deleted','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id){
        $page = DB::table('pages')->where('id', $id)->first();
        return view('admin.setting.page.edit', compact('page'));
    }

    public function update(Request $request, $id){
        $data = array();
        $data['page_position'] = $request->page_position;
        $data['page_name'] = $request->page_name;
        $data['page_slug'] = Str::slug($request->page_name, '-');
        $data['page_title'] = $request->page_title;
        $data['page_description'] = $request->page_description;

        DB::table('pages')->where('id', $id)->update($data);
        $notification = array('messege'=>'page Updated','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
