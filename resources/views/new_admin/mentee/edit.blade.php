@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('admin.mentee.list')}}"> User List</a></li>
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
                    <h3 class="card-title">Edit User</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.mentee.update')}}" enctype="multipart/form-data"   method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$detail->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>First Name</label>
                                  <input type="text" class="form-control" required name="first_name"  value="{{$detail->user->first_name}}" placeholder="Enter First Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Last Name</label>
                                  <input type="text" class="form-control" required name="last_name" value="{{$detail->user->last_name}}" placeholder="Enter Last Name">
                                </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="email" class="form-control" required name="email"  value="{{$detail->user->email}}" placeholder="Enter Email">
                                </div>
                              </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Phone</label>
                                  <input type="text" class="form-control" required name="phone" value="{{$detail->user->phone}}" placeholder="Enter Phone">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country" id="">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option @if ($country->id == $detail->user->country) selected @endif
                                                value="{{ $country->id }}"> {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>City</label>
                                  <input type="text" class="form-control" required name="city" value="{{$detail->user->city}}" placeholder="Enter City">
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" class="form-control" required name="address"  value="{{$detail->user->address}}" placeholder="Enter Address">
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Postal Code</label>
                                  <input type="number" class="form-control" required name="postal_code" value="{{$detail->user->postal_code}}" placeholder="Enter Postal Code">
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Profile Image</label> <br>
                                  @if ($detail->user->image_path)
                                      <img src="{{asset($detail->user->image_path)}}" height="200" width="200" alt=""><br><br>
                                  @endif
                                  <input type="file"  onchange="openFile(this)" class="form-control h-100" name="image">
                                </div>

                                <div class="image_preview">

                                </div>
                            </div>
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
