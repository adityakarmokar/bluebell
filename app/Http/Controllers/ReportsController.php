<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'startDate' => 'nullable|date|required_with:endDate',
            'endDate' => 'nullable|date|required_with:startDate',
        ]);

        $status = $request->status ?? null;  
        $startDate = Carbon::parse($request->startDate)->startOfDay();
        $endDate = Carbon::parse($request->endDate)->endOfDay();

        $data = null;
        if($startDate && $endDate){
            
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

            $query->whereBetween('created_at', [$startDate, $endDate]);
            $data = $query->orderBy('id', 'ASC')->get();           
        }            

      //dd($data);

        return view("reports", compact('data'));
    }


    public function user_ledger(User $user)
    {
        $user = $user->load('userLedger.userToken');  
      	
      	$ledger = PaymentHistory::where('user_id', $user->id)->with('token:id,token', 'service')->orderBy('id', 'desc')->get();
      
        return view('user_ledger', compact('ledger', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
