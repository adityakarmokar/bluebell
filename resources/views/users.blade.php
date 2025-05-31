@section('title', 'Users - CA CRM')
@section('description', 'Users - CA CRM')
@section('keywords', 'Users - CA CRM')

@section('page_css')

@endsection

@section('manu', 'Users')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

  <!-- Users List Table -->
  <form action="{{url('users')}}" method="GET" id="filter_form">
    <div class="d-flex justify-content-end">
      <div class="m-3">          
        <div class="input-group input-daterange" id="bs-datepicker-daterange">
          <input type="date" id="from_date" name="from_date" placeholder="From" class="form-control" value="{{ request('from_date') }}">
          <span class="input-group-text">to</span>
          <input type="date" id="to_date" name="to_date" placeholder="To" class="form-control" value="{{ request('to_date') }}">
        </div>
        @if ($errors->has('from_date') || $errors->has('to_date'))
            <span style="color: red">
                {{ $errors->first('from_date') ?: $errors->first('to_date') }}
            </span>
        @endif
      </div>        
      <div class="submit_filter">           
        <button type="submit" class="btn btn-primary">Apply</button>                  
        <button type="button" class="btn btn-secondary" id="reset_filter">Reset</button>                  
      </div> 
    </div>
  </form>

  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Users</h5>
        <a href="{{url('user-add')}}" class="btn btn-primary waves-effect waves-light">Add User</a>
      </div>
      
      <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
        <div class="col-md-4 user_role"></div>
        <div class="col-md-4 user_plan"></div>
        <div class="col-md-4 user_status"></div>
      </div>
      <div class="datatables-buttons-container" id="datatables-buttons-container">

      </div>
    </div>
    <div class="card-datatable text-nowrap" style="margin: auto 2%">
      <table class="table" id="k-usersTable">
        <thead class="border-top">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>email</th>
            <th>PAN NO.</th>
            <th>Created At</th>
            <th>STATUS</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            
            
        </tbody>
      </table>
    </div>
  </div>
  


<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    url: "{{url('user-delete')}}",
                    method: "POST",
                    data: {
                        user_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'User has been deleted.',
                            'success'
                        ).then(function() {
                            window.location.reload();
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your user is safe :)',
                    'error'
                );
            }
        });
    }

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
          },
          error: function() {
            toastr.error('There was an error updating the status.');
          }
        });
      }

    $('#reset_filter').on('click', function(){
      $('#from_date').val('');
      $('#to_date').val('');

      location.href = "{{url('users')}}";
    });
    
    
    $(document).ready(function(){

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
      
      $('#k-usersTable').DataTable({
            ...tableConfig,
            ajax: {
                url: '{{ url("users") }}', 
                type: 'GET',
                data: function(d) {                    
                    d.from_date = $('#status').val();
                    d.date = $('#date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id' }, 
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' }, 
                { data: 'email', name: 'email' },      
                { data: 'pan_no', name: 'pan_no' }, 
                { data: 'created_at', name: 'created_at' }, 
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
@include('layouts.footer')