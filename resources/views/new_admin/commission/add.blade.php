@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add Commission</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Commission </li>
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
                    <h3 class="card-title">Commission</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.commission.store')}}"  method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$commission->id}}" />
                    <div class="card-body">
                        <div class="form-group">
                            <label class="d-flex">

                                <input
                                @isset($commission)
                                {{$commission->fixed==1?'Checked':''}}
                                @endisset

                                type="radio" class=" form-check mr-2" value="1" required name="fix" >
                                Fix

                            </label>
                            <label class="d-flex">
                                <input
                                @isset($commission)
                                {{$commission->fixed==0?'Checked':''}}
                                @endisset
                                type="radio" class="form-check mr-2" value="0" required name="fix" >
                                Percentage

                            </label>


                        </div>
                          <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control"  required name="amount"
                            @isset($commission)
                            value="{{$commission->amount}}"
                            @endisset
                            placeholder="Enter Amount">
                          </div>

                    <!-- /.card-body -->

                    <div class="col-md-6 pl-0">
                        <button class="btn btn-primary" type="submit">

                            @if ($commission)
                            Update
                            @else
                            Submit
                            @endif
                        </button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->



              </div>

      </div>
    </div>
  </section>
@endsection
