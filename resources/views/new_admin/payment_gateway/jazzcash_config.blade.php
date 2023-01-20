@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit JazzCash Payment</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="#" >JazzCash Payment</a></li>
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
                    <h3 class="card-title">Edit JazzCash Payment </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.jazz_gateway.store')}}"  method="post">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 p-4">

                    <div class="form-group">
                        <label>Merchant ID#</label>
                        <input type="text" class="form-control" @isset($detail[0]->merchant_id)
                        value="{{$detail[0]->merchant_id}}"
                        @endisset required name="merchant_id" placeholder="Enter Name">
                      </div>
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" @isset($detail[0]->password)
                        value="{{$detail[0]->password}}"
                        @endisset required name="password" placeholder="Enter Password">
                      </div>
                      <div class="form-group">
                        <label>Integrity Salt</label>
                        <input type="text" class="form-control" required @isset($detail[0]->hash)
                        value="{{$detail[0]->hash}}"
                        @endisset name="hash" placeholder="Enter Hash">
                      </div>
                      <div class="col-md-6 pl-0">
                        @if (isset($detail[0]))
                        <button class="btn btn-primary" type="submit">Update</button>
                            @else
                            <button class="btn btn-primary" type="submit">Submit</button>
                        @endif
                    </div>
                        </div>

                    </div>

                    <!-- /.card-body -->


                  </form>
                </div>
                <!-- /.card -->



              </div>

      </div>
    </div>
  </section>
@endsection
