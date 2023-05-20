<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //review store
    public function store(Request $request)
    {
        $validated = $request->validate([
           'rating' => 'required',
           'review' => 'required',
       ]);

        $check=DB::table('reviews')->where('user_id',Auth::id())->where('product_id',$request->product_id)->first();

        if ($check) {
           $notification=array('messege' => 'Already you have a review with this product !', 'alert-type' => 'error');
           return redirect()->back()->with($notification); 
        }
        //query builder
        $data=array();
        $data['user_id']=Auth::id();
        $data['product_id']=$request->product_id;
        $data['review']=$request->review;
        $data['rating']=$request->rating;
        $data['review_date']=date('d-m-Y');
        $data['review_month']=date('F');
        $data['review_year']=date('Y');
        DB::table('reviews')->insert($data);

        $notification=array('messege' => 'Thank for your review !', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function AddWishlist($id){
        $check = DB::table('wishlists')->where('product_id', $id)->where('user_id', Auth::id())->first();
        if($check){
           $notification=array('messege' => 'Already have it on your wishlist !', 'alert-type' => 'error');
           return redirect()->back()->with($notification);
        }else{
            $data = array();
            $data['product_id'] = $id;
            $data['user_id'] = Auth::id();
            DB::table('wishlists')->insert($data);
            $notification=array('messege' => 'Product added on wishlist !', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }

    }
}
