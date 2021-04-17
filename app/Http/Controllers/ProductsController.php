<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use Image;
use App\ProductsAttribute;
use Session;
use App\Category;
use App\Product;
use App\Coupon;
use App\ProductsImage;
use App\User;
use App\Country;
use App\Order;
use App\OrdersProduct;
use App\DeliveryAddress;
use DB;
class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {
        if($request->isMethod('post'))
        {

            $data = $request->all();
            // dd($data);
            $product = new Product;
            if(empty($data['category_id']))
            {
                return redirect()->back()->with('flash_message_error','Under Category is missing:!');
            }
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];

            if( !empty ($data['description'] ) )
            {
              $product->description = $data['description'];
            }else{
                $product->description ='';
            }

            if( !empty ($data['care'] ) ){
              $product->care = $data['care'];
            }else{
                $product->care ='';
            }


            if(empty ($data['status'] ) ){
              $status = 0;
            }else{
                $status =1;
            }
             // dd($status);
             $product->status =$status;
            $product->price = $data['price'];
            //Upload image
            if($request->hasFile('image'))
            {
               $image_tmp = Input::file('image');
               //upload image
               if($image_tmp->isValid())
               {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $large_image_path = 'images/backend_images/products/large/'.$filename;
                $small_image_path = 'images/backend_images/products/small/'.$filename;
                $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                //Resize Images
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(600,600)->save($small_image_path);
                Image::make($image_tmp)->resize(300,300)->save($medium_image_path);   
                  $product->image=$filename;
               }
            }
            // $product->image = '';
            $product->save();
            return redirect('/admin/view-product')->with('flash_message_success','Product has been added Successfully');
        }
    	$categories =Category::where(['parent_id'=>0])->get();
    	$categories_dropdown="<option value='' selected disabled>select</option>";
    	foreach($categories as $cat){
    	$categories_dropdown.="<option value='".$cat->id."'>".$cat->name."</option>";
    		   	$sub_categories =Category::where(['parent_id'=>$cat->id])->get();


    	foreach($sub_categories as $sub_cat){
    		$categories_dropdown.="<option value='".$sub_cat->id."'>&nbsp--&nbsp;".$sub_cat->name."</option>";

    	}

    	}
    	return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }


    public function viewProducts()
    {
        $products = Product::orderby('id','DESC')->get();
        $products = json_decode(json_encode($products));
        foreach ($products as $key => $value) {
            $category_name = Category::where(['id'=>$value->category_id])->first();
            $products[$key]->category_name =$category_name->name;  
             # code...
         } 
        // dd($products);
        return view('admin.products.view_products')->with('products',$products);
    }
     


     public function editProduct(Request $request,$id=null)
    {


        if($request->isMethod('post'))
        {
            $data = $request->all();
            
            // dd($data);
                        //Upload image
            if($request->hasFile('image'))
            {
               $image_tmp = Input::file('image');
               //upload image
               if($image_tmp->isValid())
               {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $large_image_path = 'images/backend_images/products/large/'.$filename;
                $small_image_path = 'images/backend_images/products/small/'.$filename;
                $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                //Resize Images
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(600,600)->save($small_image_path);
                Image::make($image_tmp)->resize(300,300)->save($medium_image_path);   
                 
               }
            }else
            {
                $filename = $data['current_image'];
            }

            if(empty($data['description']))
            {
                $data['description']='';
            }

                        if(empty($data['care']))
            {
                $data['care']='';
            }

           if(empty ($data['status'] ) ){
              $status = 0;
            }else{
                $status =1;
            }
   

            // dd($data);
            $product = Product::where(['id'=>$id])->update([
                'category_id'=>$data['category_id'],
                'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],
                'product_color'=>$data['product_color'],
                'description'=>$data['description'],
                'care'=>$data['care'],
                'price'=>$data['price'],
                 'status'=>$status,
                'image'=>$filename]);
            return redirect()->back()->with('flash_message_success','Product has been Updated');
        }
        //Get Product details
       $productDetails = Product::where(['id'=>$id])->first();

       //Category Dropdown Start
      $categories =Category::where(['parent_id'=>0])->get();
        $categories_dropdown="<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            if($cat->id ==$productDetails->category_id)
            {
                $selected="selected";
            }
            else
            {
                $selected="";
            }
        $categories_dropdown.="<option value='".$cat->id."'".$selected.">".$cat->name."</option>";
                $sub_categories =Category::where(['parent_id'=>$cat->id])->get();
      foreach($sub_categories as $sub_cat){
        if($sub_cat->id ==$productDetails->category_id)
            {
                $selected="selected";
            }
            else
            {
                $selected="";
            }
            $categories_dropdown.="<option value='".$sub_cat->id."'".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
                   }
        }
          //Category Dropdown End
        // dd($productDetails);
    
       return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }



        public function deleteProduct($id)
    {
            
        // dd($id);
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product Deleted Successfully');
       // dd($id);
    }
   

    public function getProductPrice(Request $request)
    {
      $data = $request->all();
      $proArr = explode("-", $data['idSize']);
      $proAttr = ProductsAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
       echo $proAttr->price;
       echo "#";
       echo $proAttr->stock;
    }

    public function addAttributes(Request $request,$id=null)
    {
        
        $productDetails = Product::with('Attributes')->where(['id'=>$id])->first();
               // dd($productDetails);
        if($request->isMethod('post')){
            $data = $request->all();
          foreach($data['sku'] as $key => $val)
          {
            if(!empty($val))
            {
              //Prevent Duplicate SKU Check
              $attrSKU = ProductsAttribute::where('sku',$val)->count();
              if($attrSKU>0)
              {
                 return redirect('admin/add-attributes/'.$id)->with('flash_message_error','SKU already Exists! Pls Add Another SKU');
              }

              //Prevent Duplicate Size Check
              $attrCountSizes = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
              if($attrCountSizes>0)
              {
                 return redirect('admin/add-attributes/'.$id)->with('flash_message_error','Size already Exists! Pls Add Another Size');
              }
                $attribute = new ProductsAttribute;
                $attribute->product_id = $id;
                $attribute->sku = $val; 
                $attribute->size = $data['size'][$key]; 
                $attribute->price = $data['price'][$key]; 
                $attribute->stock = $data['stock'][$key]; 
                $attribute->save();
            }

          }
          return redirect('admin/add-attributes/'.$id)->with('flash_message_success','Product Attributes has been added Successfully');
        }
      
          return view('admin.products.add_attributes')->with(compact('productDetails'));

    } 



public function editAttributes(Request $request,$id=null)
{
  if($request->isMethod('post'))
  {
    $data = $request->all();
    // dd($data);
    foreach($data['idAtt'] as $key => $attr)
    {
       ProductsAttribute::where(['id'=>$data['idAtt'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
    }

    return redirect()->back()->with('flash_message_success','Product Attributes has been Updated');
  }
}

 public function addImages(Request $request,$id=null)
 {

        
        $productDetails = Product::with('Attributes')->where(['id'=>$id])->first();
        

        if($request->isMethod('post')){
         $data = $request->all();
         if($request->hasFile('image')){ 
           $file = $request->file('image'); 
           //Upload Images After Resize
           $image = new ProductsImage;
           $extension = $file->getClientOriginalExtension();
           $filename = rand(111,99999).'.'.$extension;
           $large_image_path = 'images/backend_images/products/large/'.$filename;
           $small_image_path = 'images/backend_images/products/small/'.$filename;
           $medium_image_path = 'images/backend_images/products/medium/'.$filename;
            //Resize Images
           Image::make($file)->save($large_image_path);
           Image::make($file)->resize(600,600)->save($medium_image_path);
           Image::make($file)->resize(300,300)->save($small_image_path);   
           $image->image=$filename;
           $image->product_id = $data['product_id'];
           $image->save();
        }
        return redirect('/admin/add-images/'.$id)->with('flash_message_success','Product has been Added Successfully');
        
  }

           $productsImages = ProductsImage::where(['product_id'=>$id])->get();
          return view('admin.products.add_images')->with(compact('productDetails','productsImages'));

 } 




    public function deleteAttribute($id=null)
    {
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been deleted Successfully');

    }

    public function Products($url=null)
    {

        //Show 404 Page if page url doesnt exist
        $countCategory = Category::where(['url'=>$url,'status'=>1])->count();
        if($countCategory == 0)
         {
             abort(404);
         }

            //Get all Categories and Sub Categories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
         $categoryDetails = Category::where(['url'=>$url])->first();
         $cat_ids[]='';
         if($categoryDetails->parent_id==0)
         {
            //if url is Main Category url
            $subCategories = Category::where(['parent_id'=> $categoryDetails->id])->get();        
            foreach( $subCategories as $subcat)
            {
                 $cat_ids[]=$subcat->id;
            }
            $productsAll = Product::whereIn('category_id',$cat_ids)->where('status',1)->get();

         }else
         {
            //if url is sub Category url
             $productsAll = Product::where(['category_id'=> $categoryDetails->id])->where('status',1)->get();
         }


        
         return view('products.listing')->with(compact('categories','categoryDetails','productsAll'));
    }


   public function product($id=null)
   {

     //Show 404 Error if product is disabled
    $productCount = Product::where(['id'=>$id,'status'=>1])->count();
    if($productCount ==0){
      abort(404);
    }


    //Get Products Details
    $productDetails = Product::where('id',$id)->first();

       //Get all Categories and Sub Categories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        // Alternate Image Of Products
        $productAltImages = ProductsImage::where('product_id',$id)->get();
        // Totel Stock of Product Or Quantity
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');
        //Related Product or Recommended Products
        $related_products =  Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();
         // dd($related_product);
    return view('products.detail')->with(compact('productDetails','categories','productAltImages','total_stock','related_products'));
   } 



       public function deleteImages($id=null)
    {
        ProductsImage::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been deleted Successfully');

    }



    public function addtoCart(Request $request)
    {

       Session::forget('couponAmount');
      Session::forget('couponCode');
      $data = $request->all();
      $pro = explode("-", $data['size']);
     
      // dd($size);
      if(empty(Auth::user()->email))
      {
        $data['user_email']='';
      }else{ $data['user_email']= Auth::user()->email ;}
        
         $session_id=Session::get('session_id');
         if(empty($session_id)){
         $session_id=str_random(30);

        Session::put('session_id',$session_id);
        } 
        $countProduct = DB::table('cart')->where(['product_id'=>$data['product_id'],'product_color'=>$data['product_color'],'size'=>$pro[1],
        'session_id'=>$session_id])->count();
        // echo $countProduct;die();
         // dd($pro[1]);\
        if($countProduct>0){
              return redirect()->back()->with('flash_message_error','Product is already exist in Cart!');
        }else{

            $getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],'size'=>$pro[1]])->first();
             DB::table('cart')->insert(['product_id'=>$data['product_id'],
            'product_name'=>$data['product_name'],
            'product_code'=>$getSKU->sku,
            'product_color'=>$data['product_color'],
            'price'=>$data['price'],
            'quantity'=>$data['quantity'],
            'size'=>$pro[1],
            'user_email'=>$data['user_email'],
            'session_id'=>$session_id]);

        }
        return redirect('cart')->with('flash_message_error','Product has been Added in Cart!');
        
    }


    public function Cart()
    {
        
        if(Auth::check()){
          $user_email = Auth::user()->email;
           $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
          
          $session_id=Session::get('session_id');
          $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
        }

      foreach($userCart as $key=>$product){
         $productDetails = Product::where('id',$product->product_id)->first();
        $userCart[$key]->image=$productDetails->image;
      }
      // dd($userCart);
      return view('products.cart')->with(compact('userCart'));
    }

    public function deleteCartProduct($id=null)
    {
            Session::forget('couponAmount');
      Session::forget('couponCode');

        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','Product has been deleted Successfully!');
    }


    public function updateCartProduct($id=null,$quantity=null)
    {
                  Session::forget('couponAmount');
      Session::forget('couponCode');
      //to get the card detail form card id
      $getCartDetails = DB::table('cart')->where('id',$id)->first();
      // dd($getCartDetails);
      //tio check Sku stock is available or not
      $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
       $getAttributeStock->stock;
       $updated_quantity=$getCartDetails->quantity+$quantity;
       if( $getAttributeStock->stock >=$updated_quantity){
           
         //impt..
       DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
       return redirect('cart')->with('flash_message_success','Product has been Updated Successfully!');  
       }else{
          return redirect('cart')->with('flash_message_error','Required Prioduct Quantity is not Available!');
       }

      
    }

    public function applyCoupon(Request $request)
    {
             //First We Need to Forget Session 
       $data =$request->all();
       $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
       if($couponCount==0){
        return redirect()->back()->with('flash_message_error','Coupon is not Valid');
       }else{
        //with perform other checks like Active/Deactive Expiry Date
        
        //Get Coupon Detail
         $couponDetail = Coupon::where('coupon_code',$data['coupon_code'])->first();
          // If coupon is Inactive
         if($couponDetail->status==0){
          return redirect()->back()->with('flash_message_error','This Coupon is Inactive');
         }
         
         $expiry_date = $couponDetail->expiry_date;
         $current_date = date('Y-m-d');
         
        if($expiry_date < $current_date){
          return redirect()->back()->with('flash_message_error','This Coupon is Expired!');
         }

         //Coupon Valid For Discount
         //Get Cart Total Amount
         $session_id=Session::get('session_id');

         if(Auth::check()){
          $user_email = Auth::user()->email;
           $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
           }else{
          
          $session_id=Session::get('session_id');
          $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
        }

          $total_amount=0;
          foreach($userCart as $item){
           $total_amount = $total_amount + ($item->price* $item->quantity);
         }

         //Check if Amount Type is Fixed Or Percentage
         if($couponDetail->amount_type =="Fixed"){
          $couponAmount =$couponDetail->amount;
         }else{
          $couponAmount=$total_amount * ($couponDetail->amount/100);
         }
       //Add Coupon Code And Amount in session
         Session::put('couponAmount',$couponAmount);
         Session::put('couponCode',$data['coupon_code']);

         return redirect()->back()->with('flash_message_success','Coupon Code Successfully Applied. You are Availing Discount');
       }
    }


    public function checkOut(Request $request)
    {
      $user_id = Auth::user()->id;
      $user_email = Auth::user()->email;
      $userDetails = User::find($user_id);
      $countries = Country::get();

      $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
      if($shippingCount> 0 ){
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
      }

       //Update cart table with user email
      $session_id = Session::get('session_id');
      // dd(Session::get('session_id'));
      DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);

      if($request->isMethod('post')){
        $data = $request->all();
       if(empty($data['billing_name'])||empty($data['billing_address'])||empty($data['billing_city'])||empty($data['billing_state'])||empty($data['billing_country'])||empty($data['billing_pincode'])||empty($data['billing_mobile'])||empty($data['shipping_name'])||empty($data['shipping_address'])||empty($data['shipping_city'])||empty($data['shipping_state'])||empty($data['shipping_country'])||empty($data['shipping_pincode'])||empty($data['shipping_mobile'])){
        return redirect()->back()->with('flash_message_error','Please fill all the filled to checkout');
      }


      //Update user details
      User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'country'=>$data['billing_country'],'pincode'=>$data['billing_pincode'],'mobile'=>$data['billing_mobile']]);
     if($shippingCount > 0){
      //Update Shipping Address
      DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'country'=>$data['shipping_country'],'pincode'=>$data['shipping_pincode'],'mobile'=>$data['shipping_mobile']]);

     }else{
      //Add new Shipping Address
      $shipping = new DeliveryAddress;
      $shipping->user_id = $user_id;
      $shipping->user_email = $user_email;
      $shipping->name = $data['shipping_name'];
      $shipping->address = $data['shipping_address'];
      $shipping->city = $data['shipping_city'];
      $shipping->state = $data['shipping_state'];
      $shipping->country = $data['shipping_country'];
      $shipping->pincode  = $data['shipping_pincode'];
      $shipping->mobile = $data['shipping_mobile'];
      $shipping->save();
     }
      return redirect('/order-review');

      }
      return view('products.checkout')->with(compact('userDetails','countries','shippingDetails'));
    }

    public function oderReview()
    {
      $user_id=Auth::user()->id;
      $user_email=Auth::user()->email;
      $userDetails =User::where('id',$user_id)->first();
      $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
      //Cart Item
      $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
      foreach($userCart as $key=>$product){
         $productDetails = Product::where('id',$product->product_id)->first();
        $userCart[$key]->image=$productDetails->image;
      }
        // dd($userCart);
      // $shippingDetails = json_decode(json_encode($shippingDetails));
      return view('products.order_review')->with(compact('shippingDetails','userDetails','userCart'));
    }

    public function placeOrder(Request $request){
      if($request->isMethod('post')){
        $data = $request->all();
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        //Get Shipping Address Of User
        $shipping = DeliveryAddress::where('user_email',$user_email)->first();
        // dd($shipping);
        if(empty(Session::get('couponCode'))){
          $coupon_code='';
        }else{
          $coupon_code = Session::get('couponCode');
        }

       if(empty(Session::get('couponAmount'))){
          $coupon_amount='';
        }else{
          $coupon_amount = Session::get('couponAmount');
        }
        $order = new Order;
         // dd($shipping);
        $order->user_id = $shipping->user_id ;
        $order->user_email = $shipping->user_email ;
        $order->name = $shipping->name ;
        $order->address = $shipping->address ;
        $order->city = $shipping->city ;
        $order->state = $shipping->state ;
        $order->pincode = $shipping->pincode ;
        $order->country = $shipping->country ;
        $order->mobile = $shipping->mobile ;
        $order->coupon_code =$coupon_code;
        $order->coupon_amount = $coupon_amount;
        $order->order_status= "New";
        $order->payment_method = $data['payment_method'];
        $order->grand_total = $data['grand_total'];
        $order->save();
        
        $order_id = DB::getPdo()->lastInsertId();
        
        $cartProduct = DB::table('cart')->where('user_email',$user_email)->get();

        foreach($cartProduct  as $pro){
          $cartPro = new OrdersProduct;

          $cartPro->order_id =$order_id;
          $cartPro->user_id = $user_id ;
          $cartPro->product_id = $pro->product_id;
          $cartPro->product_code = $pro->product_code ;
          $cartPro->product_name = $pro->product_name ;
          $cartPro->product_color = $pro->product_color ;
          $cartPro->product_size= $pro->size ;
          $cartPro->product_price = $pro->price ;
          $cartPro->product_qty = $pro->quantity ;
          $cartPro->save();
        }
        Session::put('order_id',$order_id);
        Session::put('grand_total',$data['grand_total']);
        if($data['payment_method']=='COD'){
                //COD Redirect user to thanks page after  saving order
          return redirect('/thanks');
        }else{
                  //Paypal Redirect user to paypal page after  saving order
           return redirect('/paypal');
        }

      }
    }

    public function Thanks()
    {
       $user_email = Auth::user()->email;
       DB::table('cart')->where('user_email',$user_email)->delete();
       return view('orders.thanks');
    }

    public function  Paypal()
    {
      $user_email = Auth::user()->email;
       DB::table('cart')->where('user_email',$user_email)->delete();
       return view('orders.paypal');
    }

    public function userOrders(){
      $user_id = Auth::user()->id;
      $orders = Order::with('orders')->where('user_id',$user_id)->get();
      // dd($orders);
      return view('orders.user_orders')->with(compact('orders'));
    }

    public function userOrderDetails($order_id){
      $user_id = Auth::user()->id;
      $orderDetails = Order::with('orders')->where('id',$order_id)->first();
      // dd($orderDetails);
      return view('orders.user_order_details')->with(compact('orderDetails'));
    }

    public function viewOrders(){
      $orders = Order::with('orders')->orderBy('id','DESC')->get();
      $orders = json_decode(json_encode($orders));
      // echo "<pre>";print_r($orders);die();
      return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id){
      $orderDetails = Order::with('orders')->where('id',$order_id)->first();
      // dd($orderDetails);
      $user_id = $orderDetails->user_id;
      $userDetails = User::where('id',$user_id)->first();
      // dd($userDetails);
      return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }

    public function updateOrderStatus(Request $request){
      if($request->isMethod('post')){
        $data = $request->all();
        Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
        return redirect()->back()->with('flash_message_success','Order Status has been Updated Successfully');
      }

    }

}
