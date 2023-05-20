<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;


class settingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function seo(){
        $data = DB::table('seos')->first();
        return view('admin.setting.seo', compact('data'));
    }

    public function update(Request $request, $id){
        $data = array();
        $data['meta_title'] = $request->meta_title;
        $data['meta_author'] = $request->meta_author;
        $data['meta_tag'] = $request->meta_tag;
        $data['meta_description'] = $request->meta_description;
        $data['meta_keyword'] = $request->meta_keyword;
        $data['google_verification'] = $request->google_verification;
        $data['google_analytics'] = $request->google_analytics;
        $data['alexa_verification'] = $request->alexa_verification;
        $data['google_adsense'] = $request->google_adsense;
        DB::table('seos')->where('id', $id)->update($data);
        $notification = array('messege'=>'Seo Setting Updated','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function smtp(){
        $smtp = DB::table('smtp')->first();
        return view('admin.setting.smtp', compact('smtp'));
    }

    public function smtpUpdate(Request $request, $id){
        $data = array();
        $data['mailer'] = $request->mailer;
        $data['host'] = $request->host;
        $data['port'] = $request->port;
        $data['user_name'] = $request->user_name;
        $data['password'] = $request->password;
        DB::table('smtp')->where('id', $id)->update($data);
        $notification = array('messege'=>'SMTP Setting Updated','alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function website(){
        $setting = DB::table('settings')->first();
        return view('admin.setting.website_setting', compact('setting'));
    }

    // public function websiteUpdate(Request $request, $id){
    //     $data = array();
    //     $data['currency'] = $request->currency;
    //     $data['phone_one'] = $request->phone_one;
    //     $data['phone_two'] = $request->phone_two;
    //     $data['main_email'] = $request->main_email;
    //     $data['support_email'] = $request->support_email;
    //     $data['address'] = $request->address;
    //     $data['facebook'] = $request->facebook;
    //     $data['twitter'] = $request->twitter;
    //     $data['instagram'] = $request->instagram;
    //     $data['linkedin'] = $request->linkedin;
    //     $data['youtube'] = $request->youtube;
    //     if($request->logo){
    //         $logo = $request->logo;
    //         $logo_name = uniqid().'.'.$logo->getClientOriginalExtension();
    //         Image::make($logo)->resize(320, 120)->save('public/files/setting/'.$logo_name);
    //         $data['logo'] = 'public/files/setting/'.$logo_name;
    //     }else{
    //         $data['logo'] = $request->old_logo;
    //     }
    //     if($request->favicon){
    //         $favicon = $request->favicon;
    //         $favicon_name = uniqid().'.'.$favicon->getClientOriginalExtension();
    //         Image::make($favicon)->resize(32, 32)->save('public/files/setting/'.$favicon_name);
    //         $data['favicon'] = 'public/files/setting/'.$favicon_name;
    //     }else{
    //         $data['favicon'] = $request->old_favicon;
    //     }
    //     DB::table('settings')->where('id', $id)->update($data);
    //     $notification = array('messege'=>'Setting Updated','alert-type'=>'success');
    //     return redirect()->back()->with($notification);
      
    // }
     //website setting update
     public function WebsiteUpdate(Request $request,$id)
     {
         $data=array();
         $data['currency']=$request->currency;
         $data['phone_one']=$request->phone_one;
         $data['phone_two']=$request->phone_two;
         $data['main_email']=$request->main_email;
         $data['support_email']=$request->support_email;
         $data['address']=$request->address;
         $data['facebook']=$request->facebook;
         $data['twitter']=$request->twitter;
         $data['instagram']=$request->instagram;
         $data['linkedin']=$request->linkedin;
         $data['youtube']=$request->youtube;
         if ($request->logo) {  //jodi new logo die thake
               $logo=$request->logo;
               $logo_name=uniqid().'.'.$logo->getClientOriginalExtension();
               Image::make($logo)->resize(320,120)->save('public/files/setting/'.$logo_name); 
             $data['logo']='public/files/setting/'.$logo_name;  
         }else{   //jodi new logo na dey
             $data['logo']=$request->old_logo;
         }
 
         if ($request->favicon) {  //jodi new logo die thake
               $favicon=$request->favicon;
               $favicon_name=uniqid().'.'.$favicon->getClientOriginalExtension();
               Image::make($favicon)->resize(32,32)->save('public/files/setting/'.$favicon_name); 
               $data['favicon']='public/files/setting/'.$favicon_name;  
         }else{   //jodi new logo na dey
             $data['favicon']=$request->old_favicon;
         }
 
         DB::table('settings')->where('id',$id)->update($data);
         $notification=array('messege' => 'Setting Updated!', 'alert-type' => 'success');
         return redirect()->back()->with($notification);
 
 
     }
}

