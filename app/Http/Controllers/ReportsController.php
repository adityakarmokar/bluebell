<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;

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
            'endDate' => 'nullable|date|after:startDate|required_with:startDate',
        ]);

        $status = $request->status ?? null;  
        $startDate = $request->startDate ?? null; 
        $endDate = $request->endDate ?? null;

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


        return view("reports", compact('data'));
    }


    public function user_ledger(User $user)
    {
        $user = $user->load('userLedger.userToken');        
        return view('user_ledger', compact('user'));
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
