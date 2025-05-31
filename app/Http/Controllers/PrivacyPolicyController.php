<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function fetch_data()
    {
        $privacy = PrivacyPolicy::first();
        $privacy->privacy_policy = json_decode($privacy->privacy_policy);
        return view('privacy_policy', compact('privacy'));
    }

    public function update_data(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([            
            'group-a' => 'required|array',              
        ]);

        $privacy = PrivacyPolicy::first();
        $privacy->privacy_policy = json_encode($request->input('group-a'));

        if($privacy->save()){
            return redirect()->back()->with('success', 'Update successfull');
        }else{
            return redirect()->back()->with('error', 'Update failed');
        }
    }

    public function fetch_data_api()
    {
        $privacy = PrivacyPolicy::first();
        $privacy->privacy_policy = json_decode($privacy->privacy_policy);

      	$imageDomain = env('APP_URL').'uploads/';
        if($privacy){
            return response()->json(['status'=>true, 'message'=>'success', 'imageDomain'=>$imageDomain, 'data'=>$privacy->privacy_policy]);
        }else{
            return response()->json(['status'=>false, 'message'=>'failed']);
        }
    }


}
