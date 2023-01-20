@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add Post</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="{{route('admin.blog.list')}}">Posts List</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Create Post</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.blog.store')}}" enctype="multipart/form-data"  method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" required name="title" placeholder="Enter Name">
                          </div>
                          <div class="form-group">
                            <label>Feature</label>
                            <select class="form-control"  name="featured" id="">
                                <option  value="0">No</option>
                                <option  value="1">Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label>Approved</label>
                          <select class="form-control"  name="is_approved" id="">
                              <option  value="0">No</option>
                              <option  value="1">Yes</option>
                          </select>
                      </div>
                          <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="category_id" required name="category_id" >
                                <option selected value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Blog Image</label>
                            <input type="file"  onchange="openFile(this)" onchange="openFile(this)" class="form-control h-100" name="image" placeholder="International Phone Number">
                          </div>
                          <div class="image_preview">
                          </div>
                          <div class="form-group">
                            <label>Description</label>
                            <textarea  class="ckeditor form-control" name="description" required cols="30" rows="10"></textarea>
                          </div>

                    <!-- /.card-body -->

                    <div class="col-md-6 pl-0">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->



              </div>

      </div>
    </div>
  </section>
@endsection
