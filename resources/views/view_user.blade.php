@section('title', 'View User')
@section('description', 'View User Details')
@section('keywords', 'View User Details')

@section('vendor_css')

@endsection

@section('page_css')
@endsection

@section('manu', 'Users')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav') 

<div class="row">
    <!-- User Sidebar -->
  <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
      <div class="card-body">        
        <div class="user-avatar-section">
          <div class=" d-flex align-items-center flex-column">
            @if ($user->image != null && $user->image != '')   
            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{url('uploads/'.$user->image) }}" height="100" width="100" alt="User avatar" />
            @else
                <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{url('uploads/user/default_profile.jpg') }}" height="100" width="100" alt="User avatar" />
            @endif
            <div class="user-info text-center">
              <h4 class="mb-2">{{$user->name}}</h4>
              <span class="badge bg-label-secondary mt-1">Client</span>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
          <div class="d-flex align-items-start me-4 mt-3 gap-2">
            {{-- <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-checkbox ti-sm'></i></span> --}}
            <div>
              <p class="mb-0 fw-medium badge bg-label-{{$user->status == 1 ? 'success' : 'danger'}}">{{$user->status == 1 ? 'Active' : 'Inactive'}}</p>
              <small></small>
            </div>
          </div>
          <div class="d-flex align-items-start mt-3 gap-2">
            {{-- <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-briefcase ti-sm'></i></span> --}}
            <div>
              {{-- <p class="mb-0 fw-medium">{{ count($user->tokens)}}</p> --}}
              <small>Tocken Generated ({{ count($user->tokens)}})</small>
            </div>
          </div>
        </div>
        <h5 class="mt-4 small text-uppercase text-muted">Details</h5>
        <div class="info-container">
          <ul class="list-unstyled">
            <li class="mb-2">
              <span class="fw-medium me-1">Name:</span>
              <span>{{$user->fname." ".$user->mname." ".$user->lname}}</span>
            </li>
            <li class="mb-2">
              <span class="fw-medium me-1">Father Name:</span>
              <span>{{$user->f_fname." ".$user->f_mname." ".$user->f_lname}}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Email:</span>
              <span>{{$user->email}}</span>
            </li>            
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Role:</span>
              <span>User</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">PAN No:</span>
              <span>{{ $user->pan_no }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Adhar No:</span>
              <span>{{ $user->adhar_number }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Contact:</span>
              <span>{{ $user->phone }}</span>
            </li>                        
          </ul>
          <div class="d-flex justify-content-center">
            <a href="{{route('user.edit', ['user'=>$user])}}" class="btn btn-outline-primary me-3">Edit</a>
            <a href="javascript:;" class="btn btn-outline-{{$user->status == 1 ? 'danger' : 'success'}} me-3" id="status-toggle" onclick="toggleStatus({{ $user->id }})">{{$user->status == 1 ? 'Deactivate' : 'Acivate'}}</a>            
          </div>
        </div>
      </div>
    </div>
    <!-- /User Card --> 
  </div>
  <!--/ User Sidebar -->

  <!-- User Content -->
  <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <div class="d-flex justify-content-end">            
      <a href="{{route('view_user_token', ['user'=>$user])}}" class="btn btn-primary">Tokens</a>
    </div><br>
    <!-- User Pills -->
    <div class="nav-align-top nav-tabs-shadow mb-4">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false"><i class="ti ti-brand-oauth me-1 ti-xs"></i>Previous Tokens</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true"><i class="ti ti-user-check me-1 ti-xs"></i>Bank Details</button>
        </li> 
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-address" aria-controls="navs-top-address" aria-selected="true"><i class="ti ti-user-check me-1 ti-xs"></i>User Address</button>
        </li>                       
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade" id="navs-top-address" role="tabpanel">
          <h6>Home Address</h6>
          <div class="row">            
            <div class="col-lg-4">
              <p>
                House No:- {{ optional($user->userAddress)->house_no }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                House Name:- {{ optional($user->userAddress)->house_name }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                Street:- {{ optional($user->userAddress)->street }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                Area:- {{ optional($user->userAddress)->area }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                City:- {{ optional($user->userAddress)->city }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                State:- {{ optional($user->userAddress)->state }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                Country:- {{ optional($user->userAddress)->country }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                Pincode:- {{ optional($user->userAddress)->pin_code }}
              </p> 
            </div>            
            <br><hr><br>            
          </div>
          @if (optional($user->userAddress)->office_check == '1')
            <div class="row">
              <div class="col-md-12">
                <p>Office Address is same as Above</p>
              </div>
            </div>
          @else
          <h6>Office Address</h6>
          <div class="row">            
            <div class="col-lg-4">
              <p>
                House No:- {{ optional($user->userAddress)->office_house_no }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                House Name:- {{ optional($user->userAddress)->office_house_name }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                Street:- {{ optional($user->userAddress)->office_street }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                Area:- {{ optional($user->userAddress)->office_area }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                City:- {{ optional($user->userAddress)->office_city }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                State:- {{ optional($user->userAddress)->office_state }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                Country:- {{ optional($user->userAddress)->office_country }}
              </p> 
            </div>
            <div class="col-lg-4">
              <p>
                Pincode:- {{ optional($user->userAddress)->office_pin_code }}
              </p> 
            </div>            
            <br><hr><br>            
          </div>
          @endif                  
        </div>

        <div class="tab-pane fade" id="navs-top-home" role="tabpanel">
          <div class="row">
            <div class="d-flex justify-content-start">
              <span class="badge bg-primary">Primary</span>
            </div>
            <div class="col-lg-12">
              <br>
            </div>
            @foreach ($user->userBankAccountDetail as $userBankAccountDetail)
            <div class="col-lg-4">
              <p>
                Bank Name:- {{ $userBankAccountDetail->bank_name }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                Account No:- {{ $userBankAccountDetail->account_no }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                IFSC:- {{ $userBankAccountDetail->ifsc }}
              </p>
            </div>
            <div class="col-lg-4">
              <p>
                Branch:- {{ $userBankAccountDetail->branch }}
              </p> 
            </div>            
            <br><hr><br>
            @endforeach
            <div class="col-lg-4">
              <h6 class="mb-0" style="color: red;"><u>Income Tax Password</u></h6>
              <div class="d-flex justify-content-between justify-content-center">
                <p id="hidden-text" style="visibility: hidden;">{{ optional($user->userBankAccountDetail)->first()->income_tax_password }}</p>
                <span class="cursor-pointer" id="toggle-visibility">
                  <i class="ti ti-eye-off" style="color: #7367f0"></i>
                </span>
              </div>              
            </div>
          </div>                  
        </div>        
        <div class="tab-pane fade show active" id="navs-top-messages" role="tabpanel">          
              <table class="table" id="usersTable">
                <thead class="border-top">
                  <tr>
                    <th>#</th>
                    <th>Token</th>
                    <th>Service opted</th>
                    <th>Current status</th>                                      
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($user->tokens)
                    @foreach ($user->tokens as $token)
                    @php
                        $token_statuses = App\Models\TokenStatus::where('token_id', $token->id)->pluck('status')->toArray();
                        $filteredStatuses = array_filter($token_statuses, function ($status) {
                            return $status !== "5";
                        }); 
                        $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
                        $lastStatus = !empty($token_statuses) ? end($token_statuses) : 0;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$token->token}}</td>
                        <td>{{ optional($token->service)->name}}</td>
                        <td>
                          @switch($filteredLastStatus)                      
                              @case(1)
                                  Token Generated
                                  @break
                              @case(2)
                                  Data Validated
                                  @break
                              @case(3)
                                  Document Uploaded
                                  @break
                              @case(4)
                                  Finilized
                                  @break
                              @case(5)
                                  Payment Confirmed
                                  @break
                              @case(6)
                                  Filed
                                  @break
                              @case(7)
                                  Verified
                                  @break
                              @case(8)
                                  Document Delivered
                                  @break
                              @default
                                  Unknown Status
                          @endswitch    
                        </td>                                               
                        <td>
                          <div class="d-flex">  
                            <a href="{{route('view.token', ['token'=>$token])}}"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> |       
                            <a href="javascript:void(0);" onclick="myFunction({{$token->id}})"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> |                                          
                            @if ( $token->status == 'Token Generated')
                              <a href="{{route('token.upload_document', ['token'=>$token])}}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                                data-bs-original-title="Upload Documents"><i class="ti ti-clipboard me-1"></i></a> |   
                            @endif 
                            @if ( $token->status == 'Document Uploaded')
                              <a href="{{route('token.upload_document_edit', ['token'=>$token])}}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                                data-bs-original-title="Edit Uploaded Documents"><i class="ti ti-certificate me-1"></i></a> |      
                            @endif
                            @if($lastStatus != 8)
                            <a href="javascript:void(0);"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              data-bs-original-title="Change Status"><i id="change_token_status" class="ti ti-progress-check me-1" data-bs-toggle="modal" data-bs-target="#basicModal-{{$token->id}}"></i>
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
                        <div class="modal fade" id="basicModal-{{$token->id}}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Change Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-6 mb-3">
                                    <label for="nameBasic" class="form-label">Token ID: <span id="token_id" class="badge bg-label-primary">{{$token->token}}</span></label>              
                                  </div>
                                  <div class="col-md-6 mb-3">
                                    <label for="nameBasic" class="form-label">Service: <span id="service_change" class="badge bg-label-info">{{ optional($token->service)->name}}</span></label>              
                                  </div>
                                </div>          
                                <div class="row g-2">            
                                  <div class="col mb-0">                            
                                    <label for="dobBasic" class="form-label">Status</label>
                                    <select id="" class="select2 form-select token-status" name="payment_status" data-allow-clear="true" data-token="{{$token->id}}">  
                                      @php                                
                                        $statusOptions = [
                                          2 => 'Data Validated',
                                          4 => 'Finalized',
                                          6 => 'Filed',
                                          7 => 'Verified',
                                          8 => 'Document Delivered'
                                        ];
                                        
                                        $availableStatuses = array_filter($statusOptions, function ($key) use ($filteredLastStatus) {
                                            return $key > $filteredLastStatus;
                                        }, ARRAY_FILTER_USE_KEY);
                                      @endphp
                                      <option value="">Change Status</option>
                                      @foreach ($availableStatuses as $value => $label)
                                          <option value="{{ $value }}">{{ $label }}</option>
                                      @endforeach                              
                                    </select> 
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button> --}}
                              </div>
                            </div>
                          </div>
                        </div>
                    </tr>    
                    @endforeach                      
                  @endif                    
                </tbody>
              </table>          
        </div>
      </div>
    </div>

  </div>
  <!-- /Social Accounts -->
</div>


<!-- Vendors JS -->
@section('vendor_js')

@endsection

<!-- Page JS -->
@section('page_js')
<script src="../../assets/js/app-user-view.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('main_js')
<script src="../../assets/js/main.js"></script>
@endsection

<script>
    function toggleStatus(userId) {
        $.ajax({
          url: '{{ route("user.toggleStatus", ":id") }}'.replace(':id', userId),
          type: 'POST',
          data: {
              _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            // Update the label based on the new status
            $('#status-toggle').next('.switch-label').text(response.status ? 'Active' : 'Inactive');
            toastr.success(response.message);
            setTimeout(function() {
                location.reload();
            }, 1000);
          },
          error: function() {
            toastr.error('There was an error updating the status.');
          }
        });
    }

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
    
    $(document).ready(function(){

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
              window.location.reload();
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

    document.getElementById('toggle-visibility').addEventListener('click', function () {
        const textElement = document.getElementById('hidden-text');
        const iconElement = this.querySelector('i');

        if (textElement.style.visibility === 'hidden') {
            textElement.style.visibility = 'visible';
            iconElement.classList.add('ti-eye');
            iconElement.classList.remove('ti-eye-off');
        } else {
            textElement.style.visibility = 'hidden';
            iconElement.classList.add('ti-eye-off');
            iconElement.classList.remove('ti-eye');
        }
    });
</script>

@include('layouts.footer')