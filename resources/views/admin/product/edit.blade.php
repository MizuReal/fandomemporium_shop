@extends('admin.layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product: {{ $getRecord->name }}</h1>
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
                    <form method="post" action="{{ url('admin/product/update/'.$getRecord->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}" required placeholder="Product Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category <span style="color: red;">*</span></label>
                                        <select class="form-control" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option {{ ($category->id == $getRecord->category_id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <input type="text" class="form-control" name="brand" value="{{ $getRecord->brand }}" placeholder="Brand">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Size</label>
                                        <input type="text" class="form-control" name="size" value="{{ $getRecord->size }}" placeholder="Size (e.g. S, M, L, XL)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Color</label>
                                        <input type="text" class="form-control" name="color" value="{{ $getRecord->color }}" placeholder="Color">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old Price (₱)</label>
                                        <input type="number" class="form-control" name="old_price" value="{{ $getRecord->old_price }}" placeholder="Old Price" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Price (₱) <span style="color: red;">*</span></label>
                                        <input type="number" class="form-control" name="new_price" value="{{ $getRecord->new_price }}" required placeholder="New Price" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Short Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" name="short_description" required placeholder="Short Description" rows="2">{{ $getRecord->short_description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" name="description" required placeholder="Description" rows="4">{{ $getRecord->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Additional Information</label>
                                <textarea class="form-control" name="additional_information" placeholder="Additional Information" rows="3">{{ $getRecord->additional_information }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Related Products</label>
                                        <select class="form-control select2" name="related_products[]" multiple>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ in_array($product->id, $related_products) ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span style="color: red;">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="">Select Status</option>
                                            <option {{ ($getRecord->status == 'in_stock') ? 'selected' : '' }} value="in_stock">In Stock</option>
                                            <option {{ ($getRecord->status == 'out_of_stock') ? 'selected' : '' }} value="out_of_stock">Out of Stock</option>
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

                            <!-- Main Image -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Main Image <span style="color: red;">*</span></label>
                                        <input type="file" class="form-control" name="main_image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if(!empty($getRecord->main_image))
                                    <div class="image-container">
                                        <img src="{{ asset($getRecord->main_image) }}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                        <div class="image-delete-overlay">
                                            <a href="{{ url('admin/product/delete-image/' . $getRecord->id . '/main_image') }}" 
                                                class="btn btn-danger btn-sm image-delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-warning">No main image uploaded</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Image 1 & 2 -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Image 1</label>
                                        <input type="file" class="form-control" name="image1" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if(!empty($getRecord->image1))
                                    <div class="image-container">
                                        <img src="{{ asset($getRecord->image1) }}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                        <div class="image-delete-overlay">
                                            <a href="{{ url('admin/product/delete-image/' . $getRecord->id . '/image1') }}" 
                                                class="btn btn-danger btn-sm image-delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-secondary">No image uploaded</div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Image 2</label>
                                        <input type="file" class="form-control" name="image2" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if(!empty($getRecord->image2))
                                    <div class="image-container">
                                        <img src="{{ asset($getRecord->image2) }}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                        <div class="image-delete-overlay">
                                            <a href="{{ url('admin/product/delete-image/' . $getRecord->id . '/image2') }}" 
                                                class="btn btn-danger btn-sm image-delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-secondary">No image uploaded</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Image 3 & 4 -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Image 3</label>
                                        <input type="file" class="form-control" name="image3" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if(!empty($getRecord->image3))
                                    <div class="image-container">
                                        <img src="{{ asset($getRecord->image3) }}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                        <div class="image-delete-overlay">
                                            <a href="{{ url('admin/product/delete-image/' . $getRecord->id . '/image3') }}" 
                                                class="btn btn-danger btn-sm image-delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-secondary">No image uploaded</div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Image 4</label>
                                        <input type="file" class="form-control" name="image4" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if(!empty($getRecord->image4))
                                    <div class="image-container">
                                        <img src="{{ asset($getRecord->image4) }}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                        <div class="image-delete-overlay">
                                            <a href="{{ url('admin/product/delete-image/' . $getRecord->id . '/image4') }}" 
                                                class="btn btn-danger btn-sm image-delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-secondary">No image uploaded</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    
    .image-container {
        position: relative;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .image-delete-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 5px;
        text-align: center;
        display: flex;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .image-container:hover .image-delete-overlay {
        opacity: 1;
    }
    
    .image-delete-btn {
        color: white;
        border-color: transparent;
    }
</style>
@endsection 