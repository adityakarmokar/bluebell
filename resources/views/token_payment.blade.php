@section('title', 'Tokens')
@section('description', 'Tokens description')
@section('keywords', 'Tokens')
@section('manu', 'Tokens')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  


<div class="col-lg-12">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="mb-2">Payement Status</h5>
        <p class="mb-4">Admin can change payment status.</p>
        <div class="d-flex flex-sm-row text-center" style="padding: 2rem;">
            @if ($status != null)                
                <div class="d-flex align-items-center">
                    <span><i class='ti ti-mood-smile-beam text-success ti-xl p-3 border border-1 border-success rounded-circle border-dashed mb-0' style="font-size: 200px !important;"></i></span>                      
                </div> 
            @else
                <div class="d-flex align-items-center">
                    <span><i class='ti ti-mood-cry text-danger ti-xl p-3 border border-1 border-danger rounded-circle border-dashed mb-0' style="font-size: 200px !important;"></i></span>                      
                </div> 
            @endif                              
        </div>
        <div class="d-flex text-center">
            @if ($status != null)                
                <h5>Horray! Payement Completed</h5>
            @else
                <h5>Ohh! Payement Pending</h5>
            @endif
        </div>
        <br>
        <hr>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <h5>Payment &nbsp;&nbsp;<span class="badge bg-{{$status != null ? 'success' : 'danger' }}">{{$status != null ? 'Completed' : 'Not Paid' }}</span></h5>
            </div>            
            <form action="{{route('token.payment_done', ['token'=>$token])}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-4">                                                                        
                        <select id="payment-status" class="select2 form-select" name="payment_status" data-allow-clear="true">                        
                            <option value="0">Pending</option>
                            <option value="1" {{$status != null ? 'selected' : '' }}>Paid</option>                            
                        </select>                        
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>                
            </form>                           
        </div>
        <br>
        <br>
      </div>
    </div>
</div>


@include('layouts.footer')