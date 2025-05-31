<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Models\HomeBanner;

class HomeBannerController extends Controller
{
  
  public function banner()
  {
    $banners = HomeBanner::all();                
    
    return view('banners', compact('banners'));
  }
  
  public function save_banner(Request $request)
  {                         
    
      $banner = new HomeBanner();
    
      if ($request->hasFile("banner")) {
        $image = $request->file("banner");
        $imageName = 'Service_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/service'), $imageName);
        $banner->banners = 'service/' . $imageName;
      }
      
      $banner->alt = $request->alt;

      if ($banner->save()) {
          return redirect()->to('banners')->with('success', 'Update successful');
      } else {
          return redirect()->to('banners')->with('error', 'Update failed');
      }
  }

  
  public function delete_banner(Request $request)
  {
    $banner = HomeBanner::find($request->id);

    if($banner){
      $banner->delete();
      return redirect()->to('banners')->with('success', 'Delete successful');
    }
    
    return redirect()->to('banners')->with('error', 'Delete failed');
    
  }
  
  public function fetch_banner_api()
  {
    $banners = HomeBanner::select('id','banners','alt')->get(); 
    
    if($banners->isNotEmpty()){
            
      return response()->json([
        'status' =>true,
        'message' => 'success',
        'data' => $banners,
        'imageDomain' => 'https://bluebellgroup.co.in/uploads/'
      ]);
    }
    
    return response()->json([
        'status' =>false,
        'message' => 'Failed',
        'data' => []
      ]);
  }
  
}