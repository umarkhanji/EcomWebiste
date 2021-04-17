<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    //
    public function login(Request $request)
    {
        if($request->isMethod('post'))
        { 
        	$data = $request->all();
          $adminCount = Admin::where(['username'=> $data['username'],'password'=>md5($data['password']),'status'=>1])->count();
          // dd($adminCount);
        	//dd(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1']));
        	if($adminCount > 0)
        	{

        		Session::put('adminSession',$data['username']);
        		return redirect('/admin/dashboard');
        	}
        	else
        	{
        		return redirect('/admin')->with('flash_message_error','Invalid User name or Password');
        	}
        }
       
    	return view('admin.admin_login');
    }


    public function dashboard()
    {
    	// if(Session::has('adminSession'))
    	// {
     //         dd(Session::has('adminSession'));
    	// }else
    	// {
    	// 	return redirect('/admin')->with('flash_message_error','Please Login to Access');
    	// }
    	return view('admin.dashboard');
    }


    public function settings()
    {
    	// dd('Hiii');
    	return view('admin.settings');
    }
    
    public function chkPassword(Request $request)
    {
           $data = $request->all();
           $current_password = $data['current_pwd'];
           $check_password = User::where(['admin'=>'1'])->first();
           if(Hash::check($current_password,$check_password->password))
           {
           	echo "True";die;
           }
           else
           {
           	echo "False";die;
           }
    }
       


    public function updatePassword(Request $request)
    {
       if($request->isMethod('post'))
       {
       	$data = $request->all();
        $check_password = Admin::where(['username'=>Session::get('adminSession')])->first();
        $current_password = $data ['current_pwd'];
        if(Hash::check($current_password,$check_password->password))
           {
              $password = bcrypt($data['new_pwd']);
           //   dd($Password);
             $check_password= Admin::where(['username'=>Session::get('adminSession')])->update(['password'=>$password]);
              return redirect('/admin/settings')->with('flash_message_success','Password Updated Successfully');
           }
           else
           {
           	  return redirect('/admin/settings')->with('flash_message_error','Password Not Updated');
           }
       }
    }

    public function logout()
    {
    	session::flush();
    	return redirect('/admin')->with('flash_message_success','Logout Successfully');
    }
}
