@extends('admin.layouts.app')
 @section('style')
  @endsection 

 
@section('content')
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category List</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
            <a href = "{{ url ('admin/category/add')}}" class="btn btn-primary">Add New Category</a>
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          @include('admin.layouts._message')
 
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category List</h3>
              </div>
  
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Category Name</th>
                      <th>Created By</th>
                      <th>Status</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->created_by }}</td>
                        <td>
                          @if($value->status == 1)
                            <span class="badge badge-success">Listed</span>
                          @else
                            <span class="badge badge-danger">Unlisted</span>
                          @endif
                        </td>
                        <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                        <td>
                          <a href="{{ url('admin/category/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                          <a href="{{ url('admin/category/delete/'.$value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            
            </div>
           
          </div>
         
        </div>

      </div>
    </section>
    
  </div>


  @endsection

  @section('script')
    @endsection 