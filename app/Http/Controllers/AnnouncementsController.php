<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Http\Controllers\FCMController;

class AnnouncementsController extends Controller
{
    public function index()
    {
      	$announcements = Announcement::orderBy('id', 'desc')->get();
      
        return view('announcements', compact('announcements'));
    }
  
  	public function store(Request $request)
    {
    	 $request->validate([
           'announcement' => 'required|string'
         ]);
      
      	 $announcementId = $request->announcementId ?? null;
      
      	 if($announcementId){
         	$announcement = Announcement::where('id', $announcementId)->first();  
         }else{
         	$announcement = new Announcement();  
         }      	 
      
      	 $announcement->announcement = $request->announcement ?? null;
      	 $announcement->status = 0;
      
      	 if($announcement->save()){
           return redirect()->to('announcements')->with('success', 'Announcement Saved!');
         }
      
       return redirect()->to('announcements')->with('error', 'Announcement Not Saved!');
    }
  
  	public function destroy(Request $request)
    {
     
      	$announcement = Announcement::find($request->id);

        if ($announcement) {
            $announcement->delete();
        }

        return redirect()->back();
      
    }
  
  	public function fetch(Request $request)
    {
    
      $announcement = Announcement::find($request->id);
      
      if($announcement){
        
        return response()->json([
          'status' => true,
          'message' => 'success',
          'data' => $announcement
        ]);
        
      }
      
      return response()->json([
        'status' => false,
        'message' => 'failed',
        'data' => []
      ]);
      
    }
  
  	public function sendAnnouncement(Request $request)
    {
    
      $id = $request->id ?? null;
      
      if($id){
        $announcement = Announcement::where('id', $id)->first();
        
        if($announcement){
          $title = "Announcement!";
          $body = $announcement->announcement;
          $data = [];

          $firebase = new FCMController();
          $firebase->sendFirebaseNotificationToAll($title, $body, $data);
          
          $announcement->status = true;
          $announcement->update();
        }
        
      }
      
      return response()->json([
        'status' => true,
        'message' => 'Announcement Sent!',
      ]);
      
    }
  
  	public function fetch_all_announcements()
    {
      $announcements = Announcement::where('status', 1)->orderBy('id', 'desc')->get();
      
      if($announcements->isNotEmpty()){
      	return response()->json([
          'status' => true,
          'message' => 'Success',
          'data' => $announcements,
        ]);  
      }
      
      return response()->json([
        'status' => false,
        'message' => 'No Announcement',
        'data' => [],
      ]);
    }
  	
  
}
