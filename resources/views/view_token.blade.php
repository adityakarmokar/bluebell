@section('title', 'Tokens')
@section('description', 'Tokens description')
@section('keywords', 'Tokens')

@section('vendor_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
@endsection

@section('manu', 'Tokens')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav') 

<style>
  .thumbnail {
      transition: transform 0.2s;
  }
  .thumbnail:hover {
      transform: scale(1.05);
  }
  #hidden-text {
      visibility: hidden; /* Default state: hidden */
  }
  .input-group-text {
      cursor: pointer;
  }

</style>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
  
    <div class="d-flex flex-column justify-content-center gap-2 gap-sm-0">
      <h5 class="mb-1 mt-3 d-flex flex-wrap gap-2 align-items-end">Token {{$token->token}} <span class="badge bg-label-warning" style="font-size: 12px !important;">{{ optional($token->service)->name}}</span>
        
        <span>Status:- </span>
        @php  
          $lastStatus = !empty($statuses) ? end($statuses) : 0;     
          $filteredStatuses = array_filter($statuses, function ($status) {
              return $status !== "5";
          });      
          $filteredLastStatus = !empty($filteredStatuses) ? end($filteredStatuses) : 0;
          
          $statusOptions = [
              1 => 'Token Generated',
              2 => 'Return Data Validated',
              3 => 'Return Not Filed / Not Finalized',
              4 => 'Return Not Filed / Finalized',
              6 => 'Returns Filed - Not Verified',
              7 => 'Return Filed - Verified',
              8 => 'Documents Delivered'
          ];
          
          $availableStatuses = array_filter($statusOptions, function ($key) use ($filteredLastStatus) {
              return $key == $filteredLastStatus;
          }, ARRAY_FILTER_USE_KEY);
        @endphp
        @foreach ($availableStatuses as $value => $label)
            <small class="badge bg-{{$value != 8 ? 'info' : "success"}}" style="font-size: 12px !important;">{{ $label }}</small>
        @endforeach           
      </h5>   

    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">      
      <a href="javascript:void(0);" onclick="myFunction({{$token->id}})" class="btn btn-sm btn-label-danger delete-order" 
        data-bs-toggle="tooltip"
        data-bs-placement="bottom"
        data-bs-original-title="Delete Token"><i class="ti ti-trash ti-sm"></i></a>
    </div>
  </div>
  
  <!-- Order Details Table -->
  
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Uploaded Documents</button>
          </li> 
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-notes" aria-controls="navs-pills-top-notes" aria-selected="true">Client's Comment</button>
          </li>          
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-filed-document" aria-controls="navs-pills-filed-document" aria-selected="true">Filed Document</button>
          </li>          
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
            @php
            $form_16_a = json_decode(optional($token->tokenDocument)->form_16_a, true);
            $annex_use = json_decode(optional($token->tokenDocument)->annex_use, true);
            $form_16_parantal = json_decode(optional($token->tokenDocument)->form_16_parantal, true);
            $inv_lic_mf = json_decode(optional($token->tokenDocument)->inv_lic_mf, true);
            $public_investment = json_decode(optional($token->tokenDocument)->public_investment, true);
            $bank_statement = json_decode(optional($token->tokenDocument)->bank_statement, true);
            $sales_purchase = json_decode(optional($token->tokenDocument)->sales_purchase, true);
            @endphp
            <div class="row">
              @if($form_16_a != null)
              <p class="mt-1"><strong>Form 16 A</strong></p>
              @foreach($form_16_a as $form_16_aa)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $form_16_aa) }}" alt="" width="100%" height="200px" 
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $form_16_aa) }}')">
                </div>
              @endforeach
              @endif
              @if($annex_use != null)
              <p><strong>Annex Use</strong></p>
              @foreach($annex_use as $annex)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $annex) }}" alt="" width="100%" height="200px"
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $annex) }}')">
                </div>
              @endforeach
              @endif
              @if($form_16_parantal != null)
              <p><strong>Form 16 (issued by parental dept)</strong></p>
              @foreach($form_16_parantal as $form_16_p)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $form_16_p) }}" alt="" width="100%" height="200px"
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $form_16_p) }}')">
                </div>
              @endforeach
              @endif
              @if($inv_lic_mf != null)
              <p><strong>Investment (LIC, MF)</strong></p>
              @foreach($inv_lic_mf as $inv_lic)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $inv_lic) }}" alt="" width="100%" height="200px"
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $inv_lic) }}')">
                </div>
              @endforeach
              @endif
              @if(optional($token->tokenDocument)->intrest_certificate != null)
              <p><strong>Interest Certificate</strong></p>
              <div class="col-lg-6">
                <img src="{{ url('uploads/'. optional($token->tokenDocument)->intrest_certificate) }}" alt="" width="100%" height="200px"
                data-bs-toggle="modal" 
                data-bs-target="#imageModal" 
                onclick="showImage('{{ url('uploads/'. optional($token->tokenDocument)->intrest_certificate) }}')">
              </div>
              @endif
              @if($public_investment != null)
              <p><strong>Investment in public mutual, Shares, Debenture</strong></p>
              @foreach($public_investment as $public)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $public) }}" alt="" width="100%" height="200px"
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $public) }}')">
                </div>
              @endforeach
              @endif
              @if($bank_statement != null)
              <p><strong>Bank Statement</strong></p>
              @foreach($bank_statement as $bank_st)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $bank_st) }}" alt="" width="100%" height="200px"
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $bank_st) }}')">
                </div>
              @endforeach
              @endif
              @if($sales_purchase != null)
              <p><strong>Bills (Sales/Purchase)</strong></p>
              @foreach($sales_purchase as $sales)
                <div class="col-lg-6">
                  <img src="{{ url('uploads/'. $sales) }}" alt="" width="100%" height="200px"
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  onclick="showImage('{{ url('uploads/'. $sales) }}')">
                </div>
              @endforeach
              @endif
            </div>
          </div>
          
          <div class="tab-pane fade" id="navs-pills-top-notes" role="tabpanel">
            <p>{{ optional($token->tokenDocument)->comment }}</p>
          </div>
          <div class="tab-pane fade" id="navs-pills-top-filed-document" role="tabpanel">
            <form action="{{url('save-filed-document')}}" method="POST">
              @csrf
              <input type="hidden" name="token_id" value="{{$token->id}}">
              <div class="card mb-4 mt-4">
                <h5 class="card-header">Filed Document</h5>
                <div class="card-body"> 
                  <div class="dropzone needsclick" id="profile-image-dropzone">                    
                      <img src="{{asset('uploads')}}/{{ $token->filed_document }}" alt="" width="250px">               
                        <div class="dz-message needsclick text-center">
                            <p>Drop files here or click to upload</p>
                            <span class="note needsclick">(Selected files are added to the form and submitted together.)</span>
                        </div>
                    </div>
                    <!-- Hidden input to store file data -->
                    <input type="hidden" name="image" id="profile_image">                  
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </form>

            @if($token->filed_document)
            <div class="d-flex justify-content-end align-items-center">
              <div class="file-icon me-3">
                  @php
                      $extension = pathinfo($token->filed_document, PATHINFO_EXTENSION);
                  @endphp
          
                  <!-- Use icons based on the file extension -->
                  @if($extension === 'pdf')
                      <i class="fas fa-file-pdf text-danger fs-3"></i> {{$token->filed_document}}
                  @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                      <i class="fas fa-file-image text-success fs-3"></i> {{$token->filed_document}}
                  @elseif(in_array($extension, ['doc', 'docx']))
                      <i class="fas fa-file-word text-primary fs-3"></i> {{ $token->filed_document }}
                  @elseif(in_array($extension, ['xls', 'xlsx']))
                      <i class="fas fa-file-excel text-success fs-3"></i> {{ $token->filed_document }}
                  @elseif(in_array($extension, ['ppt', 'pptx']))
                      <i class="fas fa-file-powerpoint text-warning fs-3"></i> {{ $token->filed_document }}
                  @elseif(in_array($extension, ['zip', 'rar']))
                      <i class="fas fa-file-archive text-secondary fs-3"></i> {{ $token->filed_document }}
                  @else
                      <i class="fas fa-file text-muted fs-3"></i> {{ $token->filed_document }}
                  @endif
              </div>
              <div>
                  <!-- Download link -->
                  <a href="{{ asset('uploads/' . $token->filed_document) }}" download target="_blank" class="btn btn-primary btn-sm">
                      Download File
                  </a>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>

      
    
    </div>
    <div class="col-12 col-lg-4">
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="card-title m-0"><b>Client details</b></h6>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-start align-items-center mb-4">
            {{-- <div class="avatar me-2">
              <img src="{{ url('uploads').'/'.optional($token->user)->image }}" alt="Avatar" class="rounded-circle">
            </div> --}}
            <div class="d-flex flex-column">
              <a href="javascript:void(0);" class="text-body text-nowrap">
                <h6 class="mb-0">{{optional($token->user)->fname." ".optional($token->user)->mname." ".optional($token->user)->lname}}</h6>
              </a>
              <small class="text-muted"></small>
            </div>
          </div>
          <div class="d-flex justify-content-start align-items-center mb-4">
            <span class="avatar rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center"><i class='ti ti-brand-oauth ti-sm'></i></span>
            <h6 class="text-body text-nowrap mb-0">
              {{ is_countable(optional($token->user)->ca_tokens) ? count(optional($token->user)->ca_tokens) : 0 }} Tokens Generated
            </h6>          
          </div>
          <div class="d-flex justify-content-between">
            <h6>Contact info</h6>
            <h6><a href="{{route('user.edit', ['user'=>$token->user])}}">Edit</a></h6>
          </div>          
          <p class=" mb-0">PAN: {{ optional($token->user)->pan_no }}</p>
          <p class=" mb-0">Mobile: {{ optional($token->user)->phone }}</p>
          <p class=" mb-1">Email: {{ optional($token->user)->email }}</p>
        </div>
      </div>
        
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="card-title m-0"><b>Payment Status</b></h6>         
          @if (in_array(5, $statuses) && $token->payment != null)              
            <p style="margin: 0 !important;">Paid</p>             
          @endif          
        </div>
        <div class="card-body">  
          @if(!in_array(5, $statuses) && $token->payment == null)                        
            <button type="button" class="btn btn-label-linkedin waves-effect" data-bs-toggle="modal" data-bs-target="#upi-payment-modal">
              <i class="ti ti-currency-rupee"></i> By UPI 
            </button>
            <button type="button" class="btn btn-label-github waves-effect" data-bs-toggle="modal" data-bs-target="#cash-payment-modal">
              <i class="ti ti-currency-rupee"></i> By Cash
            </button>                                                    
          @endif

          @if (in_array(4, $statuses))
            <div class="d-flex justify-content-start">
              <p>Refund Amount: </p>&nbsp;
              <p>₹ {{ number_format($token->refund_amount, 2) }}</p>  
            </div>      
            <div class="d-flex justify-content-start">
              <p>Payable Amount: </p>&nbsp;
              <p>₹ {{ number_format($token->payable_amount, 2) }}</p>  
            </div>   
            <div class="d-flex justify-content-start">
              <p>Consultency Fees: </p>&nbsp;
              <p>₹ {{ number_format($token->consultency_fees, 2) }}</p>  
            </div>   
            
          @endif
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
          <h6 class="card-title m-0">Accounts Detail</h6>          
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-start">
            <span class="badge bg-primary">Primary</span>
          </div>
          @foreach ($token->user->userBankAccountDetail as $userBankAccountDetail)
            <p class="mb-0">Account Type:  {{ $userBankAccountDetail->account_type }}</p>
            <p class="mb-0">Bank Name:  {{ $userBankAccountDetail->bank_name }}</p>
            <p class="mb-0">Account Number:  {{ $userBankAccountDetail->account_no }}</p>
            <p class="mb-0">IFSC:  {{ $userBankAccountDetail->ifsc }}</p>
            <p class="mb-4">Branch:  {{ $userBankAccountDetail->branch }}</p>
            <hr><br>
          @endforeach
          <h6 class="mb-0" style="color: red;"><u>Income Tax Password</u></h6>
            <div class="d-flex justify-content-between justify-content-center">
              @if(($token->user->userBankAccountDetail)->isNotEmpty())
              <p id="hidden-text" style="visibility: hidden;">{{ optional($token->user->userBankAccountDetail)->first()->income_tax_password }}</p>
              <span class="cursor-pointer" id="toggle-visibility">
                <i class="ti ti-eye-off" style="color: #7367f0"></i>
              </span>
			@endif
            </div>
                                        
        </div>
  
      </div>

      <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title m-0">Token Activity</h5>
        </div>
        <div class="card-body">
            <ul class="timeline pb-0 mb-0">
                @foreach ($statusRecords as $record)
                    <li class="timeline-item timeline-item-transparent 
                        {{ in_array($record->status, [1, 2, 3, 4, 5, 6, 7, 8]) ? 'border-primary' : 'border-transparent' }}">
                        <span class="timeline-point 
                            {{ in_array($record->status, [1, 2, 3, 4, 5, 6, 7, 8]) ? 'timeline-point-primary' : 'timeline-point-secondary' }}">
                        </span>
                        <div class="timeline-event">
                            <div class="timeline-header">
                                <h6 class="mb-0">
                                    @switch($record->status)
                                        @case(1)
                                            Token Generated (Token ID: {{ $token->token }})
                                            @break
                                        @case(2)
                                            Data Validation
                                            @break
                                        @case(3)
                                            Document Uploaded
                                            @break
                                        @case(4)
                                            Finalization
                                            @break
                                        @case(5)
                                            Payment Confirmation
                                            @break
                                        @case(6)
                                            Filing
                                            @break
                                        @case(7)
                                            Verification
                                            @break
                                        @case(8)
                                            Document Delivered
                                            @break
                                        @default
                                            Unknown Status
                                    @endswitch
                                </h6>
                                <span class="text-muted">
                                    {{ $record->updated_at->format('l h:i A') }}
                                </span>
                            </div>
                            <p class="mt-2">
                                @switch($record->status)
                                    @case(1)
                                        Token has been generated successfully.
                                        @break
                                    @case(2)
                                        Data validation completed.
                                        @break
                                    @case(3)
                                        Required documents have been uploaded successfully.
                                        @break
                                    @case(4)
                                        Token finalization completed.
                                        @break
                                    @case(5)
                                        Payment is done for this token.
                                        @break
                                    @case(6)
                                        Filing done!
                                        @break
                                    @case(7)
                                        Verification completed!
                                        @break
                                    @case(8)
                                        Hooray! All tasks are completed, and documents are delivered!
                                        @break
                                    @default
                                        No additional details available.
                                @endswitch
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
      </div>

    </div>
  </div>
  

  <!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
          <div class="modal-body text-center" style="padding: 10px !important;">
              <img id="modalImage" src="" class="img-fluid rounded">
          </div>
      </div>
  </div>
</div>


<div class="modal fade" id="cash-payment-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Token Payment <small class="badge bg-label-success">by cash</small></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 mb-3">            
            <h6 class="card-title m-0">Token details</h6>
            <p class=" mb-0">Token ID: {{$token->token}}</p>
            <p class=" mb-0">Service: {{ optional($token->service)->name}}</p>
            
          </div>

          <div class="col-lg-6 mb-3">
            <h6 class="card-title m-0">Customer details</h6>
            <div class="d-flex justify-content-start align-items-center mb-4">
              {{-- <div class="avatar me-2">
                <img src="{{ url('uploads').'/'.optional($token->user)->image }}" alt="Avatar" class="rounded-circle">
              </div> --}}
              <div class="d-flex flex-column">
                <a href="app-user-view-account.html" class="text-body text-nowrap">
                  <h6 class="mb-0">{{ optional($token->user)->name }}</h6>
                </a>
                <small class="text-muted"></small>
              </div>
            </div>
            <p class=" mb-0">PAN: {{ optional($token->user)->pan_no }}</p>
            <p class=" mb-0">Mobile: {{ optional($token->user)->phone }}</p>
            <p class=" mb-1">Email: {{ optional($token->user)->email }}</p>

          </div>

        </div>
        <form action="{{url('change-payment-status')}}" method="POST">
          @csrf
          <div class="row g-2 align-items-center">          
              <div class="col mb-0">  
                <input type="hidden" name="token_id" value="{{$token->id}}">          
                <select id="" class="select2 form-select token-status" name="payment_status" data-allow-clear="true">                
                  <option value="">Change Status</option>
                  <option value="1">Mark Paid</option>
                </select>
              </div>
              <div class="col mb-0">            
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="upi-payment-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Token Payment <small class="badge bg-label-success">by UPI</small></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 mb-3">            
            <h6 class="card-title m-0">Token details</h6>
            <p class=" mb-0">Token ID: {{$token->token}}</p>
            <p class=" mb-0">Service: {{ optional($token->service)->name}}</p>
            
          </div>

          <div class="col-lg-6 mb-3">
            <h6 class="card-title m-0">Customer details</h6>
            <div class="d-flex justify-content-start align-items-center mb-4">
              {{-- <div class="avatar me-2">
                <img src="{{ url('uploads').'/'.optional($token->user)->image }}" alt="Avatar" class="rounded-circle">
              </div> --}}
              <div class="d-flex flex-column">
                <a href="app-user-view-account.html" class="text-body text-nowrap">
                  <h6 class="mb-0">{{ optional($token->user)->name }}</h6>
                </a>
                <small class="text-muted"></small>
              </div>
            </div>
            <p class=" mb-0">PAN: {{ optional($token->user)->pan_no }}</p>
            <p class=" mb-0">Mobile: {{ optional($token->user)->phone }}</p>
            <p class=" mb-1">Email: {{ optional($token->user)->email }}</p>

          </div>

        </div>
        <form action="{{url('change-payment-status-upi')}}" method="POST">
          @csrf
          <div class="row g-2 align-items-center">          
              <div class="col mb-0">  
                <input type="hidden" name="token_id" value="{{$token->id}}">          
                <select id="" class="select2 form-select token-status" name="payment_status" data-allow-clear="true">                
                  <option value="">Change Status</option>
                  <option value="1">Mark Paid</option>
                </select>
              </div>
              <div class="col mb-0">            
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


@section('vendor_js')
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/vendor/libs/autosize/autosize.js"></script>
<script src="../../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
@endsection

@section('page_js')
<script src="../../assets/js/forms-file-upload.js"></script>
@endsection

  <!-- Edit User Modal -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
                        _token: '{{ csrf_token() }}',
                        page: 'view_token',
                    },
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Service has been deleted.',
                            'success'
                        ).then(function() {
                            location.href = "{{url('tokens')}}";
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your Service is safe :)',
                    'error'
                );
            }
        });
    }
</script>
@include('layouts.footer')
<script>
  function showImage(imageUrl) {
      // Set the src attribute of the modal image to the clicked image's URL
      document.getElementById('modalImage').src = imageUrl;
  }

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
<script>
  // Disable Dropzone auto-discovery
  Dropzone.autoDiscover = false;
  
  const profileImageDropzone = new Dropzone("#profile-image-dropzone", {
      url: "/", // No immediate upload
      autoProcessQueue: false,
      maxFiles: 1, // Only one file
      acceptedFiles: "image/*", // Images only
      addRemoveLinks: true, // Custom remove button
      previewTemplate: `
          <div class="dz-preview dz-file-preview" style="text-align: center;">
              <div class="dz-image" style="position: relative; width: 120px; height: 120px; margin: 0 auto;">
                  <img data-dz-thumbnail style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;" />
                  <div class="dz-success-icon" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="green" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7.2 11.5l4.6-5.6-.6-.5L7.2 10.1l-2-1.6-.6.5 2.6 2.5z"/>
                      </svg>
                  </div>
              </div>
              <div class="dz-details mt-2">
                  <div class="dz-filename" data-dz-name></div>
                  <div class="dz-size" data-dz-size></div>                
              </div>
          </div>
      `,
      init: function () {
          this.on("addedfile", function (file) {
            console.log(file);
              const reader = new FileReader();
              reader.onload = function (event) {
                  document.querySelector("#profile_image").value = event.target.result;
                  document.querySelector(".dz-success-icon").style.display = "block";
              };
              reader.readAsDataURL(file);
          });
      }
  });
  
</script>