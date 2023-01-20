@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit {{$paymentMethod->name}} Payment Method</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"  style="color: #6c757d">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('admin.mentee.list')}}"> Payment Method</a></li>
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
                    <h3 class="card-title">Edit {{$paymentMethod->name}} Payment Method</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.payment_gateway.update')}}" enctype="multipart/form-data"   method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$paymentMethod->id}}">
                    <div class="card-body">
                        <div class="row">
                              @foreach ($paymentMethod->settings as $setting)
                              @if($setting->name != 'mode')
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>{{$setting->display_name}}</label>
                                  <input type="text" class="form-control" required name="{{$setting->name}}" value="{{$setting->value}}"  placeholder="{{$setting->display_name}}">
                                </div>
                              </div>
                              @endif
                              @endforeach
                              @if(isset($paymentMethod->image_path))
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Icon Image</label> <br>
                                  <img src="{{asset($paymentMethod->image_path)}}" height="200" width="200" alt=""><br><br>
                                  <input type="file"  onchange="openFile(this)" class="form-control h-100" name="image_path">
                                </div>
                                <div class="image_preview" height="200" width="200">
                                </div>
                              </div>
                                @endif
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
