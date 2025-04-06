@extends('admin.layouts.app')
 @section('style')
  @endsection 

 
@section('content')
 >
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Admin</h1>
          </div>
          <div class="col-sm-12" style="text-align: right;">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="col-md-12">
        <form action="{{ url('admin/admin/add') }}" method="post">
            {{csrf_field()}}
            <div class="card card-primary">
                <div class="card-body">
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  <div class="form-group">
                    <label>Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ old('email') }}">
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name') }}">
                  </div>



                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                  </div>
           
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                  </div>


                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

          </div>
    
  </div>


  @endsection

  @section('script')
    @endsection 