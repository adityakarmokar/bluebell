<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class FCMController extends Controller
{
    
    public function sendFirebaseNotification($title = null, $body = null, $data = [], $fcm_token)
    {
        $firebaseService = new FirebaseService();

        $deviceToken = $fcm_token;
        $title = $title;
        $body = $body;
        $data = $data;

        $response = $firebaseService->sendNotification($deviceToken, $title, $body, $data);

        // return response()->json(['message' => 'Notification sent!', 'response' => $response]);
    }

    public function sendFirebaseNotificationToAll($title = null, $body = null, $data = [])
    {
        $firebaseService = new FirebaseService();
        $users = User::where('status', 1)->where('fcm_token', '!=', null)->get();
      	
      	$i = 0;
      	$fcm = [];
        foreach ($users as $key => $value) {
            $deviceToken = $value->fcm_token;
            $title = $title;
            $body = $body;            
          	$data = $data;

            $response = $firebaseService->sendNotification($deviceToken, $title, $body, $data);
          $i++;          
          
        }
              
        // return response()->json(['message' => 'Notification sent!', 'response' => $response]);
    }
}
