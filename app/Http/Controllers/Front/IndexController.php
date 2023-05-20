<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
   
    public function index(){
        $category = DB::table('categories')->get();
        // $bannerproduct = DB::table('products')->where('product_slider', 1)->latest()->first();
        $bannerproduct = Product::where('status',1)->where('product_slider', 1)->latest()->first();
        $featured = Product::where('status',1)->where('featured', 1)->orderBy('id', 'DESC')->limit(16)->get();
        $popular_product = Product::where('status',1)->orderBy('product_views', 'DESC')->limit(16)->get();
        $trendy_product = Product::where('status',1)->where('trendy', 1)->orderBy('id', 'DESC')->limit(8)->get();
        return view('frontend.index', compact('category', 'bannerproduct', 'featured', 'popular_product', 'trendy_product'));
    }

    public function ProductDetails($slug){
        $product = Product::where('slug', $slug)->first();
                     Product::where('slug', $slug)->increment('product_views');
        // $product = DB::table('products')->where('slug', $slug)->first();
        $related_product = DB::table('products')->where('subcategory_id', $product->subcategory_id)->orderBy('id', 'DESC')->take(10)->get();
        $review = Review::where('product_id', $product->id)->orderBy('id','DESC')->take(6)->get();
        return view('frontend.product.product_details', compact('product', 'related_product', 'review'));
    }

    public function ProductQuickView($id){
        $product = Product::where('id', $id)->first();
       
        return view('frontend.product.quick_view', compact('product'));
    }
}
