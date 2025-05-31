<?php

namespace App\Http\Controllers;
use App\Models\Token;
use App\Models\Service;
use App\Models\User;
use App\Models\TokenDocument;
use App\Models\TokenStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Payment;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        
        $status = $request->status ?? null;  
        $date = $request->date ?? null;      

        $query = Token::with('service', 'user', 'tokenStatus');

        if($status){
            $query->whereHas('tokenStatus', function ($q) use ($status) {
                $q->where('status', $status)
                ->whereIn('id', function ($subquery) {
                    $subquery->selectRaw('MAX(id)')
                             ->from('token_statuses')
                             ->groupBy('token_id');
                });
            });            
        }

        if($date){
            $query->whereDate('created_at', $date);
        }

        // $data = $query->orderBy('id', 'ASC')->get();  
        
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn() 
                ->addColumn('full_name', function($token){
                    return $token->user ? $token->user->fname . ' ' . $token->user->mname . ' ' . $token->user->lname : '';
                })
                ->editColumn('token', function($token){

                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status;
                    });                    

                    if (in_array(5, $filteredStatuses)){
                        return "$token->token <span class='badge rounded-pill bg-success bg-glow'>Paid</span>";                    
                    }else{
                        return $token->token;                    
                    }
                })
                ->editColumn('status', function ($token) {
                    // Logic to fetch the latest non-status-5 and display status
                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";
                    });
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
    
                    // Map the filtered status to the badge
                    return $this->getStatusBadge($filteredLastStatus);
                })                
                ->addColumn('actions', function($token){

                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";
                    });
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
                    
                    $actions = '<div class="d-flex">';
                  
                  	if(session('type') !== 'user'){
                    	$actions .= '<a href="' . route('view.token', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> |
                                <a href="javascript:void(0);" onclick="myFunction(' . $token->id . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> |';  
                    }else{
                      $actions .= '<a href="' . route('view.token', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a>';
                    }

                    

                    if($token->status == 'Token Generated'){
                        $actions .= '<a href="' . route('token.upload_document', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Upload Documents"><i class="ti ti-clipboard me-1"></i></a> |';

                    }  
                    if($token->status == 'Document Uploaded'){
                        $actions .= '<a href="' . route('token.upload_document_edit', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit Uploaded Documents"><i class="ti ti-certificate me-1"></i></a> |';
                    }                                
                            
                    if ($filteredLastStatus != 8) {
                        $actions .= '<div class="form-check-success">
                                        <a data-bs-toggle="modal" data-bs-target="#tokenStatusChangeModal" onclick="change_token_status_modal(' . $token->id . ', \'' . $token->token . '\', \'' . optional($token->service)->name . '\')">
                                            <i class="ti ti-progress-check me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Change Status"></i>
                                        </a> 
                                    </div>';
                    } else {                    
                        $actions .= '<div class="form-check-success">
                                        <i class="ti ti-square-check" style="color: var(--bs-success)"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Status:- Document Delivered"></i>                                           
                                    </div>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['token', 'status', 'actions'])
                ->make(true); 
        }
        
        return view('tokens');
    }

    private function getStatusBadge($status)
    {
        switch ($status) {
            case 1:
                return '<span class="badge badge-dot border border-2 p-2" style="background-color: #6d99d639"></span>&nbsp; Token Generated';
            case 2:
                return '<span class="badge badge-dot border border-2 p-2" style="background-color: #a5d8e4;"></span>&nbsp; Data Validated';
            case 3:
                return '<span class="badge badge-dot border border-2 p-2" style="background-color: #a5d8e4;"></span>&nbsp; Return Not Filed / Not Finalized';
            case 4:
                return '<span class="badge badge-dot border border-2 p-2" style="background-color: #0558e876;"></span>&nbsp; Return Not Filed / Finalized';
            case 5:
                return '<span class="badge badge-dot border border-2 p-2 bg-success"></span>&nbsp; Payments Completed / Ready to file';
            case 6:
                return '<span class="badge badge-dot border border-2 p-2" style="background-color: #fee3d1;"></span>&nbsp; Returns Filed - Not Verified';
            case 7:
                return '<span class="badge badge-dot border border-2 p-2" style="background-color: #c8f1b5;"></span>&nbsp; Return Filed -Verified';
            case 8:
                return '<span class="badge badge-dot border border-2 p-2 bg-primary"></span>&nbsp; Document Delivered';
            default:
                return '<span class="badge badge-dot border border-2 p-2 bg-danger" style="background-color: red;"></span>&nbsp; Unknown Status';
        }
    }

    public function pending_payment(Request $request)
    {
        $query = Token::with('service', 'user', 'payment', 'tokenStatus');
    
      	$query->whereHas('payment', function($q){
          $q->where('status', 'pending'); 
        });                 	
      
        //$data = $query->orderBy('id', 'DESC')->get();   
      
      	if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn() 
                ->addColumn('full_name', function($token){
                    return $token->user ? $token->user->fname . ' ' . $token->user->mname . ' ' . $token->user->lname : '';
                })
                ->editColumn('token', function($token){                    
                	return "$token->token <span class='badge rounded-pill bg-warning bg-glow'>pending</span>";                                        
                })
                ->editColumn('status', function ($token) {
                    // Logic to fetch the latest non-status-5 and display status
                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";
                    });
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
    
                    // Map the filtered status to the badge
                    return $this->getStatusBadge($filteredLastStatus);
                })                
                ->addColumn('actions', function($token){

                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";
                    });
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
                    
                    $actions = '<div class="d-flex">';
                  
                  	if(session('type') !== 'user'){
                    	$actions .= '<a href="' . route('view.token', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> |
                                <a href="javascript:void(0);" onclick="myFunction(' . $token->id . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> |';  
                    }else{
                      $actions .= '<a href="' . route('view.token', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a>';
                    }

                    

                    if($token->status == 'Token Generated'){
                        $actions .= '<a href="' . route('token.upload_document', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Upload Documents"><i class="ti ti-clipboard me-1"></i></a> |';

                    }  
                    if($token->status == 'Document Uploaded'){
                        $actions .= '<a href="' . route('token.upload_document_edit', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit Uploaded Documents"><i class="ti ti-certificate me-1"></i></a> |';
                    }                                
                            
                    if ($filteredLastStatus != 8) {
                        $actions .= '<div class="form-check-success">
                                        <a data-bs-toggle="modal" data-bs-target="#tokenStatusChangeModal" onclick="change_token_status_modal(' . $token->id . ', \'' . $token->token . '\', \'' . optional($token->service)->name . '\')">
                                            <i class="ti ti-progress-check me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Change Status"></i>
                                        </a> 
                                    </div>';
                    } else {                    
                        $actions .= '<div class="form-check-success">
                                        <i class="ti ti-square-check" style="color: var(--bs-success)"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Status:- Document Delivered"></i>                                           
                                    </div>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['token', 'status', 'actions'])
                ->make(true); 
        }

        return view('token_pending');
    }

    public function paid_payment(Request $request)
    {      
        $query = Token::with('service', 'user', 'tokenStatus', 'payment');
    
        $query->whereHas('payment', function($q){
          $q->where('status', 'completed'); 
        }); 

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn() 
                ->addColumn('full_name', function($token){
                    return $token->user ? $token->user->fname . ' ' . $token->user->mname . ' ' . $token->user->lname : '';
                })
                ->editColumn('token', function($token){                    
                   return "$token->token <span class='badge rounded-pill bg-success bg-glow'>Paid</span>";                                        
                })
                ->editColumn('status', function ($token) {
                    // Logic to fetch the latest non-status-5 and display status
                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";
                    });
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
    
                    // Map the filtered status to the badge
                    return $this->getStatusBadge($filteredLastStatus);
                })                
                ->addColumn('actions', function($token){

                    $token_statuses = $token->tokenStatus->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";
                    });
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
                    
                    $actions = '<div class="d-flex">';
                  
                  	if(session('type') !== 'user'){
                    	$actions .= '<a href="' . route('view.token', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> |
                                <a href="javascript:void(0);" onclick="myFunction(' . $token->id . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> |';  
                    }else{
                      $actions .= '<a href="' . route('view.token', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a>';
                    }

                    

                    if($token->status == 'Token Generated'){
                        $actions .= '<a href="' . route('token.upload_document', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Upload Documents"><i class="ti ti-clipboard me-1"></i></a> |';

                    }  
                    if($token->status == 'Document Uploaded'){
                        $actions .= '<a href="' . route('token.upload_document_edit', ['token' => $token]) . '" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit Uploaded Documents"><i class="ti ti-certificate me-1"></i></a> |';
                    }                                
                            
                    if ($filteredLastStatus != 8) {
                        $actions .= '<div class="form-check-success">
                                        <a data-bs-toggle="modal" data-bs-target="#tokenStatusChangeModal" onclick="change_token_status_modal(' . $token->id . ', \'' . $token->token . '\', \'' . optional($token->service)->name . '\')">
                                            <i class="ti ti-progress-check me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Change Status"></i>
                                        </a> 
                                    </div>';
                    } else {                    
                        $actions .= '<div class="form-check-success">
                                        <i class="ti ti-square-check" style="color: var(--bs-success)"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Status:- Document Delivered"></i>                                           
                                    </div>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['token', 'status', 'actions'])
                ->make(true); 
        }


        return view('token_paid');
    }

    public function inacitive_token()
    {
        $data = Token::where('is_active', 0)->get();
        return view('tokens', compact('data'));
    }

    public function create(Request $request)
    {
        $selectedUserId = null;
        $selectedUserId = $request->query('user');
        $services = Service::orderBy('id', 'DESC')->get();
        $users = User::orderBy('id', 'DESC')->get();
        return view('add_token', compact('services', 'users', 'selectedUserId'));
    }
    
    public function generate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'user' => 'required|integer',
            'service' => 'required|integer',
        ]);

        $service_id = null;
        $user_id = null;
        $initials = null;
        $date = now()->format('mdY');
        $fix_number = '0515';
        $service = Service::where('id', $request->service)->first();
        if($service){
            $service_id = $service->id;

            $initials = implode('', array_map(function ($word) {
                return strtoupper($word[0]);
            }, explode(' ', $service->name)));
        }

        $user = User::where('id', $request->user)->first();
        if($user){
            $user_id = $user->id;
        }

        $token = new Token();
        $token->service_id = $service_id;
        $token->user_id = $user_id;
        $token->status = 'Token Generated';
        $token->action_by = 'Admin';
        $token->save();

        TokenStatus::create([
            'token_id'=>$token->id,
            'status'=>1,
        ]);

        $token_id = "{$initials}{$date}{$token->id}";
        Token::where('id', $token->id)->update(['token'=>$token_id]);

        if(isset($token->id) && $token->id != null){
            return redirect()->route('token.upload_document', ['token'=>$token])->with('success', 'Token Generated Successfully');
        }else{
            return redirect()->back()->with('error', 'There is something error');
        }

    }

    public function save_filed_document(Request $request)
    {
        
        $request->validate([
            'token_id' => 'required|exists:tokens,id',            
        ]);

        $token_document = Token::where('id', $request->token_id)->first();

        if ($request->image != null && $request->has('image')) {            
            $base64Image = $request->input('image');
            $extension = explode('/', mime_content_type($base64Image))[1];
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $imageName = 'filed' . time() . '.' . $extension;
            $imagePath = public_path('uploads/user_document/' . $imageName);
            file_put_contents($imagePath, $decodedImage);
            $token_document->filed_document = 'user_document/' . $imageName;
        }

        if($token_document->save()){
            return redirect()->back()->with('success', 'Document uploaded successfully');
        }else{
            return redirect()->back()->with('error', 'Document not uploaded');
        }

    }

    public function toggle_token(Request $request, $id)
    {
        $token = Token::findOrFail($id);
        $token->is_active = !$token->is_active; 
        $token->save();

        return response()->json(['status' => $token->is_active, 'message' => 'Service status updated successfully.']);
    }

    public function view_document_upload(Request $request, Token $token)
    {
        $token = $token->load('service.serviceDocuments');
        return view('token_document_upload', ['data'=>$token]);
    }

    public function upload_document(Request $request, Token $token)
    {
        // dd($request->all());
        $token = $token->load('service.serviceDocuments');
        
        $request->validate([
            'doc_type' => 'required|string|in:salaried,business',            
            'form_16_a.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',            
            'annex_use.*' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',            
            'form_16_parantal.*' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',            
            'inv_lic_mf.*' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',
            'intrest_certificate' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',            
            'public_investment.*' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:5048',            
            'bank_statement.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',
            'sales_purchase.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048',
            'comment' => 'nullable|string',            
        ]);

        $additionalDocument = [];
        $validationRules = [];

        if (!empty($token->service->serviceDocuments)) {
            foreach ($token->service->serviceDocuments as $serviceItem) {
                $validationRules[$serviceItem->doc_name . '.*'] = 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp,svg|max:50048';
                $additionalDocument[] = $serviceItem->doc_name;
            }
        }

        $request->validate($validationRules);
        
        // Initialize document data array
        $documentData = [];

        // Handle multiple file fields
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

        // dd($documentData);

        $tokenDocument  = TokenDocument::create(
            array_merge($documentData, 
            [
                'service_id'=>$token->service_id, 
                'year' => now()->format('Y'),
                'user_id'=>$token->user_id, 
                'token_id'=>$token->id, 
                'doc_type'=>$request->doc_type, 
                'action_by'=>'Admin', 
                'comment'=>$request->comment,
            ]
        ));

        $token->update([
            'status'=>'Document Uploaded',
        ]);
        
        return redirect()->to('tokens')->with('success', 'Documents Uploaded successfully');

    }

    public function edit_document_upload(Request $request, Token $token)
    {
        $token = $token->load('service.serviceDocuments','tokenDocument');
        return view('edit_token_uplod', ['data'=>$token]);
    }

    public function edit_document_upload_submit(Request $request, Token $token)
    {
        $token = $token->load('service.serviceDocuments', 'tokenDocument');
        // dd($token);

        $additionalDocument = [];
        $validationRules = [];

        if (!empty($token->service->serviceDocuments)) {
            foreach ($token->service->serviceDocuments as $serviceItem) {
                $validationRules[$serviceItem->doc_name . '.*'] = 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,avif,webp|max:50048';
                $additionalDocument[] = $serviceItem->doc_name;
            }
        }

        // $request->validate($validationRules);
        
        // Initialize document data array
        $documentData = [];

        // Handle multiple file fields
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

        // dd($documentData);

        $tokenDocument  = TokenDocument::updateOrCreate(
            ['id' => $token->tokenDocument->id],
            array_merge($documentData, 
            [                                
                'doc_type'=>$request->doc_type,                 
                'comment'=>$request->comment,
            ]
        ));

        $token->update([
            'status'=>'Document Edited',
        ]);
        
        return redirect()->to('tokens')->with('success', 'Documents Updated successfully');

    }

    public function destroy(Request $request)
    {
        $token = Token::find($request->user_id);

        if($token){
            $token->delete();
        }

        if(isset($request->page) && $request->page == 'view_token'){
            return redirect()->to('tokens')->with('success', 'Token has been deleted successfully');
        }

        return redirect()->to('tokens')->with('success', 'Token has been deleted successfully');

    }

    public function confirm_payment(Request $request, Token $token)
    {
        $status = TokenStatus::where('token_id', $token->id)->where('status', 5)->first();
        return view('token_payment', compact('token', 'status'));
    }

    public function payment_done(Request $request, Token $token)
    {
        // dd($request->all());
        if($request->payment_status == 1){
            TokenStatus::create([
                'token_id'=>$token->id,
                'status'=>5,
            ]);
            return redirect()->route('token.confirm_payment', ['token'=>$token])->with('success', 'Payment Status Changed');
        }else{
            $status = TokenStatus::where('token_id', $token->id)->where('status', 5)->first();
            $status->delete();

            return redirect()->route('token.confirm_payment', ['token'=>$token])->with('error', 'Payment Status Changed');
        }
        
    }

    public function change_payment_status(Request $request)
    {
        
        if(!$request->payment_status){
            return redirect()->back();
        }

        $request->validate([
            'token_id' => 'required|integer|exists:tokens,id',             
        ]);

        $token = Token::find($request->token_id);
        if($request->payment_status == 1){
            TokenStatus::create([
                'token_id'=>$token->id,
                'status'=>5,
            ]);
          
          	$isPaid = Payment::where('token_id', $request->token_id)->where('user_id', $token->user_id)->first();
          	$amount = $request->consultency ?? 0;
          
          	if($isPaid){
              $isPaid->update([
                'payment_type' => 'By Cash',
                'transaction_id' => 'Cash',
                'currency' => 'INR',
                'amount' => $amount,
                'status' => 'completed',              
              ]);
            }else{
               Payment::create([
                'token_id' => $request->token_id,
                'user_id' => $token->user_id,
                'payment_type' => 'By Cash',
                'transaction_id' => 'Cash',
                'currency' => 'INR',
                'amount' => $amount,
                'status' => 'completed',              
              ]); 
            }          	

            $token->update([
                'payment' => 'Cash',
            ]);
          
          	$user = User::where('id', $token->user_id)->first();
          
          	$phone = "91".$user->phone;
          	$template_id = "682ee0c2d6fc0518190e2572";
            $authkey = "453025Azs5VZhDaFf682db06dP1";                                
            $data = [
              "template_id" => $template_id,
              "recipients" => [
                [
                  "mobiles" => (string)$phone,                  
                ]
              ]
            ];

            $payload = json_encode($data);
            \Log::debug('payload', ['payload' => $data]); 
            
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
              \Log::debug('Payment', ['error' => $error]);                    
            } else {
              \Log::debug('Payment', ['success' => $response, 'http'=>$http_code]);                    
            }

            return redirect()->back()->with('success', 'Payment Status Changed');
        }

    }

	public function change_payment_status_upi(Request $request)
    {
        
        if(!$request->payment_status){
            return redirect()->back();
        }

        $request->validate([
            'token_id' => 'required|integer|exists:tokens,id',             
        ]);

        $token = Token::find($request->token_id);
        if($request->payment_status == 1){
            TokenStatus::create([
                'token_id'=>$token->id,
                'status'=>5,
            ]);
          
          	$isPaid = Payment::where('token_id', $request->token_id)->where('user_id', $token->user_id)->first();
          	$amount = $request->consultency ?? 0;
          
          	if($isPaid){
              	$isPaid->update([                  
                  'payment_type' => 'By UPI',
                  'transaction_id' => 'UPI',
                  'currency' => 'INR',
                  'amount' => $amount,
                  'status' => 'completed',              
                ]);
              	  
            }else{
             	
                Payment::create([
                  'token_id' => $request->token_id,
                  'user_id' => $token->user_id,
                  'payment_type' => 'By UPI',
                  'transaction_id' => 'UPI',
                  'currency' => 'INR',
                  'amount' => $amount,
                  'status' => 'completed',              
                ]); 
            }          	

            $token->update([
                'payment' => 'UPI',
            ]);
          
			$user = User::where('id', $token->user_id)->first();
          
          	$phone = "91".$user->phone;
          	$template_id = "682ee0c2d6fc0518190e2572";
            $authkey = "453025Azs5VZhDaFf682db06dP1";                                
            $data = [
              "template_id" => $template_id,
              "recipients" => [
                [
                  "mobiles" => (string)$phone,                  
                ]
              ]
            ];

            $payload = json_encode($data);
            \Log::debug('payload', ['payload' => $data]); 
            
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
              \Log::debug('Payment', ['error' => $error]);                    
            } else {
              \Log::debug('Payment', ['success' => $response, 'http'=>$http_code]);                    
            }          	

            return redirect()->back()->with('success', 'Payment Status Changed');
        }

    }

    public function view_token(Request $request, Token $token)
    {
        $token->load('user.ca_tokens', 'user.userBankAccountDetail', 'tokenDocument', 'service');

        $statusRecords = TokenStatus::where('token_id', $token->id)->get();

        $statuses = $statusRecords->pluck('status')->toArray();        

        return view('view_token', compact('token', 'statuses', 'statusRecords'));
    }

    public function change_status_token(Request $request)
    {
        
        $validatedData = $request->validate([
            'token' => 'required|integer|exists:tokens,id', 
            'status' => 'required|integer|in:1,2,3,4,5,6,7,8',            
        ]);

        $tokenId = $validatedData['token'];
        $status = $validatedData['status'];

        $token = Token::findOrFail($tokenId);
        // $tokenDocument = TokenDocument::where('token_id', $tokenId)->first();
        $tokenDocument = $token->filed_document;

        if($status != 8){
            
            $isCreated = TokenStatus::create([
                'token_id' => $token->id,
                'status' => $status,                    
            ]);
            
            $token->update([                
                'refund_amount' => $request->refund ?? null,
                'payable_amount' => $request->payable ?? null,
                'consultency_fees' => $request->consultency ?? null,
            ]);
          
			$refund = $request->refund ?? 0;
            $payable = $request->payable ?? 0;
            $consultency = $request->consultency ?? 0;
          
          	if($refund > 0 || $payable > 0 || $consultency > 0){
              
              $isPaid = Payment::where('token_id', $tokenId)->where('user_id', $token->user_id)->first();
              $amount = $request->consultency ?? 0;
              
              if($isPaid){
              	$isPaid->update([
                  'currency' => 'INR',
                  'amount' => $amount,
                  'status' => 'pending',              
                ]);
                
              }else{
                Payment::create([
                  'token_id' => $tokenId,
                  'user_id' => $token->user_id,
                  'currency' => 'INR',
                  'amount' => $amount,
                  'status' => 'pending',              
                ]);  
              }
                            
            }                    	
    
            if($isCreated){
                return response()->json(['status'=>true, 'message' => 'Token status updated successfully.']);
            }else{
                return response()->json(['status'=>false, 'message' => 'Failed.']);
            }

        }else{
            if ($tokenDocument != null) {
                
                // if($tokenDocument->doc_type == 'salaried'){
                //     $excludeColumns = ['form_16_a', 'bank_statement', 'sales_purchase', 'additional_documents', 'comment', 'action_by', 'deleted_at', 'created_at', 'updated_at'];    
                // }else{
                //     $excludeColumns = ['additional_documents', 'comment', 'action_by', 'deleted_at', 'created_at', 'updated_at'];
                // } 
                
                // $isAllNotNull = true;
                // foreach ($tokenDocument->getAttributes() as $column => $value) {
                //     if (!in_array($column, $excludeColumns) && $value === null) {
                //         $isAllNotNull = false;
                //         break;
                //     }
                // }
            
                if ($token->filed_document != null) {
                    
                    // All columns have values
                    $isCreated = TokenStatus::create([
                        'token_id' => $token->id,
                        'status' => $status,
                    ]);
            
                    if($isCreated){
                        return response()->json(['status'=>true, 'message' => 'Token status updated successfully.']);
                    }else{
                        return response()->json(['status'=>false, 'message' => 'Failed.']);
                    }
                    
                } else {
                    // Some columns are null
                    return response()->json(['status'=>false, 'message' => 'Filed Documents not uploaded!']);
                }
            } else {
                return response()->json(['status'=>false, 'message' => 'Documents are not uploaded!']);
            }
        }        
        
    }

    public function view_token_details(Request $request)
    {
        $selfUser = auth()->user();
        $request->validate([
            'token_id' => 'required|integer|exists:tokens,id'
        ]);

        $token = Token::find($request->token_id);
        if(!$token){
            return response()->json(['status'=>false, 'message' => 'Token not found.']);
        }

      	$imageDomain = env('APP_URL').'uploads/';
        $token->load('service','tokenDocument', 'tokenStatus');

        if($token->tokenDocument){
            $token->tokenDocument->form_16_a = json_decode($token->tokenDocument->form_16_a);
            $token->tokenDocument->annex_use = json_decode($token->tokenDocument->annex_use);
            $token->tokenDocument->form_16_parantal = json_decode($token->tokenDocument->form_16_parantal);
            $token->tokenDocument->inv_lic_mf = json_decode($token->tokenDocument->inv_lic_mf);
            $token->tokenDocument->intrest_certificate = json_decode($token->tokenDocument->intrest_certificate);
            $token->tokenDocument->public_investment = json_decode($token->tokenDocument->public_investment);
            $token->tokenDocument->bank_statement = json_decode($token->tokenDocument->bank_statement);
            $token->tokenDocument->sales_purchase = json_decode($token->tokenDocument->sales_purchase);
            $token->tokenDocument->additional_documents = json_decode($token->tokenDocument->additional_documents);
        }

        return response()->json(['status'=>true, 'message' => 'Success', 'imageDomain'=>$imageDomain, 'data'=>$token]);

    }

    public function check_status_token(Request $request)
    {        
        $request->validate([
            'id' => 'required|integer|exists:tokens,id'
        ]);

        $token = Token::find($request->id);
        if(!$token){
            return response()->json(['status'=>false, 'message' => 'Token not found.']);
        }

        $token->load('tokenStatus');

        if($token)
        {
            if($token->tokenStatus){
                $token->tokenStatus = $token->tokenStatus->filter(fn($status) => $status->status != 5)->values();                
            }
            return response()->json(['status'=>true, 'message'=>'Success', 'data'=>$token->tokenStatus]);
        }

        return response()->json(['status'=>false, 'message'=>'Failed', 'data'=>[]]);
    }

}
