@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Payment Methods</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Payment Methods</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <section class="content">
    @if( Session::has("success") )
    <div class="alert alert-success alert-block"  id="msg" role="alert">
        <button class="close" data-dismiss="alert"></button>
        {{ Session::get("success") }}
    </div>
    @endif
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header-admin d-flex justify-content-between align-items-center">
                  <h3 class="card-title">User</h3>
                  <a href="{{route('admin.mentee.add')}}" class="card-title">+ Add User</a>

                </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($paymentMethods as $paymentMethod)
                        <tr>
                            <th>{{$count}}</th>
                            {{-- @isset($paymentMethod->name ) --}}
                                <td>{{!empty($paymentMethod->name)?$paymentMethod->name:'' }}</td>
                            {{-- @endisset --}}
                            {{-- @isset($paymentMethod->image_path) --}}
                                <td>
                                    @if (isset($paymentMethod->image_path) && !empty($paymentMethod->image_path))
                                    <div class="img-wrapper">
                                        <img src="{{asset($paymentMethod->image_path)}}" alt="">
                                    </div>

                                    @else
                                        N/A
                                    @endif
                                </td>
                            {{-- @endisset --}}
                            <td class="d-md-flex justify-content-between">
                              <div class="">
                                <div class="form-check form-switch">
                                  <input {{  ($paymentMethod->is_active == 1 ? ' checked' : '') }} oninput="updateStatus('{{route('admin.payment_gateway.status',['payment_method'=>$paymentMethod->id])}}')" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                  <label class="form-check-label" for="flexSwitchCheckDefault">Enable/Disable</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input {{  ($paymentMethod->is_default == 1 ? ' checked' : '') }} oninput="updateDefaultStatus('{{route('admin.payment_gateway.setDefault',['payment_method'=>$paymentMethod->id])}}')" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Set Default</label>
                                  </div>
                              </div>
                              <div class="">
                                <a href="{{ route('admin.payment_gateway.edit', $paymentMethod->id) }}"><i class="fas fa-edit"></i></a>
                              </div>


                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('footer_script')
<script>
    $("#admin_users").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
<script>
    function updateStatus(url){
      var result = confirm("Are you sure you want to update it?");
      if (result==true) {
      window.location.href=url;
      } else {
      window.location.reload()
      }
        }
        function updateDefaultStatus(url){
          var result = confirm("Are you sure you want to update it?");
          if (result==true) {
          window.location.href=url;
          } else {
          window.location.reload()
          }
            }
</script>
@endsection
