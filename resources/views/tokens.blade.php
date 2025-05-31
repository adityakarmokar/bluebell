@section('title', 'Tokens')
@section('description', 'Tokens description')
@section('keywords', 'Tokens')
@section('manu', 'Tokens')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

@include('layouts.token_status_modal')
  <!-- Users List Table -->
  {{-- <button type="button" class="btn- btn-primary" data-bs-toggle="modal" data-bs-target="#tokenStatusChangeModal">Check Modal</button> --}}
  <form action="{{url('tokens')}}" method="GET" id="filter_form">
    <div class="d-flex justify-content-end ">
      <div class="col-md-4">

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
      <div class="m-1"> 
        <input type="text" name="date" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" value="{{request('date')}}" />
      </div>        
      <div class=" submit_filter">           
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
        <h5 class="card-title mb-3">All Token</h5>
        <a href="{{url('token-add')}}" class="btn btn-primary waves-effect waves-light">Generate Token</a>
      </div>
      
      <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
        <div class="col-md-4 user_role"></div>
        <div class="col-md-4 user_plan"></div>
        <div class="col-md-4 user_status"></div>
      </div>
    </div>
    <div class="card-datatable text-nowrap" style="margin: auto 2%">
      <table class="table" id="tokensTable">
        <thead class="border-top">
          <tr>
            <th>#</th>
            <th>Token</th>
            <th>Service opted</th>
            <th>User</th>
            <th>PAN CARD</th>
            <th>Current status</th>
            {{-- <th>Active/Inactive</th> --}}
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            
        </tbody>
      </table>
      
    </div>
  </div>

@section('vendor_js')
{{-- <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script> --}}
<script src="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="../../assets/vendor/libs/pickr/pickr.js"></script>
<script src="../../assets/js/forms-pickers.js"></script>
@endsection

<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $(document).ready(function() {
        
      var userType = window.userType;	
      
      var tableConfig = {
	      "processing": true,
          "responsive": true,
          "serverSide": true, 
          "ordering": true,
          "paging": true,        
      };
      
      if (userType !== 'user') {
          tableConfig.dom = 'Bfrtip';
          tableConfig.buttons = [
              {
                  extend: 'copyHtml5',
                  text: 'Copy'
              },
              {
                  extend: 'excelHtml5',
                  text: 'Export to Excel'
              },
              {
                  extend: 'csvHtml5',
                  text: 'Export to CSV'
              },
              {
                  extend: 'pdfHtml5',
                  text: 'Export to PDF',
                  orientation: 'portrait',
                  pageSize: 'A4'
              },
              {
                  extend: 'print',
                  text: 'Print'
              }
          ];
      }
      
        $('#tokensTable').DataTable({
            ...tableConfig,
            ajax: {
                url: '{{ url("tokens") }}', 
                type: 'GET',
                data: function(d) {                    
                    d.status = $('#status').val();
                    d.date = $('#date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id' }, 
                { data: 'token', name: 'token' },
                { data: 'service.name', name: 'service.name' }, 
                { data: 'full_name', name: 'full_name' },      
                { data: 'user.pan_no', name: 'user.pan_no' }, 
                {
                    data: 'status',
                    name: 'status',
                    type: 'html',
                    render: function(data, type, row){
                        return data;
                    }
                }, 
                {
                    data: 'actions',
                    name: 'actions',
                    type: 'html',
                    render: function(data, type, row){
                        return data;
                    }
                }                               
            ]
        });
  
  		if (userType !== 'user') {
          $('.buttons-copy').addClass('btn btn-sm btn-primary');
          $('.buttons-csv').addClass('btn btn-sm btn-primary');
          $('.buttons-pdf').addClass('btn btn-sm btn-primary');
          $('.buttons-print').addClass('btn btn-sm btn-primary');
        }
  
    });

</script>

  <script>
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

      location.href = "{{url('tokens')}}";
    });
    </script>

@include('layouts.footer')