@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Products Images</a> </div>
    <h1>Add Product Images</h1>
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


  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>  
            <h5>Add Product Images</h5>
          </div>


            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{url('/admin/add-images/'.$productDetails->id)}}" name="add_images" id="add_images" novalidate="novalidate">

              {{csrf_field()}}

 
              <input type="hidden" name="product_id" value="{{$productDetails->id}}">

              <div class="control-group">
                <label class="control-label">Product Name</label>
                 <label class="control-label"><strong>{{$productDetails->product_name}}</strong></label>
                
              </div>

                    <div class="control-group">
                <label class="control-label">Product Code</label>
                 <label class="control-label"><strong>{{$productDetails->product_code}}</strong></label>
                
              </div>


                            <div class="control-group">
                <label class="control-label">Product Image</label>
                 <div class="controls">
                   <input type="file" name="image" id="image" multiple="multiple">
                 </div>
                
              </div>
              


                <input type="submit" style="margin-top: 20px;" value="Add Images" class="btn btn-success">
              </div>
                 
            </form>
        </div>
      </div>
    




 <div class="row-fluid">
      <div class="span12">
     
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Images</h5>
          </div>

   
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Image Id</th>
                  <th>Product Id</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
               @foreach($productsImages as $image)
               <tr>
                 <td>{{$image->id}}</td>
                 <td>{{$image->product_id}}</td>
                 <td><img src="{{asset('images/backend_images/products/small/'.$image->image)}}" style="width: 100px;height: 100px;"></td>
                 <td> <a href="{{url('/admin/delete-images/'.$image->id)}}" id="delCat" class="btn btn-danger btn-mini">Delete</a></td>
               </tr>
               @endforeach
              <tbody>
              
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   </div>
  </div>
</div>

@endsection