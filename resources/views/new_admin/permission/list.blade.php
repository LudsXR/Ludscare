@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Permission List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Permission List </li>
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
                <div class="card-header-admin d-flex justify-content-between">
                  <h3 class="card-title">Permission List</h3>
                  <a href="{{route('admin.permission.add')}}" class="card-title">+ Add Permission </a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                                $count = 1;
                            @endphp
                            @foreach ($permissions as $permission)
                                <tr>
                                    <th>{{$count}}</th>
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->slug}}</td>

                                    <td>
                                        <a href="{{ route('admin.permission.edit', $permission->id) }}"><i class="fas fa-edit"></i></a>
                                        <a href="{{route('admin.permission.delete',['id'=>$permission->id])}}"><i class="fas fa-trash text-danger ml-2"></i></a>
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
