<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function fetch_data()
    {
        $aboutUs = AboutUs::first();
        $aboutUs->about_us = json_decode($aboutUs->about_us);
        return view('about_us', compact('aboutUs'));
    }

    public function update_data(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([            
            'group-a' => 'required|array',              
        ]);

        $about = AboutUs::first();
        $about->about_us = json_encode($request->input('group-a'));

        if($about->save()){
            return redirect()->back()->with('success', 'Update successfull');
        }else{
            return redirect()->back()->with('error', 'Update failed');
        }
    }

    public function fetch_data_api()
    {
        $about = AboutUs::first();
        $about->about_us = json_decode($about->about_us);

      	$imageDomain = env('APP_URL').'uploads/';
        if($about){
            return response()->json(['status'=>true, 'message'=>'success', 'imageDomain'=>$imageDomain, 'data'=>$about->about_us]);
        }else{
            return response()->json(['status'=>false, 'message'=>'failed']);
        }
    }
}
