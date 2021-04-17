<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
 
Route::get('/','IndexController@index');

Route::match(['get','post'],'/admin','AdminController@login');
Route::get('/admin/dashboard','AdminController@dashboard');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//Category /Listing Page
Route::get('/products/{url}','ProductsController@Products');

//Product detail Page
Route::get('/product/{url}','ProductsController@Product');

//Get Product Attribute Price
Route::get('/get-product-price','ProductsController@getProductPrice');


//Add to Cart Route
Route::match(['get','post'],'/add-cart','ProductsController@addtoCart');
//Cart Items
Route::match(['get','post'],'/cart','ProductsController@Cart');
//Delete Cart Items
Route::match(['get','post'],'/cart/delete-product/{id}','ProductsController@deleteCartProduct');

//Update Quantity Or Quantity Increment
Route::match(['get','post'],'/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartProduct');

//Apply Coupon 
Route::match(['get','post'],'/cart/apply-coupon','ProductsController@applyCoupon');

//Users Login/Register Page
Route::get('/login-register','UsersController@userLoginRegister');

//Users Register Form Submit
Route::post('/user-register','UsersController@register');

//Users login Form Submit
Route::post('/user-login','UsersController@login');

//Logout
Route::get('/user-logout','UsersController@logout');

//All Routes After Login
Route::group(['middleware'=>['frontlogin']],function(){

 //Account
Route::match(['get','post'],'/account','UsersController@account');   
//Check user Current Password
Route::post('/check-user-pwd','UsersController@chkUserPassword');

//Checkc out
Route::match(['get','post'],'/checkout','ProductsController@checkOut');  

//Order Review
Route::match(['get','post'],'/order-review','ProductsController@oderReview'); 

//Place Order
Route::match(['get','post'],'/place-order','ProductsController@placeOrder'); 

//Thanks Page
Route::get('/thanks','ProductsController@Thanks'); 

//Paypal Route
Route::get('/paypal','ProductsController@Paypal'); 

//User Order Page
Route::get('/orders','ProductsController@userOrders');

//User Order Products Page
Route::get('/orders/{id}','ProductsController@userOrderDetails');
});


Route::group(['middleware'=>['adminlogin']],function()
{ 
    //Admin Controller Route
	Route::get('/admin/dashboard','AdminController@dashboard');
	Route::match(['get','post'],'/admin/settings','AdminController@settings');
	Route::get('/admin/check-pwd/','AdminController@chkPassword');
	Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

	//Category Controller Route
	Route::match(['get','post'],'/admin/add-category/','CategoryController@addCategory');
	Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCotegory');
	Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCotegory');
	Route::get('/admin/view-categories','CategoryController@viewCategories');

        //Product Controller Route
        Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
        Route::match(['get','post'],'/admin/view-product','ProductsController@viewProducts');

        Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
        Route::match(['get','post'],'/admin/delete-product/{id}','ProductsController@deleteProduct');

        //Products Attributes Route
        Route::match(['get','post'],'/admin/add-attributes/{id}','ProductsController@addAttributes');
        Route::match(['get','post'],'/admin/edit-attributes/{id}','ProductsController@editAttributes');
        Route::match(['get','post'],'/admin/delete-attributes/{id}','ProductsController@deleteAttributes');
        Route::match(['get','post'],'/admin/add-images/{id}','ProductsController@addImages');
        Route::match(['get','post'],'/admin/delete-images/{id}','ProductsController@deleteImages');
        
        //Banner 
         Route::match(['get','post'],'/admin/add-banner','BannersController@addBanner');
         Route::match(['get','post'],'/admin/view-banners/','BannersController@viewBanners');
         Route::match(['get','post'],'/admin/edit-banner/{id}','BannersController@editBanner');
         Route::match(['get','post'],'/admin/delete-banner/{id}','BannersController@deleteBanners');

         //Coupon 
         Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
         Route::match(['get','post'],'/admin/view-coupon','CouponsController@viewCoupon');
         Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@editCoupon');
         Route::match(['get','post'],'/admin/delete-coupon/{id}','CouponsController@deleteCoupon');

         //Admin Order Route
         Route::get('/admin/view-orders','ProductsController@viewOrders');

         //Admin Order Detail Route
         Route::get('/admin/view-order/{id}','ProductsController@viewOrderDetails');

         //Update Order Status
          Route::match(['get','post'],'/admin/update-order-status','ProductsController@updateOrderStatus');


});

Route::get('/logout','AdminController@logout'); 
