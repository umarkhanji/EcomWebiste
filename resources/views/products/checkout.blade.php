@extends('layouts.frontLayout.front_design')
@section('content')


	<section id="form" style="margin-top: 20px;"><!--form-->
		         @if(Session::has('flash_message_success'))
        <div class="alert alert-success  alert-block">
            <button type="button" class="close" data-dissmiss="alert"></button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
        @endif  
        
        @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block" style="background-color: #f2dfd0;">
            <button type="button" class="close" data-dissmiss="alert"></button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
        @endif
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Check Out</li>
				</ol>
			</div>
			<form action="{{url('/checkout')}}" method="post" >{{csrf_field()}}
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Bill To</h2>
						    <div class="form-group">
							<input type="text" name="billing_name" id="billing_name" value="{{$userDetails->name}}" placeholder="Billing Name" class="form-control" />
							</div>
							 <div class="form-group">
							<input type="text" name="billing_address" id="billing_address" value="{{$userDetails->address}}" placeholder="Billing Address" class="form-control"/>
							</div>
							 <div class="form-group">
							<input type="text" name="billing_city" id="billing_city" value="{{$userDetails->city}}" placeholder="Billing City" class="form-control"/>
							</div>
							 <div class="form-group">
							<input type="text" name="billing_state" id="billing_state" value="{{$userDetails->state}}" placeholder="Billing State" class="form-control"/>
							</div>
							 <div class="form-group">
								<select id="billing_country" name="billing_country" class="form-control">
									<option>Select Country</option>
									@foreach($countries as $country)
									<option value="{{$country->country_name}}"
									  @if($country->country_name == $userDetails ->country)selected @endif>{{$country->country_name}}</option>
									@endforeach
								</select>
							</div>
							 <div class="form-group">
							<input type="text" name="billing_pincode" id="billing_pincode" value="{{$userDetails->pincode}}" placeholder="Billing PinCode" class="form-control"/>
							</div>
							 <div class="form-group">
							<input type="text" name="billing_mobile" id="billing_mobile" value="{{$userDetails->mobile}}" placeholder="Billing Mobile" class="form-control"/>
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" name="" id="billtoship">
								<label class="form-check-label" for="billtoship">Shipping Same As Billing Address</label>
							</div>

					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 ></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Shipp  To</h2>
						 <div class="form-group">
						    <input type="text" name="shipping_name" value="{{$shippingDetails->name}}" placeholder="Shipping Name" id="shipping_name"  class="form-control"/>
						</div>
						     <div class="form-group">
							<input type="text" name="shipping_address" value="{{$shippingDetails->address}}" placeholder="Shipping Address" id="shipping_address" class="form-control"/>
							</div>
							 <div class="form-group">
							<input type="text" name="shipping_city" value="{{$shippingDetails->city}}" placeholder="Shipping City" id="shipping_city" class="form-control"/>
							</div>
							 <div class="form-group">
							<input type="text" name="shipping_state" value="{{$shippingDetails->state}}" placeholder="Shipping State" id="shipping_state" class="form-control"/>
							</div>
							 <div class="form-group">
							<select id="shipping_country" name="shipping_country" class="form-control">
									<option>Select Country</option>
									@foreach($countries as $country)
									<option value="{{$country->country_name}}" @if($country->country_name == $shippingDetails ->country)selected @endif>{{$country->country_name}}</option>
									@endforeach
								</select>
							</div>
							 <div class="form-group">
							<input type="text" name="shipping_pincode" value="{{$shippingDetails->pincode}}" placeholder="Shipping PinCode" id="shipping_pincode" class="form-control"/>
							</div>
							 <div class="form-group">
							<input type="text" name="shipping_mobile" value="{{$shippingDetails->mobile}}" placeholder="Shipping Mobile" id="shipping_mobile" class="form-control"/>
						</div>
							<button type="submit" class="btn btn-success" >Checkout</button>
					</div><!--/sign up form-->
				</div>
			</div>
		</form>
		</div>
	</section><!--/form-->

@endsection