@section('title', 'View User Tokens')
@section('description', 'View User Tokens')
@section('keywords', 'View User Tokens')

@section('vendor_css')

@endsection

@section('page_css')
@endsection

@section('manu', 'Users')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav') 


<div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">{{ $data->fname. " ".$data->mname. " ".$data->lname}}'s Token</h5>
        <a href="{{url('token-add')}}?user={{$data->id}}" class="btn btn-primary waves-effect waves-light">Generate Token</a>
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
            <th>Current status</th>
            <th>Active/Inactive</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php
              // dd($data);
          @endphp
            @foreach ($data->ca_tokens as $token)
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
                <td>{{$token->token}}
                  @if (in_array(5, $token_statuses))
                    <span class="badge rounded-pill bg-success bg-glow">Paid</span>                    
                  @endif   
                </td>                
                <td>{{ optional($token->service)->name}}</td>                
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
                      data-bs-original-title="View Token"><i class="ti ti-eye me-1"></i></a> @if(session('type') !== 'user') |     
                    <a href="javascript:void(0);" onclick="myFunction({{$token->id}})" 
                      data-bs-toggle="tooltip"
                      data-bs-placement="bottom"
                      data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> @endif | 
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

  @include('layouts.token_status_modal')

@section('page_js')
<script src="../../assets/js/app-user-view.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('main_js')
<script src="../../assets/js/main.js"></script>
@endsection

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
</script>
@include('layouts.footer')