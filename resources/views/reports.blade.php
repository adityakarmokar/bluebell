@section('title', 'Reports')
@section('description', 'Reports description')
@section('keywords', 'Reports')
@section('manu', 'Reports')

@section('page_css')
<link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/pickr/pickr-themes.css" />
@endsection

@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  



@include('layouts.token_status_modal')
  
  <form action="{{url('reports')}}" method="GET" id="filter_form">
    <div class="d-flex justify-content-end ">
      <div class="col-md-4">

      </div>      
    <div class="input-group input-daterange" id="bs-datepicker-daterange">
        <input type="text" id="dateRangePicker" placeholder="MM/DD/YYYY" name="startDate" class="form-control" value="{{ request('startDate') }}" readonly />
        <span class="input-group-text">to</span>
        <input type="text" id="endDate" name="endDate" placeholder="MM/DD/YYYY" value="{{ request('endDate') }}" class="form-control" readonly />
    </div>
      
      <div class="m-1">                
        <select name="status" id="status" class="form-select">
          <option value="" >Choose One</option> 
          <option value="1" {{ request('status') == 1 ? 'selected' : ''}}>Token Generated</option>
          <option value="2" {{ request('status') == 2 ? 'selected' : ''}}>Return Data Validated</option>
          <option value="3" {{ request('status') == 3 ? 'selected' : ''}}>Return Not Filed / Not Finalized</option> 
          <option value="4" {{ request('status') == 4 ? 'selected' : ''}}>Return Not Filed / Finalized</option> 
          <option value="5" {{ request('status') == 5 ? 'selected' : ''}}>Payments Completed / Ready to File</option>
          <option value="6" {{ request('status') == 6 ? 'selected' : ''}}>Returns Filed - Not Verified</option> 
          <option value="7" {{ request('status') == 7 ? 'selected' : ''}}>Return Filed - Verified</option> 
          <option value="8" {{ request('status') == 8 ? 'selected' : ''}}>Documents Delivered</option>                
        </select>                  
        @if ($errors->has('from_date'))
            <span style="color: red">
                {{ $errors->first('from_date') }}
            </span>
        @endif
      </div>         
      <div class="submit_filter d-flex gap-1">           
        <button type="submit" class="btn btn-primary">Apply</button>                  
        <button type="button" class="btn btn-secondary" id="reset_filter">Reset</button>                  
      </div> 
    </div>
  </form>
  <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
    <div class="col-md-4 user_role"></div>
    <div class="col-md-4 user_plan"></div>
    <div class="col-md-4 user_status"></div>
  </div>

  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">Reports</h5>        
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
            <th>PAN CARD</th>
            <th>Current status</th>
            {{-- <th>Active/Inactive</th> --}}
            {{-- <th>Actions</th> --}}
          </tr>
        </thead>
        <tbody>
            @if ($data != null)                
                @foreach ($data as $token)
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
                    <td>{{optional($token->user)->fname." ".optional($token->user)->mname." ".optional($token->user)->lname}}</td>
                    <td> {{ optional($token->user)->pan_no }} </td>
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
                            <span class="badge badge-dot border border-2 p-2" style="background-color: #0558e876;"></span>&nbsp;Return Not Filed / Finalized 
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
                    {{-- <td>
                    <label class="switch">
                        <input type="checkbox" class="switch-input status-toggle" {{$token->is_active == 1 ? 'checked' : ''}} id="status-toggle" data-id="{{$token->id}}" />
                        <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                        </span>   
                        <span class="switch-label {{$token->is_active == 1 ? 'text-success' : 'text-danger'}}">{{$token->is_active == 1 ? 'Active' : 'Inactive'}}</span>                 
                    </label>
                    </td> --}}                
                    
                </tr>    
                @endforeach
            @endif
            
        </tbody>
      </table>
      
    </div>
  </div>

@section('main_js')
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
<script src="{{ asset('assets/js/forms-pickers.js') }}"></script>
@endsection

<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    
    // Send a POST request using jQuery's ajax or fetch
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
                    }
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

      // $('.token-status').on('change', function(){
      //   var status = $(this).val();
      //   var token = $(this).data('token');

      //   $.ajax({
      //     url: "{{route('token.change.status')}}", 
      //     method: 'POST',
      //     data: {
      //       _token: '{{ csrf_token() }}',
      //       token: token, 
      //       status: status,
      //     },
      //     success: function(response)
      //     {
      //       if(response.status == true){
      //         toastr.success(response.message);
      //         setTimeout(function() {                                    
      //             window.location.reload();
      //         }, 3000);
      //       }else if(response.status == false){
      //         toastr.error(response.message);
      //       }
      //     }
      //   });
      // });
      
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

    $('#reset_filter').on('click', function(){
      $('#status').val('');      

      location.href = "{{url('reports')}}";
    });
    </script>

@include('layouts.footer')