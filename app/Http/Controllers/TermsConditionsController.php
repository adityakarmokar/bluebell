<?php

namespace App\Http\Controllers;

use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    public function fetch_data()
    {
        $terms = TermsAndCondition::first();
        $terms->t_c = json_decode($terms->t_c);
        return view('terms_conditions', compact('terms'));
    }

    public function update_data(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([            
            'group-a' => 'required|array',              
        ]);

        $terms = TermsAndCondition::first();
        $terms->t_c = json_encode($request->input('group-a'));

        if($terms->save()){
            return redirect()->back()->with('success', 'Update successfull');
        }else{
            return redirect()->back()->with('error', 'Update failed');
        }
    }

    public function fetch_data_api()
    {
        $terms = TermsAndCondition::first();
        $terms->t_c = json_decode($terms->t_c);

      	$imageDomain = env('APP_URL').'uploads/';
        if($terms){
            return response()->json(['status'=>true, 'message'=>'success', 'imageDomain'=>$imageDomain, 'data'=>$terms->t_c]);
        }else{
            return response()->json(['status'=>false, 'message'=>'failed']);
        }
    }
}
