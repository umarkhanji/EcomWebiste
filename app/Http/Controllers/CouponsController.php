<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
class CouponsController extends Controller
{
    public function addCoupon(Request $request)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$coupon = new Coupon();
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];
    		$coupon->status = $data['status'];
    		$coupon->save();
    	}
    	return view('admin.coupons.add_coupon');
    }
     
    public function editCoupon(Request $request,$id=null)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$coupon = Coupon::find($id);
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];
    		if(empty($data['status'])){
    			$data['status']=0;
    		}
    		$coupon->status = $data['status'];
    		$coupon->save();
    		return redirect('/admin/view-coupon/');
    	}
    	$couponDetails = Coupon::find($id);
    	return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));
    }
     
     public function  deleteCoupon($id=null)
    {
       Coupon::where(['id'=>$id])->delete();
       return redirect()->back()->with('flash_message_success','Banner has been deleted Successfully');
     }

     public function viewCoupon()
     {
     	$coupons = Coupon::all();
     	// dd($coupons);
     	return view('admin.coupons.view_coupons')->with(compact('coupons'));
     }
}
