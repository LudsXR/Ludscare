@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add General Settings</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Add General Settings </li>
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
                    <h3 class="card-title">Add General Settings</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.general.store')}}" enctype="multipart/form-data"  method="post">
                    @csrf
                    @if ($general)
                    <input type="hidden" value="{{$general->id}}" name="id" />
                    @endif
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control"  required name="title"

                            value="{{isset($general->title)?$general->title:''}}"
                            placeholder="Enter Title">
                          </div>
                          <div class="form-group">
                            <label>TagLine</label>
                            <input type="text" class="form-control"  required name="tagline"

                            value="{{isset($general->tagline)?$general->tagline:''}}"
                            placeholder="Enter Tagline">
                          </div>
                          <div class="form-group">
                            <label>Seo Description</label>
                            <input type="text" class="form-control"  required name="seo_Des"

                            value="{{isset($general->seo_Des)?$general->seo_Des:''}}"
                            placeholder="Enter Seo Description">
                          </div>
                          <div class="form-group">
                            <label>Seo KeyWords</label>
                            <input type="text" class="form-control"  required name="seo_keywords"

                            value="{{isset($general->seo_keywords)?$general->seo_keywords:''}}"
                            placeholder="Enter Seo KeyWords">
                          </div>
                          <div class="form-group">
                            <label>Facebook Link</label>
                            <input type="text" class="form-control"  required name="facebook_link"

                            value="{{isset($general->facebook_link)?$general->facebook_link:''}}"
                            placeholder="Enter Facebook Link">
                          </div>
                          <div class="form-group">
                            <label>Twitter Link</label>
                            <input type="text" class="form-control"  required name="twitter_link"

                            value="{{isset($general->twitter_link)?$general->twitter_link:''}}"
                            placeholder="Enter Twitter Link">
                          </div>
                          <div class="form-group">
                            <label>LinkedIn Link</label>
                            <input type="text" class="form-control"  required name="linkden_link"

                            value="{{isset($general->linkden_link)?$general->linkden_link:''}}"
                            placeholder="Enter LinkDen Link">
                          </div>
                          <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control"  required name="address"

                            value="{{isset($general->address)?$general->address:''}}"
                            placeholder="Enter Address">
                          </div>
                          @if(isset($general->longitude))
                          <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" class="form-control"  required name="longitude"
                            value="{{isset($general->longitude)?$general->longitude:''}}"
                            placeholder="Enter Longitude">
                          </div>
                          @endif
                          @if(isset($general->latitude))
                          <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" class="form-control"  required name="latitude"
                            value="{{isset($general->latitude)?$general->latitude:''}}"
                            placeholder="Enter Latitude">
                          </div>
                          @endif
                          <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control"  required name="phone"

                            value="{{isset($general->phone)?$general->phone:''}}"
                            placeholder="Enter Phone">
                          </div>
                          <div class="form-group">
                            <label>Company Email</label>
                            <input type="text" class="form-control"  required name="company_email"

                            value="{{isset($general->company_email)?$general->company_email:''}}"
                            placeholder="Enter Company Email">
                          </div>
                          <div class="form-group">
                            <label>About Company</label>
                            <input type="text" class="form-control"  required name="about_company"

                            value="{{isset($general->about_company)?$general->about_company:''}}"
                            placeholder="Enter About Company">
                          </div>
                          <div class="form-group">
                            <label>Select Currency Symbol</label>
                            <!-- <input type="text" class="form-control"  required name="currency_symbol"
                            value="{{isset($general->currency_symbol)?$general->currency_symbol:''}}"
                            placeholder="Select Currency Symbol"> -->
                            <select class="form-control curr-sym" name="currency_symbol" id="idselector">
                               @foreach($currency_codes as $currency_code)
                               <option {{  ($currency_code->symbol == $general->currency_symbol ? 'selected' : '') }} value="{{$currency_code->symbol}}">{{$currency_code->symbol}}</option>
                               @endforeach
                            </select>
                          </div>
                          @if(isset($general->login_type))
                          <div class="form-group">
                            <label>Select Login Type</label>
                            <select class="form-control " name="login_type">
                               <option {{  ($general->login_type == 'phone' ? 'selected' : '') }} value="phone">Phone</option>
                                <option {{  ($general->login_type == 'email' ? 'selected' : '') }} value="email">Email</option>
                            </select>
                          </div>
                          @endif
                          <div class="form-group">
                            <label>Site Logo</label>
                            <input type="file" accept="image/*"  onchange="openFile(this)" onchange="openFile(this)" class="form-control h-100"   name="logo">
                          </div>
                          <div class="image_preview">

                          </div>
                         @if(isset($general->logo))
                         <img src="{{asset($general->logo)}}" width="150px" />
                         @endif

                    <!-- /.card-body -->

                    <div class="col-md-6 pl-0 pt-3">
                        <button class="btn btn-primary" type="submit">

                            @if ($general)
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

@section('footer_script')

  <script>
  $(function(){
$("#idselector").select2();
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
