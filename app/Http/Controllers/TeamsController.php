<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TeamsController extends Controller
{
    public function index()
    {
        $data = Team::with('permissions')->get();        
        return view('teams', compact('data'));
    }

    public function create()
    {
        return view('add_team');
    }

    public function store(Request $request)
    {  
        
        $request->validate([
            'username' => 'required|min:3|max:20',
            'phone' => 'nullable|numeric|digits_between:10,14',
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
            'member_details' => 'nullable|string',            
        ]);

        $team = new Team();
        if ($request->image != null && $request->has('image')) {            
            $base64Image = $request->input('image');
            $extension = explode('/', mime_content_type($base64Image))[1];
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $imageName = 'team_' . time() . '.' . $extension;
            $imagePath = public_path('uploads/user/' . $imageName);
            file_put_contents($imagePath, $decodedImage);
            $team->image = 'user/' . $imageName;
        }

        $team->username = $request->username;
        $team->email = $request->email;
        $team->phone = $request->phone;
        $team->password = $request->password;
        $team->member_details = $request->member_details;
        $team->is_active = 1;
        
        if($team->save()){
            Permission::create([
                'team_id'=>$team->id,
            ]);
            return redirect()->to('team')->with('success', 'Team member added successfully');
        }else{
            return redirect()->to('team')->with('error', 'Something error occured');
        }

    }

    public function toggle_team(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->is_active = !$team->is_active; 
        $team->save();

        return response()->json(['status' => $team->is_active, 'message' => 'Team status updated successfully.']);
    }

    public function fetch_team(Request $request, Team $team)
    {
        return view('edit_team', ['team'=>$team]);
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'username' => 'required|min:3|max:20',
            'phone' => 'required|numeric|digits_between:10,14',
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
            'member_details' => 'nullable|string',
            'image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Validate Base64 image
                    if (!preg_match('/^data:image\/(png|jpeg|jpg|webp|avif);base64,/', $value)) {
                        $fail('The ' . $attribute . ' field must be a valid Base64 encoded image.');
                    }
                },
            ],
        ]);        

        if($request->image){
            if ($request->has('image')) {            
                $base64Image = $request->input('image');
                $extension = explode('/', mime_content_type($base64Image))[1];
                $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                $imageName = 'team_' . time() . '.' . $extension;
                $imagePath = public_path('uploads/user/' . $imageName);
                file_put_contents($imagePath, $decodedImage);
                $team->image = 'user/' . $imageName;
            }
        }

        $team->username = $request->username;
        $team->email = $request->email;
        $team->phone = $request->phone;
        $team->password = $request->password;
        $team->member_details = $request->member_details;
        $team->is_active = 1;
        
        if($team->save()){
            return redirect()->to('team')->with('success', 'Team member updated successfully');
        }else{
            return redirect()->to('team')->with('error', 'Something error occured');
        }
    }

    public function destroy(Request $request)
    {
        $member = Team::find($request->user_id);

        if($member){
            $member->delete();
            return response()->json(['status'=>true]);
        }
    }

    public function update_permissions(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:teams,id', 
            'username' => 'required|string|max:255', 
            'dashboard2' => 'nullable|in:on', 
            'search_client' => 'nullable|in:on',
            'services' => 'nullable|in:on',
            'search_token' => 'nullable|in:on',
            'payments' => 'nullable|in:on',
            'reports' => 'nullable|in:on',
            'announcements' => 'nullable|in:on',
            'team_users' => 'nullable|in:on',
            'cms' => 'nullable|in:on',
        ]);
        
        $permissionsData = [
            'dashboard2' => $request->has('dashboard2') ? true : false,
            'search_client' => $request->has('search_client') ? true : false,
            'services' => $request->has('services') ? true : false,
            'search_token' => $request->has('search_token') ? true : false,
            'payments' => $request->has('payments') ? true : false,
            'reports' => $request->has('reports') ? true : false,
            'announcements' => $request->has('announcements') ? true : false,
            'team_users' => $request->has('team_users') ? true : false,
            'cms' => $request->has('cms') ? true : false,
        ];

        $permission = Permission::updateOrCreate(
            ['team_id' => $request->id],
            $permissionsData
        );

        if($permission){
            return redirect()->to('team')->with('success', 'Permissions updated successfully!');
        }else{
            return redirect()->to('team')->with('error', 'Error while updating permission!');
        }

    }

}
