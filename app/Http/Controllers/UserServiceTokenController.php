<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Token;
use App\Models\TokenDocument;
use App\Models\TokenStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserServiceTokenController extends Controller
{
    // Api handling
    public function token_list(Request $request)
    {
        $selfId = auth()->user()->id;

		$imageDomain = env('APP_URL').'uploads/';
        $tokens = Token::where('is_active', 1)->where('user_id', $selfId)->select('id','service_id','user_id','token','status','payment','filed_document','created_at', 'refund_amount', 'payable_amount', 'consultency_fees')->with('service:id,name,service_icons,service_banner,service_details', 'tokenStatus')->orderBy('id', 'desc')->get();
      
      	foreach($tokens as $token){
          $token->status = $this->getStatusBadge($token->tokenStatus()->latest()->value('status'));
          
          $token->payment = $token->consultency_fees ? (string)round($token->consultency_fees) : "";
          $token->isPaid = $token->tokenStatus->contains('status', 5) ? 1 : 0;
          
          $token->makeHidden('tokenStatus', 'payable_amount', 'consultency_fees', 'refund_amount');
        }

        if($tokens->isNotEmpty()){
            return response()->json(['message' => 'success', 'status' =>true, 'imageDomain'=>$imageDomain, 'data'=>$tokens],200);
        }else{            
            return response()->json(['message' => 'No token found', 'data'=>[], 'status' =>true],201);
        }
    }

	private function getStatusBadge($status)
    {
        switch ($status) {
            case 1:
                return 'Token Generated';
            case 2:
                return 'Data Validated';
            case 3:
                return 'Return Not Filed / Not Finalized';
            case 4:
                return 'Return Not Filed / Finalized';
            case 5:
                return 'Payments Completed / Ready to file';
            case 6:
                return 'Returns Filed - Not Verified';
            case 7:
                return 'Return Filed -Verified';
            case 8:
                return 'Document Delivered';
            default:
                return 'Unknown Status';
        }
    }
  
  	private function getStatusBadgeDescription($status)
    {
        switch ($status) {
            case 1:
                return 'Token has been generated successfully.';
            case 2:
                return 'Data validation completed.';
            case 3:
                return 'Required documents have been uploaded successfully.';
            case 4:
                return 'Token finalization completed.';
            case 5:
                return 'Payment is done for this token.';
            case 6:
                return 'Filing done!';
            case 7:
                return 'Verification completed!';
            case 8:
                return 'Hooray! All tasks are completed, and documents are delivered!';
            default:
                return 'No additional details available.';
        }
    }

    public function generate_new_token(Request $request)
    {
        $selfUser = auth()->user();
        // dd($request->all());
        $request->validate([            
            'service_id' => 'required|integer',
        ]);

      	$imageDomain = env('APP_URL').'uploads/';
      
        $service = Service::where('id', $request->service_id)->first();
        if(!$service){
            return response()->json(['message' => 'Service not found', 'status' =>false]);
        }

        $date = now()->format('mdY');        

        $initials = implode('', array_map(function ($word) {
            return strtoupper($word[0]);
        }, explode(' ', $service->name)));

        $token = new Token();
        $token->service_id = $request->service_id;
        $token->user_id = $selfUser->id;
        $token->status = 'Token Generated';
        $token->action_by = 'User';
        $token->save();

        TokenStatus::create([
            'token_id'=>$token->id,
            'status'=>1,
        ]);

        $token_id = "{$initials}{$date}{$token->id}";
        $token->token = $token_id;                

        if($token->save()){
            return response()->json(['message' => 'Token Generated', 'status' =>true, 'imageDomain'=>$imageDomain, 'data'=>$token]);
        }else{
            return response()->json(['message' => 'Failed To generate', 'status' =>false]);
        }

    }

    public function token_upload_documents(Request $request)
    {
        $request->validate([
            'token_id' => 'required|exists:tokens,id',  
            'doc_type' => 'required|string|in:salaried,business', 
          	'form_16_a' => 'array',
            'form_16_a.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',  
          	'annex_use' => 'array',
            'annex_use.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048', 
          	'form_16_parantal' => 'array',
            'form_16_parantal.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048', 
          	'inv_lic_mf' => 'array',
            'inv_lic_mf.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',
            'intrest_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048', 
          	'public_investment' => 'array',
            'public_investment.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:5048',
          	'bank_statement' => 'array',
            'bank_statement.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',
          	'sales_purchase' => 'array',
            'sales_purchase.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',
            'comment' => 'nullable|string',                      
        ]);

        $token = Token::where('id', $request->token_id)->first();    
      
      	$isToken_document = TokenDocument::where('token_id', $token->id)->where('user_id', $token->user_id)->where('service_id', $token->service->id)->first();
      	if($isToken_document){
          $isToken_document->delete();
        }
      
        $additionalDocument = [];
        $validationRules = [];

        if (!empty($token->service->serviceDocuments)) {
            foreach ($token->service->serviceDocuments as $serviceItem) {
                $validationRules[$serviceItem->doc_name . '.*'] = 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048';
                $additionalDocument[] = $serviceItem->doc_name;
            }
        }

        $request->validate($validationRules);

        $documentData = [];

        $multiFileFields = [
            'form_16_a', 'annex_use', 'form_16_parantal', 'inv_lic_mf', 'public_investment', 'bank_statement', 'sales_purchase'
        ];

        foreach ($multiFileFields as $field) {
            if ($request->hasFile($field)) {
                $paths = [];
                foreach ($request->file($field) as $file) {
                    $imageName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/user_document'), $imageName);
                    $paths[] = 'user_document/'. $imageName;                    
                }
                $documentData[$field] = json_encode($paths);
            }
        }

        $addToDocument = [];
        foreach ($additionalDocument as $additional) {
            if ($request->hasFile($additional)) {
                $paths = [];
                foreach ($request->file($additional) as $file) {
                    $imageName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/user_document'), $imageName);
                    $paths[] = 'user_document/'. $imageName;                    
                }
                $addToDocument[$additional] = $paths;
            }
        }

        $documentData['additional_documents'] = json_encode($addToDocument);

        // Handle single file field for interest certificate
        if ($request->hasFile('intrest_certificate')) {
            $image = $request->file('intrest_certificate');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/user_document'), $imageName);
            $documentData['intrest_certificate'] = 'user_document/'. $imageName;
        }

        $tokenDocument  = TokenDocument::create(
            array_merge($documentData, 
            [
                'service_id'=>$token->service_id, 
                'year' => now()->format('Y'),
                'user_id'=>$token->user_id, 
                'token_id'=>$token->id, 
                'doc_type'=>$request->doc_type, 
                'action_by'=>'User', 
                'comment'=>$request->comment,
            ]
        ));

        $token->update([
            'status'=>'Document Uploaded',
        ]);

        return response()->json(['status'=>true, 'success'=>'Documents Uploaded successfully']);

    }
  
  
  	public function download_filed_document()
    {
      
      $selfId = auth()->user()->id;
      
      $tokens = Token::where('user_id', $selfId)->whereNotNull('filed_document')->select('id', 'token', 'service_id', 'filed_document', 'updated_at')->with('service:id,name')->get();      
      
      if($tokens->isNotEmpty()){
        
        foreach($tokens as $token){
          $token->service_name = optional($token->service)->name ?? '';
          $token->makeHidden('service');
        }
        
        return response()->json([
          'status'=>true,
          'message'=> 'success',
          'imageDomain' => url('uploads'),
          'data' => $tokens
        ]);
      }
      
      return response()->json([
        'status'=>true,
        'message'=> 'No Records Found',
        'imageDomain' => url('uploads'),
        'data' => []
      ]);
      
    }
  
  
  	public function payment_history()
    {
      
      $selfId = auth()->user()->id;
      $tokens = Token::where('user_id', $selfId)
        				->whereHas('tokenStatus', function($q){
                          $q->where('status', 4); 
                        })                	        				
        				->select('id', 'token', 'service_id', 'refund_amount', 'payable_amount', 'consultency_fees', 'updated_at')
        				->with('service:id,name', 'tokenStatus', 'payment')
        				->get()
        				->map(function($token){
                          $token->payment_status = $token->payment->status ?? null;
                          return $token;
                        });
      
      if($tokens->isNotEmpty()){
        
        foreach($tokens as $token){
          $token->service_name = optional($token->service)->name ?? '';
          $token->makeHidden('service', 'tokenStatus','payment');          
        }
        
        return response()->json([
          'status'=>true,
          'message'=> 'success',
          'data' => $tokens
        ]);
      }
      
      return response()->json([
        'status'=>true,
        'message'=> 'No History Found',
        'data' => []
      ]);
      
    }

  	public function token_journey(Request $request)
    {
        $token_journey = TokenStatus::where('token_id', $request->token_id)
            ->select('id', 'token_id', 'status', 'updated_at')
            ->get();

        if ($token_journey->isNotEmpty()) {
            $token_journey = $token_journey->map(function ($journey) {
                return [
                    'id' => $journey->id,
                    'token_id' => $journey->token_id,
                    'status' => $journey->status,
                    'updated_at' => \Carbon\Carbon::parse($journey->updated_at)->format('l j M, h:i A'),
                    'current_status' => $this->getStatusBadge($journey->status),
                  	'current_status_description' => $this->getStatusBadgeDescription($journey->status)
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $token_journey
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed',
            'data' => []
        ]);
    }

  
  	public function fetch_token_documents(Request $request)
    {
    
      $userId = auth()->user()->id;            
      $token_documents = TokenDocument::where('user_id', $userId)->where('token_id', $request->token_id)->first();
      
      if($token_documents){ 
        
          $token_documents->form_16_a = json_decode($token_documents->form_16_a) ?? [];
          $token_documents->annex_use = json_decode($token_documents->annex_use) ?? [];
          $token_documents->form_16_parantal = json_decode($token_documents->form_16_parantal) ?? [];
          $token_documents->public_investment = json_decode($token_documents->public_investment) ?? [];
          $token_documents->bank_statement = json_decode($token_documents->bank_statement) ?? [];
          $token_documents->sales_purchase	 = json_decode($token_documents->sales_purchase	) ?? [];          
          $token_documents->makeHidden('action_by', 'deleted_at', 'created_at', 'updated_at') ?? [];          
        
          return response()->json(['status'=>true, 'message'=>'Success', 'data'=>$token_documents]);        
        
      }
      
      return response()->json(['status'=>false, 'message'=>'Failed', 'data'=>[]]);
      
    }
  
  	public function token_fetch_amount(Request $request)
    {
      
      $tokenId = $request->tokenId ?? null;
      
      if($tokenId){
        
        $token = Token::where('id', $tokenId)->first();
        
        if($token){
          $data = [
            'refund_amount' => $token->refund_amount,
            'payable_amount' => $token->payable_amount,
            'consultency_fees' => $token->consultency_fees,
          ];
        }
        
        return response()->json([
          'status' => true,
          'message' => 'success', 
          'data' => $data
        ]);
      }
      
      return response()->json([
        'status' => false,
        'message' => 'Failed', 
        'data' => []
      ]);
      
    }
  
  	public function token_submit_amount(Request $request)
    {
    
      $tokenId = $request->tokenId ?? null;
      $refund_amount = $request->refund_amount ?? null;
      $payable_amount = $request->payable_amount ?? null;
      $consultency_fees_amount = $request->consultency_fees_amount ?? null;
      
      $token = Token::where('id', $tokenId)->first();
      if($token){
        $token->update([
          'refund_amount' => $refund_amount,
          'payable_amount' => $payable_amount,
          'consultency_fees' => $consultency_fees_amount
        ]);
        
        return response()->json(['status'=>true, 'message'=>'success']);
      }
      
      return response()->json(['status'=>false, 'message'=>'failed']);
      
    }
    
}
