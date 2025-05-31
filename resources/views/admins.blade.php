@section('title', 'Admins - CA CRM')
@section('description', 'Admins - CA CRM')
@section('keywords', 'Admins - CA CRM')
@section('manu', 'team')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  
  
  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Admins</h5>
        <a href="{{url('admin-add')}}" class="btn btn-primary waves-effect waves-light">Add Admin</a>
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
            <th>Username</th>
            <th>Mobile</th>
            <th>Email</th>            
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $team)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <div class="d-flex justify-content-start">                    
                    {{$team->fullname}}
                  </div>
                </td>
                <td>{{$team->mobile}}</td>
                <td>{{ $team->email }}</td>                
                <td>
                  <div class="d-flex">                    
                    <a href="{{route('admin.edit', ['admin'=>$team])}}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="edit"><i class="ti ti-pencil me-1"></i></a> | 
                    <a href="javascript:void(0);" onclick="myFunction({{$team->id}})"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a>
                                                                             
                  </div>
                    
                </td>
            </tr>    
            @endforeach
            
        </tbody>
      </table>
    </div>
  </div>

@section('page_js')
<script src="../../assets/js/app-access-roles.js"></script>
<script src="../../assets/js/modal-add-role.js"></script>
@endsection
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
                    url: "{{url('admin-delete')}}",
                    method: "POST",
                    data: {
                        user_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Admin has been deleted.',
                            'success'
                        ).then(function() {
                            window.location.reload();
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your Admin is safe :)',
                    'error'
                );
            }
        });
    }    

    </script>
@include('layouts.footer')