@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">Add Category</a> </div>
    <h1>Categories</h1>
  </div>


  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
     
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Categories</h5>
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
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Category Description</th>
                  <th>Category URL</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $d)
                <tr class="gradeX">
                  <td>{{$d->name}}</td>
                  <td>{{$d->description}}</td>
                  <td>{{$d->url}}</td>
                  <td class="center"><a href="edit-category/{{$d->id}}" class="btn btn-primary btn-mini">Edit</a> <a href="delete-category/{{$d->id}}" id="delCat" class="btn btn-danger btn-mini">Delete</a></td>
                </tr>
               @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection