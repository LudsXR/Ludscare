@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Payment Method</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="{{route('admin.payment_gateway.list')}}">Payment Method List</a></li>
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
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Payment Method</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.payment_gateway.update')}} enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$paymentMethod->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" class="form-control" required name="name"  value="{{$paymentMethod->name}}" placeholder="Enter  Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Code</label>
                                  <input type="text" class="form-control" required name="code" value="{{$paymentMethod->code}}" placeholder="Enter Code">
                                </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Description</label>
                                  <input type="text" class="form-control" required name="description"  value="{{$paymentMethod->description}}" placeholder="Enter Description">
                                </div>
                              </div>

                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Logo</label> <br>
                                  @if ($paymentMethod->image_id)
                                      <img src="{{asset($paymentMethod->image_id)}}" height="200" width="200" alt=""><br><br>
                                  @endif
                                  <input type="file"  onchange="openFile(this)" class="form-control " name="image">
                                </div>
                                <div class="image_preview">

                                </div>
                            </div>
                        </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
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
