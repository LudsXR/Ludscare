@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Consultant Category</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('admin.mentor.category.list')}}"> Mentor Category List</a></li>
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
                    <h3 class="card-title">Edit Consultant Category</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.mentor.category.update')}}" enctype="multipart/form-data"   method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label>Parent Category</label>
                            <select class="form-control parent_category" name="parent_id" >
                                <option class="form-control" value="0">Select Parent Category</option>
                                    @foreach ($parent_category as $category)
                                        <option {{$detail->parent_id==$category->id?"selected":""}} value="{{$category->id}}">{{$category->name}}</option>

                                        @foreach($category->subCategories as $option)
                                            <option {{$detail->parent_id==$option->id?"selected":""}} value="{{$option->id}}">--{{$option->name}}</option>
                                            @foreach($option->subCategories as $option_sub)

                                                @if (count($option_sub->subCategories)>0)
                                                    @foreach($option->subCategories as $option_sub)
                                                    <option {{$detail->parent_id==$option_sub->id?"selected":""}} value="{{$option_sub->id}}">------{{$option_sub->name}}</option>
                                                    @endforeach
                                                @else
                                                <option value="{{$option_sub->id}}">----{{$option_sub->name}}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                            </select>
                          </div>
                          <input type="hidden" name="id" value="{{$detail->id}}">
                          <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" required name="name" value="{{$detail->name}}" placeholder="Enter Category Name">
                          </div>
                          <div class="form-group">
                            <label>Category Image</label> <br>
                            @if ($detail->image_path)
                                <img src="{{asset($detail->image_path)}}" height="200" width="200" alt=""><br><br>
                            @endif
                            <input type="file"  onchange="openFile(this)" class="form-control h-100" name="image" placeholder="International Phone Number">
                          </div>
                          <div class="image_preview">

                        </div>
                          <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control rounded-0" id="" name="description" placeholder="Enter Category Description" rows="10">{{$detail->description}}</textarea>
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
@section('footer_script')
        <script>
            $(document).ready(function() {
                $(".parent_category").select2();
            });
        </script>
@endsection
<style>
    .select2-selection{
        height: 38px !important;
    }
    .select2-selection__arrow{
        height: 100% !important;
    }
</style>
