@extends('admin.layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products List</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <a href="{{ url('admin/product/trash') }}" class="btn btn-warning mr-2">Trash</a>
                <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-excel"></i> Import Products
                </button>
                <a href="{{ url('admin/product/add') }}" class="btn btn-primary">Add New Product</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('admin.layouts._message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="productTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getRecord as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->category_name }}</td>
                                    <td>{{ $value->brand }}</td>
                                    <td>
                                        @if(!empty($value->old_price))
                                            <strike>₱{{ number_format($value->old_price, 2) }}</strike><br>
                                        @endif
                                        ₱{{ number_format($value->new_price, 2) }}
                                    </td>
                                    <td>{{ $value->size }}</td>
                                    <td>{{ $value->color }}</td>
                                    <td>
                                        <span class="badge {{ $value->status == 'in_stock' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $value->status == 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </td>
                                    <td>{{ $value->created_by }}</td>
                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                    <td>
                                        <a href="{{ url('admin/product/edit/'.$value->id) }}" class="btn btn-primary btn-sm mb-1">Edit</a>
                                        <a href="{{ url('admin/product/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
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

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('admin/product/import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Products from Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="importFile">Choose Excel File</label>
                        <input type="file" class="form-control-file" id="importFile" name="file" required accept=".xlsx, .xls, .csv">
                        <small class="form-text text-muted">
                            Please use the correct format for importing products. 
                            <a href="{{ url('admin/product/download-sample') }}" class="text-primary">Download Sample File</a>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection

@section('script')
<!-- DataTables & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#productTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": true,
            "buttons": ["copy", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#productTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection 