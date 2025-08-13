@section('title', 'Ledger - CA CRM')
@section('description', 'Ledger - CA CRM')
@section('keywords', 'Ledger - CA CRM')

@section('page_css')

@endsection

@section('manu', 'Users')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

<style>
  .red25{
    border-radius: 15px !important;
  }
</style>

  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">{{ $user->fname." ".$user->mname." ".$user->lname }}'s   Ledger</h5>        
      </div>            
    </div>
    <div class="card-datatable text-nowrap" style="margin: auto 2%">
      <table class="table" id="usersTable">
        <thead class="border-top">
          <tr>
            <th>#</th>
            <th>Token</th>
            <th>Service</th>                       
            <th>Method</th>            
            <th>Amount</th>  
            <th>Date</th>          
          </tr>
        </thead>
        <tbody>
            @if (isset($ledger) && $ledger != null)                
                @foreach ($ledger as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ $payment->token->token ?? '' }} </td>
                    <td>{{ $payment->service->name ?? '' }}</td>                    
                    <td>{{ $payment->type ?? 'N/A' }}</td>                    
                    <td><span class="badge rounded-pill bg-success bg-glow">₹ {{ $payment->amount ?? $payment->status }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y')  }}</td>                                    
                </tr>
                @endforeach
            @endif
            
        </tbody>
      </table>
    </div>
  </div>
  
@section('page_js')
<script src="../../assets/js/app-ecommerce-product-list.js"></script>
@endsection
@include('layouts.footer')