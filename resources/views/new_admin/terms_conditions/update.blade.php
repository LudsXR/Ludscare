@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Terms and Conditions</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> <a href='#'>Terms and Conditions </a></li>
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
                    <h3 class="card-title">Terms and Conditions</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.terms_conditions.update')}}" enctype="multipart/form-data"  method="post">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                          <label>Terms and Conditions</label>
                          <textarea id="areaEditor" class="form-control" required name="value"
                          placeholder="Terms and Conditions">{{$terms_conditions->value}}</textarea>
                        </div>

                          <!-- <div class="image_preview">

                          </div>
                         @if(isset($general->logo))
                         <img src="{{asset($general->logo)}}" width="150px" />
                         @endif -->

                    <!-- /.card-body -->

                    <div class="col-md-6 pl-0 pt-3">
                        <button class="btn btn-primary" type="submit">
                            Update
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

@section('footer_script')
<script>
    $(document).ready(function() {
      CKEDITOR.replace('areaEditor');
    });
</script>
@endsection
