@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Rejected Consultant List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Rejected Consultant List</li>
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
                  <h3 class="card-title">Rejected Consultant </h3>
                  {{-- <a href="{{route('admin.mentor.category.add')}}" class="card-title">Add Category</a> --}}

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            {{-- <th scope="col">Phone</th> --}}
                            <th scope="col">Designation</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                    @foreach ($rejected_mentors as $mentor)
                        <tr>
                            <th>{{$count}}</th>
                             @if(isset($mentor->user->first_name ))
                                <td>{{$mentor->user->first_name . ' ' . $mentor->user->last_name }}</td>
                                @else
                               <td> N/A</td>
                            @endif
                             @if(isset($mentor->user->email))
                                <td class="text-lowercase">{{$mentor->user->email}}</td>
                                @else
                               <td> N/A</td>
                            @endif

                             @if(isset($mentor->category->name))
                                <td>{{$mentor->category->name}}</td>
                                @else
                               <td> N/A</td>
                            @endif
                            @if(isset($mentor->user->image_path))
                                <td>
                                    @if ($mentor->user->image_path)
                                    <div class="img-wrap">
                                    <img src="{{asset($mentor->user->image_path)}}" alt="">
                                    </div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                @else
                                <td>N/A</td>
                            @endif
                            <td>
                                <a href="{{ route('admin.mentor.detail', $mentor->user_id) }}"><i class="fas fa-edit"></i></a>
                                <a onclick="deleteRow('{{route('admin.mentor.delete',['id'=>$mentor->id])}}')"><i class="ml-2 text-danger fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                    {{-- <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr> --}}
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
