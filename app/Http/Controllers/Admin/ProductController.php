<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\User;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Product List';
        $data['getRecord'] = ProductModel::select('products.*', 'categories.name as category_name', 'users.name as created_by')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('users', 'users.id', '=', 'products.created_by_id')
            ->orderBy('products.id', 'desc')
            ->get();
        return view('admin.product.list', $data);
    }

    public function trash()
    {
        $data['header_title'] = 'Deleted Products';
        $data['getRecord'] = ProductModel::select('products.*', 'categories.name as category_name', 'users.name as created_by')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('users', 'users.id', '=', 'products.created_by_id')
            ->orderBy('products.id', 'desc')
            ->onlyTrashed()
            ->get();
        return view('admin.product.trash', $data);
    }

    public function restore($id)
    {
        $product = ProductModel::onlyTrashed()->find($id);
        if(!$product) {
            return redirect('admin/product/trash')->with('error', 'Product not found');
        }
        
        $product->restore();
        return redirect('admin/product/trash')->with('success', 'Product successfully restored');
    }

    public function forceDelete($id)
    {
        $product = ProductModel::onlyTrashed()->find($id);
        if(!$product) {
            return redirect('admin/product/trash')->with('error', 'Product not found');
        }
        
        // Delete product images
        $this->deleteProductImage($product->main_image);
        $this->deleteProductImage($product->image1);
        $this->deleteProductImage($product->image2);
        $this->deleteProductImage($product->image3);
        $this->deleteProductImage($product->image4);
        
        // Delete related products
        $product->relatedProducts()->detach();
        
        $product->forceDelete();

        return redirect('admin/product/trash')->with('success', 'Product permanently deleted');
    }

    public function add()
    {
        $data['header_title'] = 'Add New Product';
        $data['categories'] = CategoryModel::orderBy('name', 'asc')->get();
        $data['products'] = ProductModel::where('status', '=', 'in_stock')->orderBy('name', 'asc')->get();
        return view('admin.product.add', $data);
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required|numeric',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $product = new ProductModel;
        $product->name = trim($request->name);
        $product->category_id = $request->category_id;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        $product->brand = $request->brand;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->additional_information = $request->additional_information;
        $product->status = $request->status;
        $product->created_by_id = Auth::user()->id;
        
        // Handle individual images
        if ($request->hasFile('main_image')) {
            $product->main_image = $this->uploadImage($request->file('main_image'));
        }
        
        if ($request->hasFile('image1')) {
            $product->image1 = $this->uploadImage($request->file('image1'));
        }
        
        if ($request->hasFile('image2')) {
            $product->image2 = $this->uploadImage($request->file('image2'));
        }
        
        if ($request->hasFile('image3')) {
            $product->image3 = $this->uploadImage($request->file('image3'));
        }
        
        if ($request->hasFile('image4')) {
            $product->image4 = $this->uploadImage($request->file('image4'));
        }
        
        $product->save();
        
        // Handle related products
        if (!empty($request->related_products)) {
            $product->relatedProducts()->attach($request->related_products);
        }

        return redirect('admin/product/list')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $data['header_title'] = 'Edit Product';
        $data['getRecord'] = ProductModel::find($id);
        if(!$data['getRecord']) {
            return redirect('admin/product/list')->with('error', 'Product not found');
        }
        $data['categories'] = CategoryModel::orderBy('name', 'asc')->get();
        $data['products'] = ProductModel::where('status', '=', 'in_stock')
            ->where('id', '!=', $id)
            ->orderBy('name', 'asc')
            ->get();
        
        // Get currently related products
        $data['related_products'] = $data['getRecord']->relatedProducts->pluck('id')->toArray();
        
        return view('admin.product.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required|numeric',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $product = ProductModel::find($id);
        if(!$product) {
            return redirect('admin/product/list')->with('error', 'Product not found');
        }
        
        $product->name = trim($request->name);
        $product->category_id = $request->category_id;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        $product->brand = $request->brand;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->additional_information = $request->additional_information;
        $product->status = $request->status;
        
        // Handle individual images
        if ($request->hasFile('main_image')) {
            $this->deleteProductImage($product->main_image);
            $product->main_image = $this->uploadImage($request->file('main_image'));
        }
        
        if ($request->hasFile('image1')) {
            $this->deleteProductImage($product->image1);
            $product->image1 = $this->uploadImage($request->file('image1'));
        }
        
        if ($request->hasFile('image2')) {
            $this->deleteProductImage($product->image2);
            $product->image2 = $this->uploadImage($request->file('image2'));
        }
        
        if ($request->hasFile('image3')) {
            $this->deleteProductImage($product->image3);
            $product->image3 = $this->uploadImage($request->file('image3'));
        }
        
        if ($request->hasFile('image4')) {
            $this->deleteProductImage($product->image4);
            $product->image4 = $this->uploadImage($request->file('image4'));
        }
        
        $product->save();
        
        // Update related products
        $product->relatedProducts()->detach();
        if (!empty($request->related_products)) {
            $product->relatedProducts()->attach($request->related_products);
        }

        return redirect('admin/product/list')->with('success', 'Product successfully updated');
    }

    public function delete($id)
    {
        $product = ProductModel::find($id);
        if(!$product) {
            return redirect('admin/product/list')->with('error', 'Product not found');
        }
        
        $product->delete(); // This will use soft delete

        return redirect('admin/product/list')->with('success', 'Product moved to trash');
    }

    public function deleteImage($product_id, $image_field)
    {
        $product = ProductModel::find($product_id);
        if(!$product) {
            return redirect('admin/product/list')->with('error', 'Product not found');
        }
        
        // Check if the image field exists and delete it
        if (isset($product->$image_field) && !empty($product->$image_field)) {
            $imagePath = $product->$image_field;
            $this->deleteProductImage($imagePath);
            
            // Clear the field in the database
            $product->$image_field = null;
            $product->save();
            
            return redirect('admin/product/edit/'.$product_id)->with('success', 'Image successfully deleted');
        }
        
        return redirect('admin/product/edit/'.$product_id)->with('error', 'Image not found');
    }
    
    /**
     * Helper method to upload an image
     */
    private function uploadImage($image)
    {
        $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/products'), $imageName);
        return 'uploads/products/' . $imageName;
    }
    
    /**
     * Helper method to delete an image
     */
    private function deleteProductImage($imagePath)
    {
        if (!empty($imagePath) && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        
        try {
            Excel::import(new ProductImport, $request->file('file'));
            return redirect('admin/product/list')->with('success', 'Products imported successfully');
        } catch (\Exception $e) {
            return redirect('admin/product/list')->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }
    
    public function downloadSample()
    {
        $file = public_path('samples/product_import_sample.xlsx');
        
        // Create samples directory if it doesn't exist
        if (!File::exists(public_path('samples'))) {
            File::makeDirectory(public_path('samples'), 0755, true);
        }
        
        // If the sample file doesn't exist, create it
        if (!File::exists($file)) {
            $headers = [
                'name', 'category', 'size', 'color', 'old_price', 'new_price',
                'brand', 'short_description', 'description', 'additional_information',
                'status'
            ];
            
            $sampleData = [
                [
                    'name' => 'Sample T-Shirt',
                    'category' => 'Tshirts',
                    'size' => 'M',
                    'color' => 'Blue',
                    'old_price' => '1000',
                    'new_price' => '800',
                    'brand' => 'Fandom Brand',
                    'short_description' => 'High-quality cotton T-shirt',
                    'description' => 'This is a detailed description of the T-shirt.',
                    'additional_information' => 'Made with 100% cotton',
                    'status' => 'In Stock'
                ],
                [
                    'name' => 'Sample Keychain',
                    'category' => 'KeyChain',
                    'size' => '',
                    'color' => 'Black, Gold',
                    'old_price' => '',
                    'new_price' => '150',
                    'brand' => 'Fandom Brand',
                    'short_description' => 'Metal keychain with logo',
                    'description' => 'This is a detailed description of the keychain.',
                    'additional_information' => '',
                    'status' => 'In Stock'
                ]
            ];
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Add headers
            $column = 1;
            foreach ($headers as $header) {
                $sheet->setCellValueByColumnAndRow($column++, 1, $header);
            }
            
            // Add sample data
            $row = 2;
            foreach ($sampleData as $data) {
                $column = 1;
                foreach ($headers as $header) {
                    $sheet->setCellValueByColumnAndRow($column++, $row, $data[$header]);
                }
                $row++;
            }
            
            // Save the file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($file);
        }
        
        return response()->download($file, 'product_import_sample.xlsx');
    }
} 