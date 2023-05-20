<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function adminLogout(){
        Auth::logout();
        $notification = array('messege'=>'Log Out Successfully !..', 'alery-type'=>'success');
        return redirect()->route('admin.login')->with($notification);
    }

    public function passwordChange(){
        return view('admin.profile.password_change');
    }

    public function passwordUpdate(Request $request){
        $validated = $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $current_password = Auth::user()->password;
        $old_password = $request->old_password;
        $new_password = $request->password;
        if(Hash::check($old_password, $current_password)){
            $user = User::findorfail(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            $notification = array('messege'=>'Password Changed', 'alery-type'=>'success');
            return redirect()->route('admin.login')->with($notification);
        }else{
            $notification = array('messege'=>'Old Password Not Matched !', 'alery-type'=>'error');
            return redirect()->route('admin.login')->with($notification);
        }
    }
}
