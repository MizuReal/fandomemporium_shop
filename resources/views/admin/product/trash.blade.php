@extends('admin.layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Deleted Products</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <a href="{{ url('admin/product/list') }}" class="btn btn-primary">Back to Products</a>
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
                        <h3 class="card-title">Deleted Products List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="productTrashTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Deleted At</th>
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
                                    <td>
                                        <span class="badge {{ $value->status == 'in_stock' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $value->status == 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </td>
                                    <td>{{ date('d-m-Y H:i', strtotime($value->deleted_at)) }}</td>
                                    <td>
                                        <a href="{{ url('admin/product/restore/'.$value->id) }}" class="btn btn-success btn-sm mb-1">Restore</a>
                                        <a href="{{ url('admin/product/force-delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this product? This action cannot be undone.')">Delete Permanently</a>
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
        $("#productTrashTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": true,
            "order": [[6, 'desc']] // Sort by deleted_at column by default
        });
    });
</script>
@endsection 