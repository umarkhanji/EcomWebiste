@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Product</a> </div>
    <h1>Products</h1>
  </div>
          
       @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dissmiss="alert"></button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
        @endif     


         @if(Session::has('flash_message_success'))
        <div class="alert alert-success  alert-block">
            <button type="button" class="close" data-dissmiss="alert"></button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
        @endif  

  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
     
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Categories</h5>
          </div>

   
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product Id</th>
                  <th>Category Id</th>
                  <th>Category Name</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Product Price</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $p)
                <tr class="gradeX">
                  <td>{{$p->id}}</td>
                  <td>{{$p->category_id}}</td>
                  <td>{{$p->category_name}}</td>
                  <td>{{$p->product_name}}</td>
                  <td>{{$p->product_code}}</td>
                  <td>{{$p->product_color}}</td>
                  <td>{{$p->price}}</td>
                   <td>
                    @if(!empty($p->image))
                    <img src="{{asset('images/backend_images/products/small/'.$p->image)}}" style="width: 50px;">
                  @endif</td>
                  <td class="center">
                    <a href="#myModal{{$p->id}}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                    <a href="edit-product/{{$p->id}}" class="btn btn-primary btn-mini">Edit</a> 
                    <a href="{{'/admin/add-attributes/'.$p->id}}" data-toggle="modal" class="btn btn-success btn-mini">Add</a>
                     <a href="{{'/admin/add-images/'.$p->id}}" title="Add Images" data-toggle="modal" class="btn btn-info btn-mini">Add</a>
                    <a href="delete-product/{{$p->id}}" id="delCat" class="btn btn-danger btn-mini">Delete</a></td>
                </tr>



          
            <div id="myModal{{$p->id}}" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>{{$p->product_name}} Full Details</h3>
              </div>
              <div class="modal-body">
                <p>Product Id {{$p->id}}</p>
                <p>Product Category {{$p->category_id}}</p>
                <p>Product Code {{$p->product_code}}</p>
                <p>Product Color {{$p->product_color}}</p>
                <p>Product Price {{$p->price}}</p>
            
              </div>
            </div>
         
               @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>





@endsection