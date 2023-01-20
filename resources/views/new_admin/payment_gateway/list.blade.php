@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Payment Method List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Payment Method List</li>
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
                  <h3 class="card-title">Payment Method List</h3>
                  <a href="{{route('admin.payment_gateway.add')}}" class="card-title">Add Payment Method</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
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
                            {{-- @isset($mentee->user->first_name ) --}}
                                <td>

                                    {{$paymentMethod->name }}


                                </td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->email) --}}
                                <td>{{$paymentMethod->code}}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->phone) --}}
                                <td>{{$paymentMethod->description}}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->image_path) --}}
                                <td>
                                    @if (isset($paymentMethod->image_id) && !empty($paymentMethod->image_id))
                                    <img src="{{asset($paymentMethod->image_id)}}" height="50" width="50" alt="">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            {{-- @endisset --}}
                            <td>
                                <a href="{{ route('admin.payment_gateway.edit', $paymentMethod->id) }}"><i class="fas fa-edit"></i></a>
                                <a onclick="deleteRow('{{route('admin.payment_gateway.delete',['id'=>$paymentMethod->id])}}')"><i class="me-2 fas fa-trash"></i></a>
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
                        <th scope="col">Code</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
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
