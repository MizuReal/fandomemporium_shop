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
            <h1>Edit Admin</h1>
          </div>
          <div class="col-sm-12" style="text-align: right;">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="col-md-12">
        @include('admin.layouts._message')
        <form action="{{ url('admin/admin/edit/'.$getRecord->id) }}" method="post">
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
                    <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email) }}" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $getRecord->name) }}" placeholder="Enter Name">
                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                    <small class="text-muted">Only fill this if you want to change the password</small>
                  </div>
           
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ ($getRecord->status == 0) ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ ($getRecord->status == 1) ? 'selected' : '' }}>Inactive</option>
                    </select>
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
  </div>
@endsection

@section('script')
@endsection
