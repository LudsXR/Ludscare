@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Appointment Log List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Appointment Log List</li>
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
                  <h3 class="card-title">Appointment Log List</h3>
                  {{-- <a href="{{route('admin.role.add')}}" class="card-title">Add Role</a> --}}

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">ID</th>

                        <th scope="col">User</th>
                        <th scope="col">Consultant</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Payment Status</th>

                        <th scope="col">Type</th>
                        <th scope="col">Question</th>
                        <th scope="col">Appointment Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                                $count = 1;
                            @endphp
                            @foreach ($appointments as $appointment )
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$appointment->id}}</td>

                                <td>{{!is_null($appointment->mentee->phone)?$appointment->mentee->phone:''}}</td>
                                <td>{{!is_null($appointment->mentor->first_name . " " . $appointment->mentor->last_name)?$appointment->mentor->first_name . " " . $appointment->mentor->last_name:''}}</td>
                                <td>{{$appointment->date}}</td>
                                <td class="text-uppercase">{{$appointment->time}}</td>
                                <td>{{$appointment->payment}}</td>
                                <td>{{$appointment->is_paid?'Paid':'Unpaid'}}</td>

                                <td>{{$appointment->appointment_type_string}}</td>
                                <td>{{$appointment->questions}}</td>
                                <td>
                                    @if($appointment->appointment_status==0)
                                    Pending
                                    @elseif ($appointment->appointment_status==1)
                                    Accepted
                                    @elseif ($appointment->appointment_status==2)
                                    Completed
                                    @else
                                    Cancelled
                                    @endif

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

    $('#admin_users').DataTable(
        {
            "responsive": true, "lengthChange": false, "autoWidth": false,
            dom: 'Bfrtip',
            lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            {
                extend: 'copyHtml5',
                title: 'Appointment Log',
                 exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'excelHtml5',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'csvHtml5',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'pdfHtml5',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'print',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            'pageLength'
        ],
        select: true
        }
    ).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
@endsection
