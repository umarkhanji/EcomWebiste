@extends('layouts.frontLayout.front_design')
@section('content')

	<section id="form" style="margin-top: 0px;"><!--form-->
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
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form">
						<h2>Update Account</h2>
						<form id="accountForm" name="accountForm" action="{{url('/account')}}"  method="post" > {{csrf_field()}}
							<input id="name" type="text" name="name" value="{{$userDetails->name}}" placeholder="Name"/>
							<input id="address" type="text" name="address" value="{{$userDetails->address}}" placeholder="Address"/>
							<input id="city" type="text" name="city" value="{{$userDetails->city}}" placeholder="City"/>
							<input id="state" type="text" name="state" value="{{$userDetails->state}}" placeholder="State"/>
							<select id="country" name="country">
								<option>Select Country</option>
									@foreach($countries as $country)
									<option value="{{$country->country_name}}"
									  @if($country->country_name == $userDetails ->country)selected @endif>{{$country->country_name}}</option>
									@endforeach
							</select>
							<input id="pincode" type="text" value="{{$userDetails->pincode}}" style="margin-top: 10px;" name="pincode" placeholder="Pin Code"/>
							<input id="mobile" type="text" value="{{$userDetails->mobile}}" name="mobile" placeholder="Mobile"/>
						     <input type="submit" name="" value="Update">
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Update Password</h2>
						<form id="passwordForm" name="passwordForm" action="{{url('update-user-pwd')}}" method="post">{{csrf_field()}}
					    <input type="Password" name="current_pwd" id="current_pwd" placeholder="Current Password">
					    <input type="Password" name="new_pwd" id="new_pwd" placeholder="New Password">
					    <input type="Password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">
					      <input type="submit" name="" class="btn btn-default" value="Update">
							


						</form>
					</div>
				</div>
			</div>
		</div>
	</section>



@endsection