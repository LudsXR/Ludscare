@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Payment Method Settings</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="{{route('admin.payment_settings.list')}}">Payment Method Settings List</a></li>
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
                    <h3 class="card-title">Edit Payment Method Settings</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.payment_settings.update')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$payment_setting->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Payment Method</label>

                                    <select name="payment_method_id" class="form-control">
                                        <option value="">Select Payment Method</option>
                                        @foreach ($payment_methods as $payment_method)
                                            <option {{$payment_method->id==$payment_setting->payment_method_id?'selected':''}} value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" class="form-control" name="name"  placeholder="Enter Field Name"> --}}
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Field Name</label>
                                    <input type="text" class="form-control" required name="name"  value="{{$payment_setting->name}}" placeholder="Enter  Field Name">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Field Value</label>
                                    <input type="text" class="form-control" required name="value" value="{{$payment_setting->value}}" placeholder="Enter Field Value">
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
