@extends('admin.layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add New Product</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <a href="{{ url('admin/product/list') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Product Details</h3>
                    </div>
                    <form method="post" action="{{ url('admin/product/add') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Product Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category <span style="color: red;">*</span></label>
                                        <select class="form-control" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <input type="text" class="form-control" name="brand" value="{{ old('brand') }}" placeholder="Brand">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Size</label>
                                        <input type="text" class="form-control" name="size" value="{{ old('size') }}" placeholder="Size (e.g. S, M, L, XL)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Color</label>
                                        <input type="text" class="form-control" name="color" value="{{ old('color') }}" placeholder="Color">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old Price (₱)</label>
                                        <input type="number" class="form-control" name="old_price" value="{{ old('old_price') }}" placeholder="Old Price" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Price (₱) <span style="color: red;">*</span></label>
                                        <input type="number" class="form-control" name="new_price" value="{{ old('new_price') }}" required placeholder="New Price" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Short Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" name="short_description" required placeholder="Short Description" rows="2">{{ old('short_description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" name="description" required placeholder="Description" rows="4">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Additional Information</label>
                                <textarea class="form-control" name="additional_information" placeholder="Additional Information" rows="3">{{ old('additional_information') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Related Products</label>
                                        <select class="form-control select2" name="related_products[]" multiple>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span style="color: red;">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="in_stock">In Stock</option>
                                            <option value="out_of_stock">Out of Stock</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Product Images</h4>
                                    <p class="text-muted">Upload up to 5 images for your product. The main image will be used as the primary display image.</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Main Image <span style="color: red;">*</span></label>
                                        <input type="file" class="form-control" name="main_image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image 1</label>
                                        <input type="file" class="form-control" name="image1" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image 2</label>
                                        <input type="file" class="form-control" name="image2" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image 3</label>
                                        <input type="file" class="form-control" name="image3" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image 4</label>
                                        <input type="file" class="form-control" name="image4" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endsection

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border-color: #ced4da;
        min-height: 38px;
    }
</style>
@endsection 