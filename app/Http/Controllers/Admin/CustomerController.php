<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getCustomers();
        $data['header_title'] = 'Customer List';
        return view('admin.customer.list', $data);
    }

    public function toggle_status($id)
    {
        $user = User::find($id);
        if(!empty($user) && $user->is_admin == 0) // Make sure it's a customer account
        {
            // Toggle status (0 to 1 or 1 to 0)
            $user->status = ($user->status == 0) ? 1 : 0;
            $user->save();
            
            $status_text = ($user->status == 0) ? 'activated' : 'deactivated';
            return redirect('admin/customer/list')->with('success', 'Customer account ' . $status_text . ' successfully');
        }
        
        return redirect('admin/customer/list')->with('error', 'Customer account not found');
    }
} 