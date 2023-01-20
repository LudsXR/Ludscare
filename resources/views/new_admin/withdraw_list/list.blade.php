@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">WithDraw Request</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> WithDraw Request</li>
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
                  <h3 class="card-title">WithDraw Request</h3>
                  {{-- <a href="{{route('admin.role.add')}}" class="card-title">Add Role</a> --}}

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th>Created At</th>
                        <th scope="col">Consultant</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($withRrawRequests as $withRrawRequest)
                        <tr>
                            <td>{{$count}}</td>
                            <td>{{date('Y-M-d',strtotime($withRrawRequest->created_at))}}</td>

                            @isset($withRrawRequest->user->first_name )
                                <td>{{$withRrawRequest->user->first_name }} {{$withRrawRequest->user->last_name }} </td>
                            @endisset

                                <td>{{$withRrawRequest->amount}}</td>

                            {{-- @isset($mentee->user->phone) --}}
                                <td>{{$withRrawRequest->status?"Paid":'Pending'}}</td>
                            {{-- @endisset --}}
                            <td>
                                @php
                                    if($withRrawRequest->status){
                                        echo "<b>Already Paid</b>";
                                    }else {
                                         echo "<a href='".route('admin.paid-withdraw', $withRrawRequest->id)."'>Pay it</a>";
                                    }
                                @endphp

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

@endsection
