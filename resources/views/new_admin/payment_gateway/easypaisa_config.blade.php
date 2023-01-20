@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Payment</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href="#" >EasyPaisa Payment</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

@if(session()->has('msg'))
{{session()->get('msg')}}
@endif
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Edit EasyPaisa Payment </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.easypaisa_payment_gateway.store')}}"  method="post">
                    @csrf


                    <div class="card-body">
                        <div class="form-group">
                            <label>Store ID#</label>
                            <input type="text" class="form-control" @isset($detail[0]->storeId)
                            value="{{$detail[0]->storeId}}"
                            @endisset required name="storeId" placeholder="Enter Store ID">
                          </div>
                          <div class="form-group">
                            <label>Hash</label>
                            <input type="text" class="form-control" @isset($detail[0]->hash)
                            value="{{$detail[0]->hash}}"
                            @endisset required name="hash" placeholder="Enter Hash">
                          </div>


                    <!-- /.card-body -->

                    <div class="col-md-6 pl-0">
                        @if (isset($detail[0]))
                        <button class="btn btn-primary" type="submit">Update</button>
                            @else
                            <button class="btn btn-primary" type="submit">Submit</button>
                        @endif
                    </div>
                  </form>
                </div>
                <!-- /.card -->



              </div>

      </div>
    </div>
  </section>
@endsection
