@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"> Add Consultant Experience</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            {{-- <li class="breadcrumb-item active"><a href="{{route('admin.role.list')}}"> Role List</a></li> --}}
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
        <div class="col-lg-12 mt-3">
          <div class="card">
              <div class="card-body">
                  <h2>Consultant Experience</h2>
                <div class="col-lg-12">
                    <form action="{{route('admin.mentor.save.experience')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Consultant</label>
                                  <select class="form-control mentor"  name="mentor_id" id="mentor_id" required>
                                    <option> Select Consultant</option>
                                    @foreach ($mentors as $mentor)

                                    <option value="{{$mentor->user_id}}"> {{!empty($mentor->user->first_name)?$mentor->user->first_name:""}} {{!empty($mentor->user->last_name)?$mentor->user->last_name:""}}</option>
                                    @endforeach
                                   </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company</label>
                                    <input required type="text" class="form-control" required name="company"  placeholder="Enter company">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>From</label>
                                    <input  type="date" class="form-control"  name="from"  placeholder="Enter from">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>To</label>
                                    <input  type="date" class="form-control"  name="to"  placeholder="Enter to">
                                  </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Experience Image</label>
                                    <input  type="file" class="form-control h-50"  name="image" >
                                  </div>
                              </div>
                              <div class="col-lg-6 d-flex justify-content-end align-items-end">
                              <button class="btn btn-primary mb-3" type="submit">Submit</button>
                              </div>
                        </div>
                    </form>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section('footer_script')
        <script>
            $(document).ready(function() {
                $(".mentor").select2();
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
