@extends('layouts.adminLayout.admin_design')
@section('content')


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banner</a> <a href="#" class="current">Edit Banner</a> </div>
    <h1>Edit Banner</h1>
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
            <h5>Edit Banner</h5>
          </div>


            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{url('/admin/edit-banner/'.$bannerDetails->id)}}" name="edit_banner" id="edit_banner" novalidate="novalidate">

              {{csrf_field()}}


             <div class="control-group">
               <label class="control-label">Banner Image</label>
                <div class="controls">
                  <input type="file" name="image" id="image">
                  <input type="hidden" name="current_image" value="{{$bannerDetails->image}}">
                  <img src="{{asset('/images/frontend_images/banners/'.$bannerDetails->image)}}" style="width: 40px;">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                  <input type="text" name="title" id="title" value="{{$bannerDetails->title}}">
                </div>
              </div>


              <div class="control-group">
                <label class="control-label">Link</label>
                <div class="controls">
                  <input type="text" name="link" id="link" value="{{$bannerDetails->link}}">
                </div>
              </div>



             <div class="control-group">
               <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($bannerDetails->status=="1")checked @endif>
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Edit Banner" class="btn btn-success">
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection