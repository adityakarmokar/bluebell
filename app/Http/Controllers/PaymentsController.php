<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentsController extends Controller
{
  
    public function index(Request $request)
    {
      //dd($request->all());
        $status = $request->status ?? null;
      	$custom_date = $request->custom_date ?? null;
        $startDate = $request->startDate ?? null;
        $endDate = $request->endDate ?? null; 
      	$payment_type = $request->payment_type ?? null; 
      
      	$pending = Payment::where('status', 'pending')->count();
      	$completed = Payment::where('status', 'completed')->count();

        $query = Payment::with('user', 'token');

        if(!empty($custom_date)){                            
            try {                                               
                $query = $query->whereDate('updated_at', $custom_date);   
              	$startDate = null;
              	$endDate = null;
              	
            } catch (\Exception $e) {
                
                return redirect()->back()->withErrors(['custom_date' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }else{  
          
          if(!empty($startDate) && !empty($endDate)){            
            
           	$query = $query->whereDate('updated_at', '>=', $startDate)
                			->whereDate('updated_at', '<=', $endDate);
          	$custom_date = null;       
          }                
        }

        if($status){
            $query = $query->where('status', $status);
        }

		if($payment_type){
            $query = $query->where('payment_type', $payment_type);
        }
      
      	$data = $query->orderBy('id', 'DESC')->get();          

        // $data = Payment::with('user')->orderBy('id', 'DESC')->get();
        return view('payments', compact('data', 'pending', 'completed', 'custom_date', 'startDate', 'endDate', 'payment_type'));
    }
  
  	public function index1(Request $request)
    {
        $status = $request->status ?? null;
        $custom_date = $request->custom_date ?? null;
        $startDate = $request->startDate ?? null;
        $endDate = $request->endDate ?? null;
        $payment_type = $request->payment_type ?? null;

        $pending = Payment::where('status', 'pending')->count();
        $completed = Payment::where('status', 'completed')->count();

        $query = Payment::with('user', 'token');

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function ($payment) {
                    return $payment->user ? $payment->user->fname . ' ' . $payment->user->mname . ' ' . $payment->user->lname : '';
                })
                ->addColumn('phone', function ($payment) {
                    return $payment->user ? $payment->user->phone : '';
                })
                ->editColumn('updated_at', function ($payment) {
                    return Carbon::parse($payment->updated_at)->format('Y-m-d H:i');
                })
                ->addColumn('amount', function ($payment) {
                    $amount = '₹ ' . ($payment->token->consultency_fees ?? 0);

                    // Badge for payment type and status
                    $badgeClass = $payment->payment_type === 'By Cash' ? 'success' :
                        ($payment->status === 'pending' ? 'warning' : 'primary');

                    $paymentTypeText = $payment->payment_type === 'By Cash' ? 'Cash' :
                        ($payment->payment_type === 'By UPI' ? 'UPI' : 'Online');

                    $badge = "<span class='badge rounded-pill bg-{$badgeClass} bg-glow'>{$paymentTypeText}</span>";

                    $methodBadge = "<span class='badge rounded-pill bg-info bg-glow'>{$payment->payment_method}</span>";

                    return $amount . ' ' . $badge . ' ' . $methodBadge;
                })
                ->addColumn('token', function ($payment) {
                    return $payment->token ? $payment->token->token : '';
                })
                ->editColumn('payment_type', function ($payment) {
                    return $payment->payment_type === 'By Cash' ? 'Cash' : $payment->transaction_id;
                })
                ->editColumn('status', function ($payment) {
                    $statusClass = match ($payment->status) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'secondary',
                    };

                    return "<span class='badge bg-{$statusClass}'>{$payment->status}</span>";
                })
                ->rawColumns(['status', 'payment_type', 'amount'])
                ->make(true);
        }

        return view('payments', compact('pending', 'completed', 'custom_date', 'startDate', 'endDate', 'payment_type'));
    }

  
}
