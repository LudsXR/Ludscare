@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add Consultant Education</h1>
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
                  <h2>Consultant Education</h2>
                <div class="col-lg-12">
                    <form action="{{route('admin.mentor.add.education.save')}}" enctype="multipart/form-data" method="POST">
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
                                    <label>Institute</label>
                                    <input  type="text" class="form-control"  name="institute"  placeholder="Enter Institute">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Degree</label>
                                    <input  type="text" class="form-control" required name="degree"  placeholder="Enter degree">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input  type="text" class="form-control"  name="subject"  placeholder="Enter subject">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period</label>
                                    <input  type="text" class="form-control h-50"  name="period"  placeholder="Enter period">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Education Image</label>
                                    <input  type="file" class="form-control h-50"  name="image" >
                                  </div>
                              </div>
                              <div class="col-lg-6">
                              <button class="btn btn-primary" type="submit">Submit</button>
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
