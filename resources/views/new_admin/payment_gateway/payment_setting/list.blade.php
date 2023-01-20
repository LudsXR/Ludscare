@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Payment Method  Settings List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Payment Method  Settings List</li>
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
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Payment Method  Settings List</h3>
                  <a href="{{route('admin.payment_settings.add')}}" class="card-title">Add Payment Method  Settings</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Field Name</th>
                        <th scope="col">Field Value</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($payment_settings as $payment_setting)
                        <tr>
                            <th>{{$count}}</th>

                                <td>

                                    {{$payment_setting->payment_method->name }}


                                </td>

                                <td>{{$payment_setting->name}}</td>

                                <td>{{$payment_setting->value}}</td>

                            <td>
                                <a href="{{ route('admin.payment_settings.edit', $payment_setting->id) }}"><i class="fas fa-edit"></i></a>
                                <a onclick="deleteRow('{{route('admin.payment_gateway.delete',['id'=>$payment_setting->id])}}')"><i class="me-2 fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Field Name</th>
                        <th scope="col">Field Value</th>
                        <th scope="col">Action</th>
                    </tr>
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
    function deleteRow(url){
        var result = confirm("Are you sure you want to delete it?");
        if (result==true) {
        window.location.href=url;
        } else {
        return false;
        }
    }
</script>
@endsection
