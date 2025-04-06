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
            <h1>Add New Category</h1>
          </div>
          <div class="col-sm-12" style="text-align: right;">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="col-md-12">
        <form action="{{ url('admin/category/add') }}" method="post">
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
                    <label>Category Name <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Enter Category Name">
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="0">Unlisted</option>
                        <option value="1">Listed</option>
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