@extends('layouts.frontLayout.front_design')
@section('content')


	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Thanks</li>
				</ol>
			</div>

		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading" align="center">
				<h3>YOUR COD ORDER HAS BEEN PLACED</h3>
				<p>Your Order Number Is {{Session::get('order_id')}} And Total Paybal Amount Is INR {{Session::get('grand_total')}}</p>
				<p>Please make payment by clicking on below Payment Method</p>
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="mdumarkhan8579@gmail.com">
    <input type="hidden" name="item_name" value="{{Session::get('order_id')}}">
    <input type="hidden" name="amount" value="{{Session::get('grand_total')}}">
    <input type="hidden" name="currency_code" value="INR">
    <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png">
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
 ?>