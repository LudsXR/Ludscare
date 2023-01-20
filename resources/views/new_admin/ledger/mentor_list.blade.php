@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Consultant Appointment List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Consultant Appointment List</li>
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
                  <h3 class="card-title">Consultant Appointment List</h3>
                  {{-- <a href="{{route('admin.blog.category.add')}}" class="card-title">Add Blog Category</a> --}}

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Total Appointments Payment</th>
                            <th scope="col">View Details</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                                $count = 1;
                            @endphp
                            @foreach ($mentors as $mentor)
                                <tr>
                                    <th>{{$count}}</th>
                                    @if(isset($mentor->user->first_name ))
                                        <td>{{$mentor->user->first_name . ' ' . $mentor->user->last_name }}</td>
                                        @else
                                        @if (isset($mentor->user->phone ))
                                        <td> {{$mentor->user->phone}}</td>
                                            @else
                                            N/A
                                        @endif
                                    @endif
                                    <td>
                                       {{$mentor->total_payment}}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.mentor-appointments', $mentor->user_id) }}" target="_blank"><i class="mdi mdi-table-edit"></i>View Appointments</a>
                                        {{-- <a onclick="deleteRow('{{route('admin.mentor.delete',['id'=>$mentee->user_id])}}')"><i class="me-2 mdi mdi-delete"></i></a> --}}
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
