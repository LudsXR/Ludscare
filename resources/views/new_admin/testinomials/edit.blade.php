@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Testimonial</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="{{route('admin.testinomials.list')}}">Testimonials List</a></li>
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
                    <h3 class="card-title">Edit Testimonial</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.testinomials.update')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$testinomial->id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control"  name="name" value="{{$testinomial->name}}" placeholder="Enter Name">
                          </div>
                          <div class="form-group">
                            <label>Feature</label>
                            <select class="form-control"  name="is_featured">
                                <option {{$testinomial->is_featured==0?"selected":''}}  value="0">No</option>
                                <option {{$testinomial->is_featured==1?"selected":''}}  value="1">Yes</option>
                            </select>
                        </div>
                          <div class="form-group">
                            <label>Image</label> <br>
                            @if (isset($testinomial->image_path))
                                <img src="{{asset($testinomial->image_path)}}" height="50" width="200" alt=""><br><br>
                            @endif
                            <input type="file"  onchange="openFile(this)" class="form-control h-100" name="image" placeholder="Testimonial Image">
                          </div>

                          <div class="image_preview">

                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control rounded-0" name="description" placeholder="Enter Description" rows="10">{{$testinomial->description}}</textarea>
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
