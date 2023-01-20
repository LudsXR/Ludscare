@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> User List</li>
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
                <div class="card-header-admin d-flex justify-content-between align-items-center">
                  <h3 class="card-title">User</h3>
                  <a href="{{route('admin.mentee.add')}}" class="card-title">+ Add User</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($mentees as $mentee)
                        <tr>
                            <th>{{$count}}</th>
                            {{-- @isset($mentee->user->first_name ) --}}
                                <td>{{!empty($mentee->user->first_name)?$mentee->user->first_name . ' ' . $mentee->user->last_name:'' }}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->email) --}}
                                <td class="text-lowercase">{{!empty($mentee->user->email)?$mentee->user->email:''}}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->phone) --}}
                                <td>{{!empty($mentee->user->phone)?$mentee->user->phone:''}}</td>
                            {{-- @endisset --}}
                            {{-- @isset($mentee->user->image_path) --}}
                                <td>
                                    @if (isset($mentee->user->image_path) && !empty($mentee->user->image_path))
                                    <div class="img-wrap">
                                        <img src="{{asset($mentee->user->image_path)}}" alt="">
                                    </div>

                                    @else
                                        N/A
                                    @endif
                                </td>
                            {{-- @endisset --}}
                            <td>
                                <a href="{{ route('admin.mentee.detail', $mentee->id) }}"><i class="fas fa-edit"></i></a>
                                <a href="{{route('admin.mentee.delete',['id'=>$mentee->id])}}"><i class="ml-2 fas fa-trash text-danger"></i></a>
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
