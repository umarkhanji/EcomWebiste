<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Country;
use Auth;
use Session;
// use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    
    public function userLoginRegister(){
       
       return view('users.login_register');
    }
    
    public function login(Request $request)
    {
        if($request->isMethod('post'))
    	{
    		$data = $request->all();

    		if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
    			Session::put('frontSession',$data['email']);
    			return redirect('/cart');
    		}else{
    			return redirect()->back()->with('flash_message_error','Invalid User Name or Password');
    		}
    	}
    }

    public function register(Request $request)
    {
      	if($request->isMethod('post'))
    	{
    		$data = $request->all();
    		$userCount = User::where('email',$data['email'])->count();
    		if($userCount > 0){
    			return redirect()->back()->with('flash_message_error','User is already Exist');
    		}else{ 
    			$User =new User();
    			$User->name = $data['name'];
    			$User->email = $data['email'];
    			//Encryption not work with Auth::attempt
    			$User->password =Hash::make($data['password']);
    			$User->save();

                //Send Register Email
                $email = $data['email'];
                $msgData = ['email'=>$data['email'],'name'=>$data['name']];

                Mail::send('emails.register',$msgData,function($message) use($email){
                    $message->to($email)->subject('Registration With E-Com Website');
                });
                 

    			if(Auth::check(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]))){
    				                 Session::put('frontSession',$data['email']);
    				return redirect('/cart');
    			}
    		}
    	}
    }
   
    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails= User::find($user_id);
        // dd($userDetails);
        $countries = Country::get();

        if($request->isMethod('post')){
         $data = $request->all();
         if(empty($data['name'])){
            return redirect()->back()->with('flash_message_error','Please Enter Name to Update YOur Account');
         }
         if(empty($data['address'])){
            return redirect()->back()->with('flash_message_error','Please Enter Address to Update YOur Account');
         }
         if(empty($data['city'])){
            return redirect()->back()->with('flash_message_error','Please Enter City to Update YOur Account');
         }
         if(empty($data['state'])){
            return redirect()->back()->with('flash_message_error','Please Enter State to Update YOur Account');
         }
       if(empty($data['country'])){
            return redirect()->back()->with('flash_message_error','Please Enter Country to Update YOur Account');
         }
                if(empty($data['pincode'])){
            return redirect()->back()->with('flash_message_error','Please Enter Pincode to Update YOur Account');
         }
                if(empty($data['mobile'])){
            return redirect()->back()->with('flash_message_error','Please Enter Mobile to Update YOur Account');
         }

         $user = User::find($user_id);
         $user->name = $data['name'];
         $user->address = $data['address'];
         $user->city = $data['city'];
         $user->state = $data['state'];
         $user->country = $data['country'];
         $user->pincode = $data['pincode'];
         $user->mobile = $data['mobile'];
         $user->save();
         return redirect()->back()->with('flash_message_success','Your account detail has been successfully Updated.');
        }
    	return view('users.account')->with(compact('countries','userDetails'));
    }

    public function chkUserPassword(Request $request)
    {
       $data = $request->all();
       
       $current_password = $data['current_pwd'];
       $user_id = Auth::User()->id;
       dd($user_id);
       $check_password = User::where('id',$user_id)->first();
       if(Hash::check($current_password,$check_password->password)){
        echo "true";die;
       }else{
        echo "false";die;
       }
    }

    public function logout()
    {
    	Auth::logout();
    	Session::forget('frontSession');
        Session::forget('session_id');
        
    	return redirect('/');
    }

}
