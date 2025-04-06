<?php

namespace App\Imports;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find or create category
        $category = CategoryModel::firstOrCreate(
            ['name' => $row['category']],
            ['status' => 1, 'created_by_id' => Auth::id()]
        );

        // Handle price values
        $oldPrice = isset($row['old_price']) && !empty($row['old_price']) ? $row['old_price'] : null;
        $newPrice = $row['new_price'];

        return new ProductModel([
            'name' => $row['name'],
            'category_id' => $category->id,
            'size' => $row['size'] ?? null,
            'color' => $row['color'] ?? null,
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'brand' => $row['brand'] ?? null,
            'short_description' => $row['short_description'] ?? '',
            'description' => $row['description'] ?? '',
            'additional_information' => $row['additional_information'] ?? null,
            'status' => strtolower($row['status']) === 'in stock' ? 'in_stock' : 'out_of_stock',
            'created_by_id' => Auth::id(),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category' => 'required',
            'new_price' => 'required|numeric',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Product name is required',
            'category.required' => 'Category is required',
            'new_price.required' => 'New price is required',
            'new_price.numeric' => 'New price must be a number',
            'short_description.required' => 'Short description is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
        ];
    }
} 