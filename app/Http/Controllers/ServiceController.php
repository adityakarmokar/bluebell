<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceDocument;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    // Admin Handling function 
    public function index()
    {
        $data = Service::orderBy('id', 'DESC')->get();
        return view('services', compact('data'));
    }

    public function create()
    {
        return view('add_service');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'service_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:2048',
            'service_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:5048',
            'service_price' => 'nullable',
            'service_details' => 'nullable|string',
            'group-a' => 'required|array',             
        ]);
        
        $service = new Service();

        $service->name = $data['name'];
        $service->service_price = $data['service_price'];

        $service->service_details = $data['service_details'];
        if ($request->hasFile('service_icon')) {
            $image = $request->file('service_icon');
            $imageName = 'Service_' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/service'), $imageName);
            $service->service_icons = 'service/'. $imageName;
        }

        if ($request->hasFile('service_banner')) {
            $image = $request->file('service_banner');
            $imageName = 'Service_' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/service'), $imageName);
            $service->service_banner = 'service/'. $imageName;
        }
        $service->action_by = 'Admin';
        $service->status = 1;
        $service->save();

        foreach ($data['group-a'] as $serviceDoc) {
            $docIconPath = null;
        
            if (isset($serviceDoc['doc_icon']) && is_file($serviceDoc['doc_icon'])) {
                $image = $serviceDoc['doc_icon'];
                $imageName = 'Service_' . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/service'), $imageName);
                $docIconPath = 'service/' . $imageName;
            }
        
            ServiceDocument::create([
                'service_id' => $service->id,
                'doc_name' => $serviceDoc['doc_name'],
                'doc_icon' => $docIconPath, 
                'action_by' => 'Admin',
            ]);
        }        

        return redirect()->to('services')->with('success', 'Service details saved successfully');

    }

    public function toggle_service(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->status = !$service->status; 
        $service->save();

        return response()->json(['status' => $service->status, 'message' => 'Service status updated successfully.']);
    }

    public function fetch_service(Request $request, Service $service)
    {
        $data = $service->load('serviceDocuments');   
        return view('edit_service', compact('data'));
    }

    public function update(Request $request, Service $service)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'service_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:2048',
            'service_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:5048',
            'service_price' => 'nullable',
            'service_details' => 'nullable|string',
            'group-a' => 'required|array',             
        ]);

        $service->name = $data['name'];
        $service->service_price = $data['service_price'];
        
        $service->service_details = $data['service_details'];
        if ($request->hasFile('service_icon')) {
            $image = $request->file('service_icon');
            $imageName = 'Service_' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/service'), $imageName);
            $service->service_icons = 'service/'. $imageName;
        }

        if ($request->hasFile('service_banner')) {
            $image = $request->file('service_banner');
            $imageName = 'Service_' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/service'), $imageName);
            $service->service_banner = 'service/'. $imageName;
        }
        $service->action_by = 'Admin';
        $service->save();


        foreach ($data['group-a'] as $serviceDoc) {
            if(!empty($serviceDoc['doc_name'])){
                
                $docIconPath = null;

                if (isset($serviceDoc['doc_icon']) && $serviceDoc['doc_icon']->isValid()) {
                    $image = $serviceDoc['doc_icon'];
                    $imageName = 'Service_' . rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/service'), $imageName);
                    $docIconPath = 'service/' . $imageName;
                }else{
                    if(!empty($serviceDoc['doc_icon_hidden'])){
                        $docIconPath = $serviceDoc['doc_icon_hidden'];
                    }                    
                }

                $dataToUpdate = [                    
                    'service_id' => $service->id,
                    'doc_name' => $serviceDoc['doc_name'],
                    'action_by' => 'Admin',
                ];

                if ($docIconPath !== null) {
                    $dataToUpdate['doc_icon'] = $docIconPath;
                }

                if(isset($serviceDoc['doc_id'])){
                    ServiceDocument::updateOrCreate(
                        ['id' => $serviceDoc['doc_id']],
                        $dataToUpdate
                    );
                }else{
                    ServiceDocument::create(
                        $dataToUpdate
                    );
                }
                
            }
            
        }

        return redirect()->to('services')->with('success', 'Service details updated successfully');

    }

    public function destroy(Request $request)
    {
        $service = Service::find($request->user_id);

        if ($service) {
            $service->delete();
        }

        return redirect()->back();
    }



    // Api Handling functions

    public function service_list(Request $request)
    {
        $selfUser = auth()->user();
      	$search = $request->search ?? null;
      	
		$imageDomain = env('APP_URL').'uploads/';
        if(!$selfUser){
            return response()->json(['message' => 'You are not authenticated', 'status' =>false], 200);
        }

        $query = Service::where('status', 1);
      
      	if($search){
          $query->where('name', 'LIKE', "%$search%");
        }
      
      	$services = $query->orderBy('id', 'DESC')->get();

        if($services->isNotEmpty()){
			
          	$services->makeHidden(['created_at', 'updated_at']);

            return response()->json(['message' => 'success', 'status' =>true, 'imageDomain'=>$imageDomain, 'data'=>$services], 200);            
        }else{
            return response()->json(['message' => 'Services not found', 'status' =>false], 200);
        }
    }

    public function fetch_single_service(Request $request)
    {
        $service = Service::find($request->id);

		$imageDomain = env('APP_URL').'uploads/';
        if(!$service)
        {
            return response()->json(['status'=>false, 'message'=>'Service not found', 'data'=>[]]);
        }

      	$service->load('serviceDocuments:id,service_id,doc_icon,doc_name');
      	$service->makeHidden('updated_at', 'created_at', 'deleted_at', 'service_price', 'status', 'action_by');
        return response()->json(['status'=>true, 'message'=>'Service found', 'imageDomain'=>$imageDomain, 'data'=>$service]);
    }
}
