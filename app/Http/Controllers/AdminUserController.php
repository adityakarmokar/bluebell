<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    
    public function index()
    {
        $data = Admin::all();        
        return view('admins', compact('data'));
    }

    public function create()
    {
        return view('add_admin');
    }

    public function store(Request $request)
    {  
        
        $request->validate([
            'username' => 'required|min:3|max:20',
            'phone' => 'nullable|numeric|digits_between:10,14',
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',        
        ]);

        $team = new Admin();        

        $team->fullname = $request->username;
        $team->email = $request->email;
        $team->mobile = $request->phone;
        $team->password = Hash::make($request->password);
        $team->status = 1;
        
        if($team->save()){            
            return redirect()->to('admins')->with('success', 'Admin added successfully');
        }else{
            return redirect()->to('admins')->with('error', 'Something error occured');
        }

    }

    public function fetch_admin(Request $request, Admin $admin)
    {
        return view('edit_admin', ['admin'=>$admin]);
    }
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'username' => 'required|min:3|max:20',
            'phone' => 'required|numeric|digits_between:10,14',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:4',                        
        ]);        
        
        $admin->fullname = $request->username;
        $admin->email = $request->email;
        $admin->mobile = $request->phone;
        if($request->password != null || $request->password != ''){
            $admin->password = Hash::make($request->password);
        }
        $admin->status = 1;
        
        if($admin->save()){
            return redirect()->to('admins')->with('success', 'Admin updated successfully');
        }else{
            return redirect()->to('admins')->with('error', 'Something error occured');
        }
    }

    public function destroy(Request $request)
    {
        $member = Admin::find($request->user_id);

        if($member){
            $member->delete();
            return response()->json(['status'=>true]);
        }
    }
}
