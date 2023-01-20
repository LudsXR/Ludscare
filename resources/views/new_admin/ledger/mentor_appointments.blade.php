@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Consultant Appointments Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Consultant Appointments Details</li>
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
                  <h3 class="card-title">Consultant Appointments Details</h3>


                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Appointment With</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Appointnment Status</th>

                            <th scope="col">Payment</th>
                            <th scope="col">Appointnment Type</th>
                            <th scope="col">Question</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($appointments as $appointment)
                                <tr>
                                    <th>{{$count}}</th>
                                    @if(isset($appointment->mentor->first_name ))
                                        <td>{{$appointment->mentor->first_name . ' ' . $appointment->mentor->last_name }}</td>
                                        @else
                                       {{-- <td> {{isset($appointment->mentor)?$appointment->mentor->phone:''}}</td> --}}
                                       <td>N/A</td>
                                    @endif

                                    @if(isset($appointment->mentee->first_name ))
                                        <td>{{$appointment->mentee->first_name . ' ' . $appointment->mentee->last_name }}</td>
                                        @else
                                       {{-- <td> {{$appointment->mentee->phone}}</td> --}}
                                       <td>N/A</td>
                                    @endif
                                    <td>{{$appointment->date}}</td>
                                    <td class="text-uppercase">{{$appointment->time}}</td>
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

                                    <td>
                                       {{$appointment->payment}}
                                    </td>
                                    <td>
                                        {{$appointment->appointment_type_string}}
                                     </td>
                                     <td>
                                        {{$appointment->questions}}
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
                title: 'Appointment Ledger',
                 exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'excelHtml5',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'csvHtml5',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'pdfHtml5',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'print',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
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
