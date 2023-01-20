@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Post</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="{{route('admin.blog.category.list')}}">Posts List</a></li>
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
                    <h3 class="card-title">Edit Post</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.blog.update')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$detail->id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control"  name="title" value="{{$detail->title}}" placeholder="Enter  Name">
                          </div>
                          <div class="form-group">
                            <label>Featured</label>
                            <select class="form-control"  name="featured" id="">
                                <option {{$detail->featured==0?"selected":''}}  value="0">No</option>
                                <option {{$detail->featured==1?"selected":''}}  value="1">Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label>Approved</label>
                          <select class="form-control"  name="is_approved" id="">
                              <option {{$detail->is_approved==0?"selected":''}}  value="0">No</option>
                              <option {{$detail->is_approved==1?"selected":''}}  value="1">Yes</option>
                          </select>
                      </div>
                          <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="category_id" required name="category_id" >
                                <option selected value="">Select Category</option>
                                @foreach($categories as $category)
                                <option @if ($category->id == $detail->category_id)
                                    selected
                                @endif value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Category Image</label> <br>
                            @if ($detail->image_path)
                                <img src="{{asset($detail->image_path)}}" height="50" width="200" alt=""><br><br>
                            @endif
                            <input type="file"  onchange="openFile(this)" onchange="openFile(this)"  class="form-control h-100" name="image" placeholder="International Phone Number">
                          </div>

                          <div class="image_preview">

                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control rounded-0 ckeditor"  id="" name="description" placeholder="Enter Description" rows="10">{{$detail->description}}</textarea>
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
