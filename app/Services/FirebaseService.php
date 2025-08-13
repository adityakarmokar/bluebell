<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Messaging\NotFound;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'));    

        $this->messaging = $factory->createMessaging();
    }  
  	
    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $message = [
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],            
        ];

        try {
            return $this->messaging->send($message);
        } catch (NotFound $e) {
            \Log::error('FCM Token not found: ' . $deviceToken);
            \Log::error('Firebase NotFound Error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            \Log::error('Firebase Send Error: ' . $e->getMessage());
        }

        return null;
    }
  
}
