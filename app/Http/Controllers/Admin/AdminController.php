<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = user::getAdmin();
        return view('admin.admin.list', $data);
    }


    public function add()
    {
        $data['header_title'] = 'Admin List';
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request)
    {
     // Validate request
     $request->validate([
         'name' => 'required',
         'email' => 'required|email|unique:users,email',
         'password' => 'required|min:6',
     ]);

     $user = new User;
     $user->name = $request->name;
     $user->email = $request->email;
     $user->password = Hash::make($request->password);
     $user->is_admin = 1;
     $user->status = 0; // Set default status to 0 (active)
     $user->save();

     return redirect('admin/admin/list')->with('success', 'Admin added successfully');
    }

    public function toggle_status($id)
    {
        $user = User::find($id);
        if(!empty($user))
        {
            // Toggle status (0 to 1 or 1 to 0)
            $user->status = ($user->status == 0) ? 1 : 0;
            $user->save();
            
            $status_text = ($user->status == 0) ? 'activated' : 'deactivated';
            return redirect('admin/admin/list')->with('success', 'Admin account ' . $status_text . ' successfully');
        }
        
        return redirect('admin/admin/list')->with('error', 'Admin account not found');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::find($id);
        if(!empty($data['getRecord']))
        {
            return view('admin.admin.edit', $data);
        }
        return redirect('admin/admin/list')->with('error', 'Admin account not found');
    }

    public function update($id, Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
        ]);
        
        $user = User::find($id);
        if(!empty($user))
        {
            $user->name = $request->name;
            $user->email = $request->email;
            
            // Only update password if it's provided
            if(!empty($request->password))
            {
                $user->password = Hash::make($request->password);
            }
            
            $user->status = $request->status;
            $user->save();
            
            return redirect('admin/admin/list')->with('success', 'Admin account updated successfully');
        }
        
        return redirect('admin/admin/list')->with('error', 'Admin account not found');
    }

}
