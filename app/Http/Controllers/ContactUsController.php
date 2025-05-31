<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function fetch_data()
    {
        $contact_details = ContactUs::first();
        // Reformat phone number (9822451638 to 982-245-1638)
        $contact_details->phone = substr($contact_details->phone, 0, 3) . '-' . 
                            substr($contact_details->phone, 3, 3) . '-' . 
                            substr($contact_details->phone, 6);
        return view('contact_us', compact('contact_details'));
    }

    public function update_data(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate(
        [
            'phone' => ['required'],
            'email' => 'required|email',
            'whatsapp'=>'required|numeric',
        ]);

        $validatedData['phone'] = str_replace('-', '', $validatedData['phone']);

        $contact = ContactUs::first();
        $isUpdated = $contact->update($validatedData);

        if($isUpdated){
            return redirect()->back()->with('success', 'Contact Details Updated!');
        }else{
            return redirect()->back()->with('error', 'Something error occured!');
        }
    }

    public function fetch_data_api()
    {
        $contact = ContactUs::first();        

      	$imageDomain = env('APP_URL').'uploads/';
        if($contact){
            return response()->json(['status'=>true, 'message'=>'success', 'imageDomain'=>$imageDomain, 'data'=>['email'=>$contact->email, 'phone'=>$contact->phone, 'whatsapp'=>$contact->whatsapp]]);
        }else{
            return response()->json(['status'=>false, 'message'=>'failed']);
        }
    }
}
