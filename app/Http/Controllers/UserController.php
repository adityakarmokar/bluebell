<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserBankAccountDetail;
use App\Models\UserDocument;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\Models\PrivacyPolicy;
use App\Models\ContactUs;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Admin Section
    public function index(Request $request)
    {    
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);
        
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;

        $query = User::orderBy('id', 'DESC');
        if($from_date && $to_date){
            $query = $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        // $data = $query->get();           
        if ($request->ajax()) {
              return DataTables::of($query)
                  ->addIndexColumn() 
                  ->addColumn('name', function($user){
                      return $user ? $user->fname . ' ' . $user->mname . ' ' . $user->lname : '';
                  })                
                  ->editColumn('created_at', function ($user) {                                                               
                      return Carbon::parse($user->created_at)->format('Y-m-d');
                  })                
                  ->editColumn('status', function ($user) {

                      $status = '<label class="switch">';

                      $status .= '<input type="checkbox" class="switch-input" '.($user->status == 1 ? "checked" : "").' id="status-toggle" onclick="toggleStatus('.$user->id.')" />';
                      $status .= '<span class="switch-toggle-slider">
                                      <span class="switch-on"></span>
                                      <span class="switch-off"></span>
                                  </span>';                           

                      $status .= '</label>';                    

                      return $status;
                  })                
                  ->addColumn('actions', function($user){                    

                      $actions = '<div class="d-flex">';
                    
                    if(session('type') !== 'user'){
                      $actions .= '<a href="' . route('view.user', ['user' => $user]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> |
                                  <a href="javascript:void(0);" onclick="myFunction(' . $user->id . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a>';                    
                    }else{
                      $actions .= '<a href="' . route('view.user', ['user' => $user]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a>';                    
                    }

                      

                      $actions .= '</div>';
                      return $actions;
                  })
                  ->rawColumns(['status', 'actions'])
                  ->make(true); 
          }
        
        return view('users');
    }
  

    public function destroy(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user) {
            $user->delete();
        }

        return redirect()->back();
    }

    public function create(Request $request)
    {
        $input = $request->get('phone', null);

        if($input){
            if(preg_match('/^\d{10,15}$/', $input)){
                $type = 'phone';
            }elseif(preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i', $input)){
                $type = 'pan';
            }else{
                $type = 'unknown';
            }
        }else{
            $type = null;
            $input = null;
        }

        return view('add_user', ['inputType' => $type, 'inputValue' => $input]);
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([            
            'pan_no' => 'required|string|size:10|unique:users,pan_no', 
            'dob' => 'required|date|before:today',
            'adhar_number' => 'required|unique:users,adhar_number', 
            'fname' => 'nullable|string|max:255',
            'mname' => 'nullable|string|max:255', 
            'lname' => 'required|string|max:255', 
            'f_fname' => 'nullable|string|max:255',
            'f_mname' => 'nullable|string|max:255',
            'f_lname' => 'required|string|max:255', 
            'phone' => 'required|digits_between:10,15|unique:users,phone', 
            'mobile' => 'nullable|digits_between:10,15',
            'email' => 'required|email|max:255',
            'house_no' => 'nullable|string|max:255',
            'house_name' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255', 
            'city' => 'required|string|max:255', 
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pin_code' => 'required|digits:6', 
            'office_check' => 'nullable|in:1', 
            'office_house_no' => 'nullable|string|max:255', 
            'office_house_name' => 'nullable|string|max:255',
            'office_street' => 'nullable|string|max:255',
            'office_area' => 'nullable|string|max:255', 
            'office_city' => 'nullable|string|max:255',
            'office_state' => 'nullable|string|max:255',
            'office_country' => 'nullable|string|max:255',
            'office_pin_code' => 'nullable|digits:6',  
        ]);
        
        // dd($request->all());
        $user = new User();

        // if ($request->has('image')) {            
        //     $base64Image = $request->input('image');                        
        //     $extension = explode('/', mime_content_type($base64Image))[1];
        //     $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));                        
        //     $imageName = 'profile_' . time() . '.' . $extension;                        
        //     $imagePath = public_path('uploads/user/' . $imageName);                        
        //     file_put_contents($imagePath, $decodedImage);                        
        //     $user->image = 'user/' . $imageName;
        // }

        $user->fname = $data['fname'];
        $user->mname = $data['mname'];
        $user->lname = $data['lname'];
        $user->f_fname = $data['f_fname'];
        $user->f_mname = $data['f_mname'];
        $user->f_lname = $data['f_lname'];
        $user->phone = $data['phone'];
        $user->mobile = $data['mobile'];
        $user->email = $data['email'];
        $user->pan_no = $data['pan_no'];
        $user->adhar_number = $data['adhar_number'];
        $user->dob = \Carbon\Carbon::parse($data['dob'])->format('Y-m-d');           
        $user->action_by = 'Admin';
        $user->save();

        // dd($user);

        // ==================================================
        // User Address details
        $userAddress = new UserAddress();
        $userAddress->fill([
            'user_id' => $user->id,
            'house_no' => $data['house_no'],
            'house_name' =>  $data['house_name'],
            'street' => $data['street'],
            'area' => $data['area'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'pin_code' => $data['pin_code'],
        ]);

        $officeData = isset($data['office_check']) && $data['office_check'] == 1
        ? [
            'office_house_no' => $data['house_no'],
            'office_house_name' => $data['house_name'],
            'office_street' => $data['street'],
            'office_area' => $data['area'],
            'office_city' => $data['city'],
            'office_state' => $data['state'],
            'office_country' => $data['country'],
            'office_pin_code' => $data['pin_code'],
        ] :
        [
            'office_house_no' => $data['office_house_no'],
            'office_house_name' => $data['office_house_name'],
            'office_street' => $data['office_street'],
            'office_area' => $data['office_area'],
            'office_city' => $data['office_city'],
            'office_state' => $data['office_state'],
            'office_country' => $data['office_country'],
            'office_pin_code' => $data['office_pin_code'],
        ];
        $userAddress->fill($officeData);
        $userAddress->office_check = isset($data['office_check']) && $data['office_check'] ?? $data['office_check'];
        $userAddress->save();
        // =======================================================

        // =======================================================
        // User Bank Account Details Handle
        foreach($request->input('group-a') as $accountDetails){
            $userBankAccountDetail = new UserBankAccountDetail();
            $userBankAccountDetail->user_id = $user->id;
            $userBankAccountDetail->account_type = $accountDetails['account_type'];
            $userBankAccountDetail->bank_name = $accountDetails['bank_name'];
            $userBankAccountDetail->account_no = $accountDetails['account_no'];
            $userBankAccountDetail->ifsc = $accountDetails['ifsc'];
            $userBankAccountDetail->branch = $accountDetails['branch'];
            $userBankAccountDetail->income_tax_password = $request->income_tax_password;
            $userBankAccountDetail->action_by = 'Admin';
            $userBankAccountDetail->save();    
        }
        // ===========================================            

        return redirect()->to('users')->with('success', 'User details saved successfully');
    }

    public function toggle_user(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status; 
        $user->save();

        return response()->json(['status' => $user->status, 'message' => 'User status updated successfully.']);
    }

    public function fetch_user(Request $request, User $user)
    {
        $data = $user->load('userBankAccountDetail', 'userAddress');
      //dd($data);
        return view('edit_user', compact('data'));
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());        
        $data = $request->validate([            
            'pan_no' => 'required|string|size:10', 
            'dob' => 'required|date|before:today',
            'adhar_number' => 'required', 
            'fname' => 'nullable|string|max:255',
            'mname' => 'nullable|string|max:255', 
            'lname' => 'required|string|max:255', 
            'f_fname' => 'nullable|string|max:255',
            'f_mname' => 'nullable|string|max:255',
            'f_lname' => 'required|string|max:255', 
            'phone' => 'required|digits_between:10,15', 
            'mobile' => 'nullable|digits_between:10,15',
            'email' => 'required|email|max:255',
            'house_no' => 'nullable|string|max:255',
            'house_name' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255', 
            'city' => 'required|string|max:255', 
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pin_code' => 'required|digits:6', 
            'office_check' => 'nullable|in:1', 
            'office_house_no' => 'nullable|string|max:255', 
            'office_house_name' => 'nullable|string|max:255',
            'office_street' => 'nullable|string|max:255',
            'office_area' => 'nullable|string|max:255', 
            'office_city' => 'nullable|string|max:255', 
            'office_state' => 'nullable|string|max:255',
            'office_country' => 'nullable|string|max:255',
            'office_pin_code' => 'nullable|digits:6',   
        ]);

        // User Handle
        
        // if ($request->image != null && $request->has('image')) {
            
        //     $base64Image = $request->input('image');
        //     $extension = explode('/', mime_content_type($base64Image))[1];
        //     $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        //     $imageName = 'profile_' . time() . '.' . $extension;
        //     $imagePath = public_path('uploads/user/' . $imageName);
        //     file_put_contents($imagePath, $decodedImage);
        //     $user->image = 'user/' . $imageName;
        // }        

        $user->fname = $data['fname'] ?? null;
        $user->mname = $data['mname'] ?? null;
        $user->lname = $data['lname'] ?? null;
        $user->f_fname = $data['f_fname'] ?? null;
        $user->f_mname = $data['f_mname'] ?? null;
        $user->f_lname = $data['f_lname'] ?? null;
        $user->phone = $data['phone'] ?? null;
        $user->mobile = $data['mobile'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->pan_no = $data['pan_no'] ?? null;
        $user->adhar_number = $data['adhar_number'] ?? null;
        $user->dob = \Carbon\Carbon::parse($data['dob'])->format('Y-m-d') ?? null;           
        $user->action_by = 'Admin';
        $user->save();

        // ==================================================
        // User Address details
      
      	$userAddress1 = UserAddress::where('user_id', $user->id)->first();
      	if(!$userAddress1){
          $userAddress1 = UserAddress::create([
            'user_id' => $user->id
          ]);
        }
      
        $userAddress = $userAddress1;
        $userAddress->fill([            
            'house_no' => $data['house_no'] ?? null,
            'house_name' =>  $data['house_name'] ?? null,
            'street' => $data['street'] ?? null,
            'area' => $data['area'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
            'pin_code' => $data['pin_code'] ?? null,
        ]);

        $officeData = isset($data['office_check']) && $data['office_check'] == 1
        ? [
            'office_house_no' => $data['house_no'] ?? null,
            'office_house_name' => $data['house_name'] ?? null,
            'office_street' => $data['street'] ?? null,
            'office_area' => $data['area'] ?? null,
            'office_city' => $data['city'] ?? null,
            'office_state' => $data['state'] ?? null,
            'office_country' => $data['country'] ?? null,
            'office_pin_code' => $data['pin_code'] ?? null,
        ] :
        [
            'office_house_no' => $data['office_house_no'] ?? null,
            'office_house_name' => $data['office_house_name'] ?? null,
            'office_street' => $data['office_street'] ?? null,
            'office_area' => $data['office_area'] ?? null,
            'office_city' => $data['office_city'] ?? null,
            'office_state' => $data['office_state'] ?? null,
            'office_country' => $data['office_country'] ?? null,
            'office_pin_code' => $data['office_pin_code'] ?? null,
        ];
        $userAddress->fill($officeData);
        $userAddress->office_check = isset($data['office_check']) && $data['office_check'] ?? $data['office_check'];
        $userAddress->save();
        // =======================================================

        // =======================================================
        // User Bank Account Details Handle
        UserBankAccountDetail::where('user_id', $user->id)->delete();

        if ($request->has('group-a') && is_array($request->input('group-a'))) {
            foreach($request->input('group-a') as $accountDetails){
                $userBankAccountDetail = new UserBankAccountDetail();
                $userBankAccountDetail->user_id = $user->id ?? null;
                $userBankAccountDetail->account_type = $accountDetails['account_type'] ?? null;
                $userBankAccountDetail->bank_name = $accountDetails['bank_name'] ?? null;
                $userBankAccountDetail->account_no = $accountDetails['account_no'] ?? null;
                $userBankAccountDetail->ifsc = $accountDetails['ifsc'] ?? null;
                $userBankAccountDetail->branch = $accountDetails['branch'] ?? null;
                $userBankAccountDetail->income_tax_password = $request->income_tax_password ?? null;
                $userBankAccountDetail->action_by = 'Admin';
                $userBankAccountDetail->save();    
            }
        }
        // =========================================== 

        return redirect()->back()->with('success', 'User details updated successfully');

    }

    public function view(Request $request, User $user)
    {
        $user = $user->load('userBankAccountDetail', 'tokens', 'userAddress');
        return view('view_user', compact('user'));
    }


    public function user_tokens(User $user)
    {
        $user = $user->load('ca_tokens');
        // dd($user);
        return view('user_tokens', ['data'=>$user]);
    }


    // API Handling Section
    public function user_signup(Request $request)
    {
      
      	$request->validate([
            'phone' => 'required|numeric',
            'pan_no' => 'required|string',
            'fname' => 'required|string'
        ]);
      
        $user =  User::where('phone', $request->phone)->whereNotNull('phone_verified_at')->first();
        $user_pan =  User::where('pan_no', $request->pan_no)->whereNotNull('phone_verified_at')->first();

        if($user)
        {
            return response()->json(['message'=>'Mobile Number already exists','status'=>false,],201);
        }else if($user_pan)
        {
            return response()->json(['message'=>'PAN Number already exists','status'=>false,],201);
        }       

        $phone = "91".$request->phone;
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $otp_expires_at = now()->addMinutes(10);     
          
     	$user =  User::where('phone', $request->phone)->whereNull('phone_verified_at')->first();
      	if(!$user){
        	$user = new User();
        }	            	
      
      	$user->phone = $request->phone;
      	$user->fname = $request->fname;
      	$user->mname = $request->mname;
      	$user->lname = $request->lname;
      	$user->pan_no = $request->pan_no;
      	$user->email = $request->email;
      	$user->otp = $otp;
      	$user->otp_expires_at = $otp_expires_at;
      
      	$user->save();
      
      	$template_id = "682ee0c2d6fc0518190e2572";
        $authkey = "453025Azs5VZhDaFf682db06dP1";                                
        $data = [
          "template_id" => $template_id,
          "recipients" => [
            [
              "mobiles" => (string)$phone,
              "var" => $otp
            ]
          ]
        ];

        $payload = json_encode($data);        
        
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authkey: $authkey",
            "content-type: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);               

        if ($error) {
          \Log::debug('Sign-up', ['error' => $error]);                    
        } else {
          \Log::debug('Signup', ['success' => $response, 'http'=>$http_code]);                    
        }        

        if(!$user)
        {
            return response()->json(['message'=>'failed','status'=>false,],201); 
        }

        return response()->json(['message'=>'OTP send successfully','status'=>true],200);
    }

    public function user_login(Request $request)
    {
        $number = $request->phone ?? null;
      	$pan_no = $request->pan_no ?? null;
      
      	if($number){
         	$user = User::where('phone', $number)->first();
        }else{
        	$user = User::where('pan_no', $pan_no)->first();  
        }
      	

        if(!$user)
        {
            return response()->json(['message'=>'User Not Found', 'status'=>false,], 201);
        }else if($user->phone_verified_at === NULL){
          	return response()->json(['message'=>'User not registered', 'status'=>false,], 201);
        }
        else
        {
            if($user->status != 1){
                return response()->json(['message'=>'You are not allowed to login', 'status'=>false,], 201);
            }else{
                $phone = "91".$request->phone;
                $otp = $request->phone == '9811461935' ? '1234' : str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $otp_expires_at = now()->addMinutes(10);     
              
              	$user->update(['otp'=>$otp, 'otp_expires_at'=>$otp_expires_at]);

                $template_id = "682ee0c2d6fc0518190e2572";
                $authkey = "453025Azs5VZhDaFf682db06dP1";                                
                $data = [
                    "template_id" => $template_id,
                  	"recipients" => [
                        [
                            "mobiles" => (string)$phone,
                            "var" => $otp
                        ]
                    ]
                ];

                $payload = json_encode($data);
				\Log::debug('payload', ['payload' => $data]); 
              	//dd('hello');
                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "authkey: $authkey",
                        "content-type: application/json"
                    ],
                ]);

                $response = curl_exec($curl);
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $error = curl_error($curl);

                curl_close($curl);               

                if ($error) {
                  	\Log::debug('Login', ['error' => $error]);                    
                } else {
                  	\Log::debug('Login Hello', ['success' => $response, 'http'=>$http_code]);                    
                }

                
                return response()->json(['message'=>'OTP Send Successfully', 'status'=>true],200);  
            }             
        }
    }

    public function user_verifyotp(Request $request)
    {     
      	$phone = $request->phone ?? null;
      	$pan_no = $request->pan_no ?? null;
      
        if($request->phone == '9811461935' && $request->otp == '1234'){
            $user = User::where('phone', $request->phone)->first();
            $user->otp_expires_at = now()->addMinutes(15);
            $user->save();
        }else{
          
          	if($phone){
            	$user = User::where('phone', $phone)->where('otp', $request->otp)->first();  
            }else if($pan_no){
              	$user = User::where('pan_no', $pan_no)->where('otp', $request->otp)->first();  
            }
            
        }     

        // $user = User::where('otp', $request->otp)->where('phone', $request->phone)->orWhere('pan_no', $request->pan_no)->first();
        
        if(!$user)
        {
            return response()->json(['message' => 'Invalid OTP', 'status' => false], 201);
        }
            	
      
        if($user->otp_expires_at >= now()) {			
            
            $user_token = $user->createToken('WebToken')->plainTextToken;
            
            User::where('phone', $request->phone)->orWhere('pan_no', $request->pan_no)->update([
                'otp'=>null,
                'user_token'=>$user_token,
            ]);
            

            $user->user_token = $user_token;
			$user->phone_verified_at = now();
          	$user->save();
            
            return response()->json(['message'=>'success','status'=>true, 'data'=>$user], 200);
        }else{
            return response()->json(['message'=>'OTP Expired','status'=>false], 200);   
        }
    }

    public function fetch_userprofile(Request $request)
    {
        $selfId = auth()->user()->id;

		$imageDomain = env('APP_URL').'uploads/';

        $data = User::where('id', $selfId)->with(['latestUserBankAccountDetail', 'userAddress'])->first();   

        if(!$data){
            return response()->json(['message'=>'Something went wrong', 'status'=>false], 404);    
        }

        return response()->json(['message'=>'success', 'status'=>true, 'imageDomain'=>$imageDomain, 'data'=>$data], 200);
    }

    public function account_delete(Request $request)
    {
        $user = User::whereId($request->user_id)->with('userBankAccountDetail')->first();  
        
        if($user){
            $user->action_by = 'User';
            $user->save();
            $user->delete();
            return response()->json(['message'=>'Account Deleted', 'status'=>true], 200);
        }else{
            return response()->json(['message'=>'User Not Found', 'status'=>false], 404);
        }
    }

    public function add_userdetails(Request $request)
    {
        $selfId = auth()->user()->id;
        $user = User::where('id', $selfId)->first();
        if(!$user){
            return response()->json(['message'=>'User Not Found', 'status'=>false], 404);    
        }

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5048',
            'fname' => 'nullable|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'father_fname' => 'nullable|string|max:255',
            'father_mname' => 'nullable|string|max:255',
            'father_lname' => 'nullable|string|max:255',
            'dob' => 'required|date|before:today',
            'adhar_number' => 'required',
            'office_check' => 'nullable',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|numeric|digits_between:9,28',
            'ifsc' => 'nullable|string|regex:/^[A-Z]{4}[0-9]/',
            'branch' => 'nullable|string|max:100',
            'income_tax_password' => 'nullable|string|min:6|max:30',
            'email' => 'nullable|string|email'
        ]);
      
      	if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),                
            ], 200);
        }

        $user_image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'User_' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/user'), $imageName);
            $user_image = 'user/'. $imageName;
        }

        User::whereId($selfId)->update([
            'fname'=>$request->fname,
            'mname'=>$request->mname,
            'lname'=>$request->lname,
            'f_fname'=>$request->father_fname,
            'f_mname'=>$request->father_mname,
            'f_lname'=>$request->father_lname,
            'dob'=>$request->dob,
            'adhar_number'=>$request->adhar_number,
            'address'=>$request->address ?? null,
            'action_by'=>'User',
          	'email' => $request->email,
        ]);

        if ($user_image !== null) {
            User::where('id', $selfId)->update([
                'image' => $user_image,
            ]);
        }

        UserAddress::updateOrCreate(
            ['user_id' => $selfId],
            [
                'house_no' => $request->house_no,
                'house_name' =>  $request->house_name,
                'street' => $request->street,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pin_code' => $request->pin_code, 
                'office_check' => $request->office_check,
                'office_house_no' => $request->office_house_no,
                'office_house_name' => $request->office_house_name,
                'office_street' => $request->office_street,
                'office_area' => $request->office_area,
                'office_city' => $request->office_city,
                'office_state' => $request->office_state,
                'office_country' => $request->office_country,
                'office_pin_code' => $request->office_pin_code,
            ]
        );         

        UserBankAccountDetail::updateOrCreate(
            ['user_id' => $selfId],
            [
            'bank_name'=>$request->bank_name,
            'account_type' => $request->account_type,
            'account_no'=>$request->account_number,
            'ifsc'=>$request->ifsc,
            'branch'=>$request->branch,
            'income_tax_password'=>$request->income_tax_password,
            'action_by'=>'User',
            ]
        );             

        return response()->json(['message' => 'Profile updated successfully', 'status' =>true], 200);
    }

    public function searchUser(Request $request)
    {
        $searchTerm = $request->query('search_user');
        if($searchTerm != ''){
            $user = User::where('phone', 'like', "%{$searchTerm}%")
                            ->orWhere('pan_no', 'like', "%{$searchTerm}%")
                            ->orWhere('fname', 'like', "%{$searchTerm}%")
                            ->orWhere('mname', 'like', "%{$searchTerm}%")
                            ->orWhere('lname', 'like', "%{$searchTerm}%")
                            ->get();
    
            if ($user->isNotEmpty()) {
                return response()->json([
                    'status' => 'found',
                    'type' => 'user',
                    'user' => $user,
                ]);
            } else {
                $token = Token::where('token', 'like', "%{$searchTerm}%")->get();
    
                if($token->isNotEmpty()){
                    return response()->json([
                        'status' => 'found',
                        'type' => 'token',
                        'token' => $token,
                    ]);    
                }else{
                    return response()->json([
                        'status' => 'Not found'
                    ]);
                }
                
            }
        }else{
            return response()->json([
                'status' => 'Not found'
            ]);
        }
    }

    public function validate_request(Request $request)
    {
        if($request->type == 1){
            $user = User::where('pan_no', $request->pan_no)->count();
        }else if($request->type == 2){
            $user = User::where('adhar_number', $request->aadhar)->count();
        }else if($request->type == 3){
            $user = User::where('phone', $request->phone)->count();
        }

        if($user > 0){
            return response()->json(['message' => 'Already taken', 'status' =>false], 200);
        }else{
            return response()->json(['message' => 'Available to use', 'status' =>true], 201);
        }
    }

    public function validate_aadhar(Request $request)
    {
        $user = User::where('adhar_number', $request->aadhar)->count();

        if($user > 0){
            return response()->json(['message' => 'Already taken', 'status' =>false], 200);
        }else{
            return response()->json(['message' => 'Available to use', 'status' =>true], 201);
        }
    }

    public function validate_phone(Request $request)
    {
        $user = User::where('phone', $request->phone)->count();

        if($user > 0){
            return response()->json(['message' => 'Already taken', 'status' =>false], 200);
        }else{
            return response()->json(['message' => 'Available to use', 'status' =>true], 201);
        }
    }

    public function web()
    {
    
      $privacy = PrivacyPolicy::first();
      $privacy->privacy_policy = json_decode($privacy->privacy_policy);
      return view('Privacy.web', compact('privacy'));
      
    }

    public function delete_account()
    {        
        return view('delete_account');
    }

}
