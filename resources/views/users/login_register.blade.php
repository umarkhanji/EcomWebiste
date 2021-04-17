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
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="{{url('/user-login')}}" id="loginForm" method="post" name="loginForm">{{csrf_field()}}
							<input type="email" name="email" placeholder="Email" />
							<input type="password" name="password" placeholder="Password" />
<!-- 							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span> -->
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form id="registerForm" name="registerForm" action="{{url('/user-register')}}"  method="post" > {{csrf_field()}}
							<input id="name" type="text" name="name" placeholder="Name"/>
							<input id="email" type="text" name="email" placeholder="Email Address"/>
							<input id="password" type="password" name="password" placeholder="Password"/>
						     <input type="submit" name="" value="Signup">
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->



@endsection