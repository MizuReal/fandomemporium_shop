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
            <h1>Admin List</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
            <a href = "{{ url ('admin/admin/add')}}" class="btn btn-primary">Add New Admin</a>
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
                <h3 class="card-title">Admin List</h3>
              </div>
  
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->email }}</td>
                      <td>{{ ($value->status == 0) ? 'Active' : 'Inactive' }}</td>
                      <td>
                      <a href = "{{ url('admin/admin/edit/' . $value->id) }}" class="btn btn-primary">Edit</a>
                      <a href = "{{ url('admin/admin/toggle-status/' . $value->id) }}" class="btn btn-{{ ($value->status == 0) ? 'danger' : 'success' }}">{{ ($value->status == 0) ? 'Deactivate' : 'Activate' }}</a>
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