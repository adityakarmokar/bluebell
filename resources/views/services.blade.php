@section('title', 'Services')
@section('description', 'Services description')
@section('keywords', 'Services description')
@section('manu', 'Services')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  


  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Services</h5>
        <a href="{{url('service-add')}}" class="btn btn-primary waves-effect waves-light">Add Service</a>
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
            <th>Name</th>
            <th>Service Icons</th>
            <th>STATUS</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $service)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$service->name}}</td>
                <td>
                  <img src="{{ asset('uploads')."/".$service->service_icons }}" alt="{{$service->name}}" width="100px" height="100px">
                  
                </td>
                <td>
                  <label class="switch">
                    <input type="checkbox" class="switch-input" {{$service->status == 1 ? 'checked' : ''}} id="status-toggle" onclick="toggleStatus({{ $service->id }})" />
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>   
                    {{-- <span class="switch-label">{{$service->status == 1 ? 'Active' : 'Inactive'}}</span>                  --}}
                  </label>
                </td>
                <td>
                  <div class="d-flex">    
                    <a href="{{route('service.edit', ['service'=>$service])}}"><i class="ti ti-pencil me-1"></i></a> @if(session('type') !== 'user') | 
                    
                    <a href="javascript:void(0);" onclick="myFunction({{$service->id}})"><i class="ti ti-trash me-1"></i></a> @endif                                                     
                  </div>
                    
                </td>
            </tr>    
            @endforeach
            
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
                    url: "{{url('service-delete')}}",
                    method: "POST",
                    data: {
                        user_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Service has been deleted.',
                            'success'
                        ).then(function() {
                            window.location.reload();
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
    
      function toggleStatus(userId) {
        $.ajax({
          url: '{{ route("service.toggleStatus", ":id") }}'.replace(':id', userId),
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
    </script>
@include('layouts.footer')