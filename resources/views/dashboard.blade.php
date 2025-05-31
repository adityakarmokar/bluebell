@section('title', 'Dashboard-CA CRM')
@section('description', 'Dashboard-CA CRM')
@section('keywords', 'Dashboard-CA CRM')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')      

<style>
  .purp-color{
    background-color: #7539FF;
    color: white;
  }
  .green-color-this{
    background-color: #28C76F;
    color: white;
  }

  .bg-label-success {
    background-color: #198754 !important;
    color: white !important;
  }

  .bg-label-primary {
    background-color: #212529 !important;
    color: white !important;
  }

  .bg-label-warning {
    background-color: #BE2E3C !important;
    color: white !important;
  }

  .red25{
    border-radius: 15px !important;
  }
  

</style>

@if (session('type') != 'admin')
  @php
      $userPermission = App\Models\Permission::where('team_id', session('id'))->select('dashboard2')->first();
      $dashboardPermission = $userPermission->dashboard2 == 1 ? 1 : 0;
  @endphp
@else
  @php
      $dashboardPermission = 1;
  @endphp
@endif

<div id="switch-button" class="d-flex mb-3 justify-content-end">
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
      <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked="">
      <label class="btn btn-outline-primary waves-effect" for="btnradio1">Dashboard 1</label>
      @if ($dashboardPermission == 1)    
      {{-- <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
      <label class="btn btn-outline-primary waves-effect" for="btnradio2">Dashboard 2</label> --}}
      @endif
    </div>
</div>


<div class="main-dashboard" id="main-dashboard">

  {{-- Last work --}}
  {{-- <div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="card purp-color red25">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Total Users</span>
              <div class="d-flex align-items-center my-2">
                <h3 class="mb-0 me-2 text-white">{{$usersCount}}</h3>              
                @if ($userpercentageChange > 0)
                    <span style="color: white;">↑ {{ $userpercentageChange }}%</span>
                @elseif ($userpercentageChange <= 0)
                    <span style="color: white;">↓ {{ abs($userpercentageChange) }}%</span>
                @endif
              </div>
              <p class="mb-0">Last week analytics</p>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="ti ti-user ti-sm"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    @php
        $icons = ['clipboard', 'file-alert', 'file-like'];
        $colors = ['bg-label-success', 'bg-label-primary', 'bg-label-warning']; 
        $i = 0;
    @endphp
    @foreach ($metrics as $status => $data21)
      @php
          $value2 = $icons[$i];
          $color = $colors[$i % count($colors)];
      @endphp
      <div class="col-sm-6 col-xl-3">
        <div class="card red25 {{ $color }}">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>{{ $data21['status'] }}</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 text-white">{{ $data21['total']}}</h3>
                  @if ($data21['percentage_change'] > 0)
                      <span style="color: green;">↑ {{ $data21['percentage_change'] }}%</span>
                  @elseif ($data21['percentage_change'] <= 0)
                      <span style="color: red;">↓ {{ abs($data21['percentage_change']) }}%</span>
                  @endif
                </div>
                <p class="mb-0">Last week analytics </p>
              </div>
              <div class="avatar">
                <span class="avatar-initial rounded bg-label-success">
                  <i class="ti ti-{{$value2}} ti-sm"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @php
          $i++;
      @endphp
    @endforeach  
  </div> --}}
  {{-- end last work --}}

  <div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('users')}}">
        <div class="card red25 k-element-primary">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Total No. of Clients</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$usersCount}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens')}}">
        <div class="card k-orange2 red25">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Tokens Generated</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$allToken->count()}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens?status=2')}}">
        <div class="card red25 k-success">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Return Data Validation</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['dataValidatationTokens']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens?status=3')}}">
      <div class="card red25 k-black2">
        <div class="card-body">
          <div class="justify-content-center text-center">            
              <span class="kh5">Return Not Filled / Not Finalised</span>
              <div class="d-flex align-items-center my-2">
                <h3 class="mb-0 me-2 k-text-black">{{$data1['finalizationTokens']}}</h3>                              
              </div>                          
          </div>
        </div>
      </div>
      </a>
    </div>    
  </div>

  <div class="row g-4 mb-4">  
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens?status=4')}}">
        <div class="card red25 k-blue2">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Return Not Filled/Finalised</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['finalizedTokens']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>   
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('pending-payment-token')}}">
        <div class="card  k-red2 red25">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Payments Pending</span>              
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['pendingPayment']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('paid-payment-token')}}">
        <div class="card bg-success red25">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Payments Completed <br>
                  Ready to File
                </span>              
                <div class="d-flex align-items-center">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['paidPayment']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens?status=6')}}">
        <div class="card k-success2 red25">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Return Filled - Not Verified</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['notVerifiedTokens']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens?status=7')}}">
        <div class="card k-error2 red25">
          <div class="card-body">
            <div class="justify-content-center text-center">            
                <span class="kh5">Return Filled - Verified</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['verifiedTokens']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-xl-3">
      <a href="{{url('tokens?status=8')}}">
        <div class="card red25" style="background-color: rgb(8 179 199) !important">
          <div class="card-body" style="">
            <div class="justify-content-center text-center">            
                <span class="kh5">Documents Delivered</span>
                <div class="d-flex align-items-center my-2">
                  <h3 class="mb-0 me-2 k-text-black">{{$data1['documentDelivered']}}</h3>                              
                </div>                          
            </div>
          </div>
        </div>
      </a>
    </div> 
  </div>
  
  <div class="row">
  
    <!-- donut token chart -->
    {{-- <div class="col-md-6 col-xxl-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Tokens</h5>
          </div>        
        </div>
        <div class="card-body">
          <div id="piPercentageChart" class="pt-md-4"></div>
        </div>
      </div>
    </div> --}}
    <!--/ Reasons for delivery exceptions -->
  
    <!-- Earning Reports -->
    {{-- <div class="col-xl-4 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Earning Reports</h5>
            <small class="text-muted">Weekly Earnings Overview</small>
          </div>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
              <a class="dropdown-item" href="javascript:void(0);">Download</a>
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
            </div>
          </div>
        </div>
        <div class="card-body pb-0">        
          <div id="reportBarChart"></div>
        </div>
      </div>
    </div> --}}
    <!--/ Earning Reports -->
  
    <!-- Revenue Generated -->
    {{-- <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body pb-0">
          <div class="card-icon">
            <span class="badge bg-label-success rounded-pill p-2">
              <i class='ti ti-credit-card ti-sm'></i>
            </span>
          </div>
          <h5 class="card-title mb-0 mt-2">97.5k</h5>
          <small>Revenue Generated</small>
        </div>
        <div id="revenueGenerated"></div>
      </div>
    </div> --}}
    <!--/ Revenue Generated -->
  
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <!-- Users List Table -->
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-3">Latest Tokens</h5>
            <a href="{{url('token-add')}}" class="btn btn-primary waves-effect waves-light">Generate Token</a>
          </div>
          <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
            <div class="col-md-4 user_role"></div>
            <div class="col-md-4 user_plan"></div>
            <div class="col-md-4 user_status"></div>
          </div>
        </div>
        <div class="card-datatable text-nowrap" style="margin: auto 2%">
          <table class="table" id="usersTable">
            <thead class="border-top">
              <tr>
                <th>#</th>
                <th>Token</th>
                <th>Service opted</th>
                <th>User</th>
                <th>Current status</th>
                <th>Active/Inactive</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $token)
                @php
                    $token_statuses = App\Models\TokenStatus::where('token_id', $token->id)->pluck('status')->toArray();
                    $filteredStatuses = array_filter($token_statuses, function ($status) {
                        return $status !== "5";;
                    }); 
                    $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
                    $lastStatus = !empty($token_statuses) ? end($token_statuses) : 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      {{$token->token}}
                      @if (in_array(5, $token_statuses))
                        <span class="badge rounded-pill bg-success bg-glow">Paid</span>                    
                      @endif 
                    </td>                
                    <td>{{ optional($token->service)->name}}</td>
                    <td>{{ optional($token->user)->fname." ".optional($token->user)->mname." ".optional($token->user)->lname }}</td>
                    <td>                  
                      @switch($filteredLastStatus)                      
                        @case(1)
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #6d99d639"></span>&nbsp; Token Generated
                            @break                     
                        @case(2)
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #a5d8e4;"></span>&nbsp;Data Validated 
                            @break
                        @case(3)
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #a5d8e4;"></span>&nbsp;Return Not Filed / Not Finalized 
                            @break
                        @case(4)
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #0558e876;"></span>&nbsp;Return Not Filed / Finalized / Payments Pending 
                            @break
                        @case(5)
                            <span class="badge badge-dot border border-2 p-2 bg-success"></span>&nbsp;Payments Completed / Ready to file 
                            @break
                        @case(6)
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #fee3d1;"></span>&nbsp;Returns Filed - Not Verified 
                            @break
                        @case(7)
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #c8f1b5;"></span>&nbsp;Return Filed -Verified 
                            @break
                        @case(8)
                            <span class="badge badge-dot border border-2 p-2 bg-primary"></span>&nbsp;Document Delivered 
                            @break
                        @default
                            <span class="badge badge-dot border border-2 p-2 bg-danger" style="background-color: red;"></span>&nbsp;Unknown Status
                      @endswitch                    
                    </td>
                    <td>
                      <label class="switch">
                        <input type="checkbox" class="switch-input status-toggle" {{$token->is_active == 1 ? 'checked' : ''}} id="status-toggle" data-id="{{$token->id}}" />
                        <span class="switch-toggle-slider">
                          <span class="switch-on"></span>
                          <span class="switch-off"></span>
                        </span>   
                        <span class="switch-label {{$token->is_active == 1 ? 'text-success' : 'text-danger'}}">{{$token->is_active == 1 ? 'Active' : 'Inactive'}}</span>                 
                      </label>
                    </td>
                    <td>
                      <div class="d-flex"> 
                        <a href="{{route('view.token', ['token'=>$token])}}"
                          data-bs-toggle="tooltip"
                          data-bs-placement="bottom"
                          data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> |  
                        @if(session('type') !== 'user')
                        <a href="javascript:void(0);" onclick="myFunction({{$token->id}})" 
                          data-bs-toggle="tooltip"
                          data-bs-placement="bottom"
                          data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> @endif | 
                        @if ( $token->action_by == 'Admin' && $token->status == 'Token Generated')
                          <a href="{{route('token.upload_document', ['token'=>$token])}}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-original-title="Upload Documents"><i class="ti ti-clipboard me-1"></i></a> |   
                        @endif 
                        @if ($token->action_by == 'Admin' && $token->status == 'Document Uploaded')
                          <a href="{{route('token.upload_document_edit', ['token'=>$token])}}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-original-title="Edit Uploaded Documents"><i class="ti ti-certificate me-1"></i></a> |      
                        @endif 
                        
                        @if($lastStatus != 8)
                        <a href="javascript:void(0);"
                          data-bs-toggle="modal" data-bs-target="#tokenStatusChangeModal" onclick="change_token_status_modal({{$token->id}}, '{{$token->token}}', '{{ optional($token->service)->name}}')">
                          <i data-bs-toggle="tooltip"
                          data-bs-placement="bottom" data-bs-original-title="Change Status" class="ti ti-progress-check me-1" data-bs-toggle="modal" data-bs-target="#basicModal-{{$token->id}}"></i>
                        </a>              
                        @else
                        <div class="form-check-success">
                          <i class="ti ti-square-check" style="color: var(--bs-success)"
                          data-bs-toggle="tooltip"
                          data-bs-placement="bottom" data-bs-original-title="Status:- Document Delivered"></i>                                           
                        </div>
                        @endif                    
                        
                      </div>
                        
                    </td>
                    
                </tr>    
                @endforeach
                
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.token_status_modal')

@if ($dashboardPermission == 1)    
  <div id="second-dashboard" style="display: none;">
    <div class="row">
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-navy">      
              <h4 class="fw-bold">Total ITR</h4>      
              <div class="mb-3">
                <h4>1500</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="container mt-5">
          <div class="card-custom red25 text-center shadow-navy">      
            <h4 class="fw-bold">Total GST</h4>      
            <div class="mb-3">
              <h4>200</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="footer-icons">
                
              </div>
              {{-- <div class="footer-date">Sept. 21</div> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-navy">      
              <h4 class="fw-bold">Total TDS</h4>      
              <div class="mb-3">
                <h4>300</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-navy">      
              <h4 class="fw-bold">Total Token</h4>      
              <div class="mb-3">
                <h4>500</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-green">      
              <h4 class="fw-bold">New ITR Filing</h4>      
              <div class="mb-3">
                <h4>100</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="container mt-5">
          <div class="card-custom red25 text-center shadow-green">      
            <h4 class="fw-bold">New GST Filing</h4>      
            <div class="mb-3">
              <h4>500</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="footer-icons">
                
              </div>
              {{-- <div class="footer-date">Sept. 21</div> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-green">      
              <h4 class="fw-bold">New TDS Filing</h4>      
              <div class="mb-3">
                <h4>20</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-green">      
              <h4 class="fw-bold">General Token</h4>      
              <div class="mb-3">
                <h4>10</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-maroon">      
              <h4 class="fw-bold">Pending ITR</h4>      
              <div class="mb-3">
                <h4>75</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="container mt-5">
          <div class="card-custom red25 text-center shadow-maroon">      
            <h4 class="fw-bold">Pending GST</h4>      
            <div class="mb-3">
              <h4>30</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="footer-icons">
                
              </div>
              {{-- <div class="footer-date">Sept. 21</div> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-maroon">      
              <h4 class="fw-bold">Pending TDS</h4>      
              <div class="mb-3">
                <h4>14</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-maroon">      
              <h4 class="fw-bold">Pending Token</h4>      
              <div class="mb-3">
                <h4>500</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-olive">      
              <h4 class="fw-bold">Compeleted ITR</h4>      
              <div class="mb-3">
                <h4>25</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="container mt-5">
          <div class="card-custom red25 text-center shadow-olive">      
            <h4 class="fw-bold">Completed GST</h4>      
            <div class="mb-3">
              <h4>20</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="footer-icons">
                
              </div>
              {{-- <div class="footer-date">Sept. 21</div> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-olive">      
              <h4 class="fw-bold">Completed TDS</h4>      
              <div class="mb-3">
                <h4>6</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="container mt-5">
            <div class="card-custom red25 text-center shadow-olive">      
              <h4 class="fw-bold">Completed Token</h4>      
              <div class="mb-3">
                <h4>5</h4>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="footer-icons">
                  
                </div>
                {{-- <div class="footer-date">Sept. 21</div> --}}
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@else
<div id="second-dashboard" style="display:none;">
  <div class="d-flex container-xxl" style="margin-top: 100px;">
    <div class="misc-wrapper text-center">
      <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">403</h1>
      <h2 class="mb-1 mx-2">You are not authorized!</h2>      
    </div>
  </div>
</div>
@endif

@include('layouts.footer')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    let t = (isDarkStyle ? ((e = config.colors_dark.textMuted), config.colors_dark) : ((e = config.colors.textMuted), config.colors)).headingColor;
    const pieChartData = @json($metrics);
    const totalTokens = @json($totalTokens);

    // Extract labels and data for the chart
    const labels = pieChartData.map(data => data.status);
    const percentages = pieChartData.map(data => data.percentage_change);

    pieConfig = {
        chart: {
            fontFamily: 'Poppins, sans-serif',
            height: 320,
            type: 'donut',
        },
        colors: ['#70D19C', '#16924F', '#ff0000'],
        series: percentages,
        labels: labels,        
        dataLabels: {
            enabled: !1,
            formatter: function (e, t) {
                return parseInt(e) + "%";
            },
        },
        legend: {
            show: !0,
            position: "bottom",
            offsetY: 10,
            markers: { width: 8, height: 8, offsetX: -3 },
            itemMargin: { horizontal: 15, vertical: 5 },
            fontSize: "13px",
            fontFamily: "Public Sans",
            fontWeight: 400,
            labels: { colors: t, useSeriesColors: !1 },
        },
        tooltip: { theme: !1 },
        grid: { padding: { top: 15 } },
        states: { hover: { filter: { type: "none" } } },
        plotOptions: {
            pie: {
                donut: {
                    size: "77%",
                    labels: {
                        show: !0,
                        value: {
                            fontSize: "26px",
                            fontFamily: "Public Sans",
                            color: t,
                            fontWeight: 500,
                            offsetY: -30,
                            formatter: function (e) {
                                return parseInt(e) + "%";
                            },
                        },
                        name: { offsetY: 20, fontFamily: "Public Sans" },
                        total: {
                            show: !0,
                            fontSize: ".75rem",
                            label: "Total Token",
                            color: e,
                            formatter: function (e) {
                                return totalTokens;
                            },
                        },
                    },
                },
            },
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
                    height:200,
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };


    requestAnimationFrame(function() {
        var chart = new ApexCharts(document.querySelector("#piPercentageChart"), pieConfig);
        chart.render();
    });
    
     
   });

</script>
<script>

  $(document).ready(function(){
    $('[name="btnradio"]').on('click', function(){
        if($(this).attr('id') == 'btnradio1'){
          console.log('Dashboard 1 selected');
          $('#main-dashboard').css('display', 'block');
          $('#second-dashboard').css('display', 'none');
        }else if($(this).attr('id') == 'btnradio2') {
          console.log('Dashboard 2 selected');
          $('#main-dashboard').css('display', 'none');
          $('#second-dashboard').css('display', 'block');
        }
    });
  });

  function myFunction(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{url('token-delete')}}",
                    method: "POST",
                    data: {
                        user_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Token has been deleted.',
                            'success'
                        ).then(function() {
                            window.location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', xhr);
                        if (xhr.status === 403) {
                            toastr.error("You don't have permission!");                  
                        } 
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your Token is safe :)',
                    'error'
                );
            }
        });
    }

    $(document).ready(function() { 
      
      $('.status-toggle').on('click', function(){
        
        const checkbox = $(this);
        const tokenId = checkbox.data('id');

        $.ajax({
          url: '{{ route("token.toggleStatus", ":id")}}'.replace(':id', tokenId),
          type: 'POST',
          data: {
            _token: '{{csrf_token()}}'
          },
          success: function(response){

            const label = checkbox.closest('label').find('.switch-label');
            label.text(response.status ? 'Active' : 'Inactive');
            label.toggleClass('text-success', response.status);
            label.toggleClass('text-danger', !response.status);

            toastr.success(response.message);
          },
          error: function () { 
            toastr.error('There was an error updating the status.')
            checkbox.prop('checked', !checkbox.prop('checked'))
          }
        });
      });

      $('.token-status').on('change', function(){
        var status = $(this).val();
        var token = $(this).data('token');

        $.ajax({
          url: "{{route('token.change.status')}}", 
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            token: token, 
            status: status,
          },
          success: function(response)
          {
            if(response.status == true){
              toastr.success(response.message);
              window.location.reload();
            }else if(response.status == false){
              toastr.error(response.message);
            }
          },
          error: function (xhr, status, error) {
              console.error('AJAX Error:', xhr);
              if (xhr.status === 403) {
                  toastr.error("You don't have permission!");                  
              } 
          },
        });
      });
      
    });

      function toggleStatuss(userId) {
        $.ajax({
          url: '{{ route("token.toggleStatus", ":id") }}'.replace(':id', userId),
          type: 'POST',
          data: {
              _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            const label = $('#status-toggle').closest('label').find('.switch-label');
            label.text(response.status ? 'Active' : 'Inactive');
            label.toggleClass('text-success', response.status);
            label.toggleClass('text-danger', !response.status);
            toastr.success(response.message);
          },
          error: function() {
            toastr.error('There was an error updating the status.');
          }
        });
      }
  
</script>

