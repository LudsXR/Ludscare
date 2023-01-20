@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Consultant Category List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active"> Consultant Category List</li>
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
                  <h3 class="card-title">Category </h3>
                  <a href="{{route('admin.mentor.category.add')}}" class="card-title">+ Add Category</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                        <th scope="col">Parent Category</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Image</th>
                        {{-- <th scope="col">Description</th> --}}
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                                $count = 1;
                            @endphp
                            @foreach ($mentor_categories as $category)
                                <tr>
                                    <th>{{$count}}</th>
                                    @if(isset($category->parentCategory->name))
                                    <td>{{$category->parentCategory->name}}</td>
                                    @else
                                       <td> It Self Parent</td>
                                    @endif
                                    <td>{{$category->name}}</td>
                                    <td>
                                        @if ($category->image_path)
                                        <img src="{{asset($category->image_path)}}" height="50" width="50" alt="">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    {{-- <td>{{$category->description}}</td> --}}
                                    <td>
                                        <a href="{{ route('admin.mentor.category.detail', $category->id) }}"><i class="fas fa-edit"></i></a>
                                        <a onclick="deleteRow('{{route('admin.mentor.category.delete',['id'=>$category->id])}}')"><i class="me-2 fas fa-trash text-danger ml-2"></i></a>
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
