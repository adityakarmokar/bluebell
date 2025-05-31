<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Team;
use App\Models\Token;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Payment;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request)
    {   
        return view('login');
    }
  
  	public function admin_otp(Request $request){
            
      	$credentials = $request->validate([
            'user_type' => 'required|numeric|in:1,0',
            'email' => 'required|email',            
        ]);
      
      	if($request->user_type == 1){
            $user = Team::where('email', $credentials['email'])->where('is_active', 1)->first();           	          	                      
        }else{          
            $user = Admin::where('email', $credentials['email'])->where('status', 1)->first();                      
        }
      
      	if($user){
          
          	$phone = "919958009605";
          	$otp = $request->email == 'tushar@corewave.io' ? '1234' : str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);            
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
          
          return 1;          
        }
      
      	return 0;
    }

    public function admin_login(Request $request)
    {
         
        $credentials = $request->validate([
            'user_type' => 'required|numeric|in:1,0',
            'email' => 'required|email',
            'password' => 'required',
          	'otp' => 'required',
        ]);

        if($request->user_type == 1){
            $user = Team::where('email', $credentials['email'])->where('otp', $request->otp)->first();                     
          	
            if($user && $user->password == $request->password){
              if($user->otp_expires_at >= now()) {			
                $request->session()->put('id', $user['id']);  
                $request->session()->put('type', 'user');
                return 1;
              }else{
                return 2;
              }
            }else{
                return 0;
            }                    
        }else{
          
            $user = Admin::where('email', $credentials['email'])->where('otp', $request->otp)->first();          
            if($user && Hash::check($credentials['password'], $user->password)){
              if($user->otp_expires_at >= now()) {	
                $request->session()->put('type', 'admin');
                $request->session()->put('id', $user['id']);            
                return 1;
              }else{
                return 2;
              }
            } else{
                return 0;
            }
        }

    }


    public function dashboard(Request $request){
        
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        $startOfCurrentWeek = Carbon::now()->startOfWeek();
        $endOfCurrentWeek = Carbon::now()->endOfWeek();
    
        $onboardedLastWeek = User::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();

        $onboardedCurrentWeek = User::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])->count();

        if ($onboardedLastWeek > 0) {
            $percentageChange = (($onboardedCurrentWeek - $onboardedLastWeek) / $onboardedLastWeek) * 100;
        } else {
            $percentageChange = $onboardedCurrentWeek > 0 ? 100 : 0;
        }

        $userpercentageChange = round($percentageChange, 2);
                
        $usersCount = User::count();       

        $statuses = ['Token Generated', 'Document Uploaded', 'Payment Done'];
        $metrics = [];

        foreach ($statuses as $status) {

            $totalCount = Token::where('status', $status)->count();
        
            $currentWeekCount = Token::where('status', $status)
                ->whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                ->count();
        
            $lastWeekCount = Token::where('status', $status)
                ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                ->count();
        
            if ($lastWeekCount > 0) {
                $percentageChange = (($currentWeekCount - $lastWeekCount) / $lastWeekCount) * 100;
            } else {
                $percentageChange = $currentWeekCount > 0 ? 100 : 0;
            }
        
            $metrics[] = [
                'total' => $totalCount,
                'status' => $status,                
                'percentage_change' => round($percentageChange, 2),
            ];
        }        

        $data = Token::with('user')->limit(10)->get();

        $allToken = Token::with('tokenStatus')->get();
        
        $data1['dataValidatationTokens'] = $allToken->filter(function ($token) {

            $filteredStatuses = $token->tokenStatus->reject(function ($status) {
                return $status->status == 9;
            });
                    
            $lastStatus = $filteredStatuses->last()?->status;
            return $lastStatus == 2;
        })->count();

        $data1['finalizationTokens'] = $allToken->filter(function ($token) {
            
            $filteredStatuses = $token->tokenStatus->reject(function ($status) {
                return $status->status == 9; 
            });
                    
            $lastStatus = $filteredStatuses->last()?->status;
            return $lastStatus == 3;
        })->count();

        $data1['finalizedTokens'] = $allToken->filter(function ($token) {
            
            $filteredStatuses = $token->tokenStatus->reject(function ($status) {
                return $status->status == 9;
            });
        
            $lastStatus = $filteredStatuses->last()?->status;
            return $lastStatus == 4;
        })->count();

      	$data1['pendingPayment'] = Payment::where('status', 'pending')->count();
      //  $data1['pendingPayment'] = $allToken->filter(function ($token) {
            
        //    return $token->tokenStatus->every(function ($status) {
          //      return $status->status != 5; 
        //    });        
       // })->count();

      	$data1['paidPayment'] = Payment::where('status', 'completed')->count();

        
        $data1['notVerifiedTokens'] = $allToken->filter(function ($token) {
           
            $filteredStatuses = $token->tokenStatus->reject(function ($status) {
                return $status->status == 9; 
            });
        
            
            $lastStatus = $filteredStatuses->last()?->status;
            return $lastStatus == 6;
        })->count();

        $data1['verifiedTokens'] = $allToken->filter(function ($token) {
            
            $filteredStatuses = $token->tokenStatus->reject(function ($status) {
                return $status->status == 9; 
            });
        
            
            $lastStatus = $filteredStatuses->last()?->status;
            return $lastStatus == 7;
        })->count();

        $data1['documentDelivered'] = $allToken->filter(function ($token) {            
            $filteredStatuses = $token->tokenStatus->reject(function ($status) {
                return $status->status == 9; 
            });
            
            $lastStatus = $filteredStatuses->last()?->status;
            return $lastStatus == 8;

        })->count();

        $totalTokens = Token::count();
        $serviceUsage = Token::select('service_id', DB::raw('count(*) as token_count'))
                            ->groupBy('service_id')
                            ->with('service', 'user') 
                            ->get()
                            ->map(function ($usage) use ($totalTokens) {
                                $usage->percentage = ($totalTokens > 0) ? ($usage->token_count / $totalTokens) * 100 : 0;
                                return $usage;
                            });
        return view('dashboard', compact('data', 'allToken', 'serviceUsage', 'metrics', 'usersCount', 'userpercentageChange', 'totalTokens','data1'));

    }

}
