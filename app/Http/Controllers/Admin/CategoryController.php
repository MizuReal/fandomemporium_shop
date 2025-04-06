<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Category List';
        $data['getRecord'] = CategoryModel::select('categories.*', 'users.name as created_by')
            ->join('users', 'users.id', '=', 'categories.created_by_id')
            ->orderBy('categories.id', 'desc')
            ->get();
        return view('admin.category.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New Category';
        return view('admin.category.add', $data);
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $category = new CategoryModel;
        $category->name = trim($request->name);
        $category->status = $request->status;
        $category->created_by_id = Auth::user()->id;
        $category->save();

        return redirect('admin/category/list')->with('success', 'Category successfully created');
    }

    public function edit($id)
    {
        $data['header_title'] = 'Edit Category';
        $data['getRecord'] = CategoryModel::find($id);
        if(!$data['getRecord']) {
            return redirect('admin/category/list')->with('error', 'Category not found');
        }
        return view('admin.category.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $category = CategoryModel::find($id);
        if(!$category) {
            return redirect('admin/category/list')->with('error', 'Category not found');
        }
        
        $category->name = trim($request->name);
        $category->status = $request->status;
        $category->save();

        return redirect('admin/category/list')->with('success', 'Category successfully updated');
    }

    public function delete($id)
    {
        $category = CategoryModel::find($id);
        if(!$category) {
            return redirect('admin/category/list')->with('error', 'Category not found');
        }
        
        $category->delete();

        return redirect('admin/category/list')->with('success', 'Category successfully deleted');
    }
}
