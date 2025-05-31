@section('title', 'Payments - CA CRM')
@section('description', 'Payments - CA CRM')
@section('keywords', 'Payments - CA CRM')

@section('page_css')
<link rel="stylesheet" href="../../assets/vendor/css/pages/cards-advance.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/pickr/pickr-themes.css" />
@endsection

@section('manu', 'Payments')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

<style>
  .red25{
    border-radius: 15px !important;
  }
</style>

<div class="main-dashboard" id="main-dashboard">
  <div class="row g-4 mt-1 mb-5">
    <div class="col-sm-6 col-xl-4">
      <a href="{{url('payments')}}">
        <div class="card red25 k-success">
          <div class="card-body d-flex justify-content-center align-items-center" style="height: 150px;">
            <div class="justify-content-center text-center">            
                <span class="kh5">All Payments</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black"> {{ $data->count() }} </h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-sm-6 col-xl-4">
      <a href="{{url('payments?status=pending')}}">
        <div class="card k-red2 red25">
          <div class="card-body d-flex justify-content-center align-items-center" style="height: 150px;">
            <div class="justify-content-center text-center">            
                <span class="kh5">Pending Peyments</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black"> {{ $pending }} </h3>                              
                </div>                          
            </div>
          </div>
        </a>
      </div>
    </div>

    <div class="col-sm-6 col-xl-4">
      <a href="{{url('payments?status=completed')}}">
        <div class="card bg-success red25">
          <div class="card-body d-flex justify-content-center align-items-center" style="height: 150px;">
            <div class="justify-content-center text-center">            
                <span class="kh5">Completed Peyments</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black"> {{ $completed }}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>

  </div>
</div>

  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Payments</h5>        
      </div>      
      <form action="{{ url('payments') }}" method="GET">
        <div class="d-flex justify-content-start align-items-center row">  
          <div class="col-lg-4">
            <label for="custom_date">Date Range</label>
          	<div class="input-group input-daterange" id="bs-datepicker-daterange">
                <input type="text" id="dateRangePicker" placeholder="MM/DD/YYYY" name="startDate" class="form-control" value="{{ $startDate }}" readonly />
                <span class="input-group-text">to</span>
                <input type="text" id="endDate" name="endDate" placeholder="MM/DD/YYYY" value="{{ $endDate }}" class="form-control" readonly />
            </div>
          </div>
          
          <div class="col-lg-2 custom_date">
            <label for="custom_date">Custom Date</label>
            <input type="text" name="custom_date" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" value="{{ $custom_date }}" />                       
          </div>
          
          <div class="col-lg-2 custom_date">
            <label for="custom_date">Payment Type</label>
            <select class="form-control" name="payment_type" id="payment_type">
              <option value="">Choose One</option> 			  
              <option value="By Cash" {{ $payment_type == 'By Cash' ? 'selected' : '' }}>Cash</option>
              <option value="By UPI" {{ $payment_type == 'By UPI' ? 'selected' : '' }}>UPI</option>
              <option value="By Online" {{ $payment_type == 'By Online' ? 'selected' : '' }}>Online</option>
            </select>                                  
          </div>
          
          <div class="col-lg-3 submit_filter d-flex justify-content-start"> 
            <div>
              <label for=""> </label> 
              <button type="submit" class="btn btn-primary mt-3">Apply Filter</button>                           
            </div> 
            <div>
              <label for=""> </label> 
              <a href="{{ url('payments') }}" class="btn btn-secondary mt-3">Reset</a>              
            </div> 
          </div>                             
        </div>
      </form>
    </div>
    <div class="card-datatable text-nowrap" style="margin: auto 2%">
      <table class="table" id="usersTable">
        <thead class="border-top">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone No</th>
            <th>Date</th>            
            <th>Amount </th>
            <th>Token ID</th>
            <th>Transaction Id</th>  
            <th>Status</th>          
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $payment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ optional($payment->user)->fname. " ". optional($payment->user)->mname. " ". optional($payment->user)->lname }}</td>
                <td>{{ optional($payment->user)->phone }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->updated_at)->format('d M Y H:i:s')  }}</td>                
                <td>
                  ₹ {{ optional($payment->token)->consultency_fees }} 
                  <span class="badge rounded-pill bg-{{ $payment->payment_type == 'By Cash' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'primary') }} bg-glow">{{ $payment->payment_type == 'By Cash' ? 'Cash' : ($payment->status == 'pending' ? 'pending' : ($payment->payment_type == 'By UPI' ? 'UPI' : 'Online')) }}</span> 
                  <span class="badge rounded-pill bg-info bg-glow">{{ $payment->payment_method }}</span>
                
                </td>
                <td>
                  {{ optional($payment->token)->token ?? 'N/A' }}
                </td>
                <td>{{ $payment->payment_type == 'By Cash' ? 'Cash' : $payment->transaction_id }}</td>          
                <td>                  
                  <span class="badge bg-{{ 
                      $payment->status == 'completed' ? 'success' : 
                      ($payment->status == 'pending' ? 'warning' : 
                      ($payment->status == 'failed' ? 'danger' : 'secondary')) 
                  }}">{{ $payment->status }}</span>
                </td>  
              </tr>
            @endforeach
            
        </tbody>
      </table>
    </div>
  </div>
  
@section('page_js')
<script src="../../assets/js/app-ecommerce-product-list.js"></script>

<script src="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="/assets/vendor/libs/pickr/pickr.js"></script>
<script src="/assets/js/forms-pickers.js"></script>
@endsection
@include('layouts.footer')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#dateRangePicker", {
      dateFormat: "Y/m/d", // Format: MM/DD/YYYY
      allowInput: true,
      onChange: function(selectedDates, dateStr, instance) {
        let endDatePicker = document.querySelector("#endDate")._flatpickr;
        if (selectedDates.length > 0) {
          endDatePicker.set("minDate", selectedDates[0]); // Set minDate for end date
        }
      }
    });

    flatpickr("#endDate", {
      dateFormat: "Y/m/d",
      allowInput: true
    });
  });
  
  
</script>