@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Contact Us List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Contact Us List</li>
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
                  <h3 class="card-title">Contact Us List</h3>
                  {{-- <a href="{{route('admin.role.add')}}" class="card-title">Add Role</a> --}}

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                    </tr>
                    </thead>
                    <tbody class="text-break">
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($contactuslist as $contactus)
                        <tr>
                            <td>{{$count}}</td>
                            {{-- @isset($mentee->user->first_name ) --}}
                                <td>{{!empty($contactus->name)?$contactus->name:'' }}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->email) --}}
                                <td class="text-lowercase">{{!empty($contactus->email)?$contactus->email:''}}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->phone) --}}
                                <td>{{!empty($contactus->message)?$contactus->subject:''}}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->image_path) --}}

                                <td>{{!empty($contactus->subject)?$contactus->message:''}}</td>

                            {{-- @endisset --}}

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
                title: 'Contact Us',
                 exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'excelHtml5',
                title: 'Contact Us',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'csvHtml5',
                title: 'Contact Us',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'pdfHtml5',
                title: 'Contact Us',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'print',
                title: 'Contact Us',
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
