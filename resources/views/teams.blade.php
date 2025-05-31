@section('title', 'Team/User - CA CRM')
@section('description', 'Team/User - CA CRM')
@section('keywords', 'Team/User - CA CRM')
@section('manu', 'team')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

  <div class="d-flex justify-content-end mb-3">
    <a href="{{url('admins')}}" class="btn btn-primary waves-effect waves-light">All Admins</a>
  </div>
  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Team Member</h5>
        <a href="{{url('team-add')}}" class="btn btn-primary waves-effect waves-light">Add Team</a>
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
            <th>STATUS</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $team)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <div class="d-flex justify-content-start">
                    <div class="avatar">
                      <img src="{{ asset('uploads/teams_image.jpg') }}" alt="" class="rounded-circle">
                    </div>
                    {{$team->username}}
                  </div>
                </td>
                <td>{{$team->phone}}</td>
                <td>{{ $team->email }}</td>
                <td>
                  <label class="switch">
                    <input type="checkbox" class="switch-input" {{$team->is_active == 1 ? 'checked' : ''}} id="status-toggle" onclick="toggleStatus({{ $team->id }})" />
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>   
                    {{-- <span class="switch-label">{{$service->status == 1 ? 'Active' : 'Inactive'}}</span>                  --}}
                  </label>
                </td>
                <td>
                  <div class="d-flex">
                    <a href="javascript:void(0);"
                        data-bs-toggle="modal" data-bs-target="#addRoleModal" onclick="updateModal('{{$team->id}}', '{{$team->username}}', {{$team->permissions}})"><i class="ti ti-adjustments-pause"></i></a> |                           
                    <a href="{{route('team.edit', ['team'=>$team])}}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="edit"><i class="ti ti-pencil me-1"></i></a> @if(session('type') !== 'user') | 
                    <a href="javascript:void(0);" onclick="myFunction({{$team->id}})"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></a> @endif
                                                                             
                  </div>
                    
                </td>
            </tr>    
            @endforeach
            
        </tbody>
      </table>
    </div>
  </div>
  

  <!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
      <div class="modal-content p-3 p-md-5">
        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body">
          <div class="text-center mb-4">
            <h3 class="role-title mb-2">Member Permission</h3>            
          </div>
          <!-- Add role form -->
          <form id="permissionsForm" class="row g-3" method="POST" action="{{url('update-permissions')}}">
            @csrf
            <input type="hidden" id="permissionsetid" name="id" value="">
            <div class="col-12 mb-4">
              <label class="form-label" for="modalRoleName">User</label>
              <input type="text" id="modalRoleName" name="username" class="form-control" placeholder="..." tabindex="-1" readonly />
            </div>
            <div class="col-12">              
              <!-- Permission table -->
              <div class="table-responsive">
                <table class="table table-flush-spacing">
                  <tbody>
                    <tr>
                      <td></td>                                            
                      <td>
                        <div class="form-check d-flex justify-content-end">
                          <input class="form-check-input" type="checkbox" id="selectAll" />
                          <label class="form-check-label" for="selectAll">
                            Select All
                          </label>
                        </div>
                      </td>
                    </tr>
                    {{-- <tr>
                      <td class="text-nowrap fw-medium">Dashboard 2</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="dashboard2" name="dashboard2" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr> --}}
                    <tr>
                      <td class="text-nowrap fw-medium">Search Client</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="search_client" name="search_client" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">Services Management</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="services" name="services" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">Search Token</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="search_token" name="search_token" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">Payments</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="payments" name="payments" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">Reports</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="reports" name="reports" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">Announcements</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="announcements" name="announcements" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">Team/Users</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="team_users" name="team_users" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-nowrap fw-medium">CMS</td>
                      <td>
                        <div class="d-flex justify-content-end">
                          <div class="form-check me-3 me-lg-5">
                            <input class="form-check-input" type="checkbox" id="cms" name="cms" />                            
                          </div>                          
                        </div>
                      </td>
                    </tr>                    
                  </tbody>
                </table>
              </div>
              <!-- Permission table -->
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
              <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
          </form>
          <!--/ Add role form -->
        </div>
      </div>
    </div>
</div>
<!--/ Add Role Modal -->

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
                    url: "{{url('team-delete')}}",
                    method: "POST",
                    data: {
                        user_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Team has been deleted.',
                            'success'
                        ).then(function() {
                            window.location.reload();
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your Team is safe :)',
                    'error'
                );
            }
        });
    }
    
      function toggleStatus(userId) {
        $.ajax({
          url: '{{ route("team.toggleStatus", ":id") }}'.replace(':id', userId),
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
      
      function updateModal(id, username, permissions){        
        $('#modalRoleName').val(username);
        $('#permissionsetid').val(id);
        
        $.each(permissions, function(key, value) {
            if (value === 1) {
                $('#' + key).prop('checked', true);
            } else {
                $('#' + key).prop('checked', false);
            }
        });

      }

    </script>
@include('layouts.footer')