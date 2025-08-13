@section('title', 'Announcemnts - CA CRM')
@section('description', 'Announcemnts - CA CRM')
@section('keywords', 'Announcemnts - CA CRM')

@section('page_css')

@endsection

@section('manu', 'Announcements')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Announcements</h5>      
        <a href="#" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#fullscreenModal">Add</a>  
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
            <th>Announcement</th>                        
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($announcements as $announcement)
          	<tr>
          		<td>{{ $loop->iteration }}</td>
                <td>{{ \Illuminate\Support\Str::limit($announcement->announcement, 120) }} </td>                            
                <td>
              		<div class="d-flex justify-content-start gap-2">
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ $announcement->status == 0 ? 'Send Notification' : 'Send Notification Again' }}"><button type="button" class="btn {{ $announcement->status == 0 ? 'btn-info' : 'btn-secondary' }} btn-sm" onclick="sendNotification({{$announcement->id}})"><i class="ti ti-bell me-1"></i></button></span>
                      	<span data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fullscreenModal" onclick="editFunction({{$announcement->id}})"><i class="ti ti-pencil me-1"></i></button></span>
                        <button type="button" class="btn btn-danger btn-sm" onclick="myFunction({{$announcement->id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="ti ti-trash me-1"></i></button>
                    </div>
              	</td>
          	</tr>          	          
          	@endforeach            
        </tbody>
      </table>
    </div>
  </div>

<div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen" role="document">
    <form id="announcementForm" method="post" action="{{ url('announcements') }}"> 
      @csrf
      <input type="hidden" id="announcementId" name="announcementId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFullTitle">Add Announcement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <textarea class="form-control" id="announcement" name="announcement" rows="25"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div> 
    </form>
  </div>
</div>
  
@include('layouts.footer')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
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
        url: "{{url('announcement-delete')}}",
        method: "POST",
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          swalWithBootstrapButtons.fire(
            'Deleted!',
            'Announcement has been deleted.',
            'success'
          ).then(function() {
            window.location.reload();
          });
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your announcement is safe :)',
        'error'
      );
    }
  });
}
  
function editFunction(id){
  
  $.ajax({
    url: "{{url('announcement-fetch')}}",
    method: "POST",
    data: {
      id: id,
      _token: '{{ csrf_token() }}'
    },
    success: function(response) {      
      $('#announcementId').val(response.data.id);
      $('#announcement').val(response.data.announcement);
    }
  });
  
}
  
function sendNotification(id){
  
  $.ajax({
    url: "{{url('announcement-notification')}}",
    method: "POST",
    data: {
      id: id,
      _token: '{{ csrf_token() }}'
    },
    success: function(response) {      
      if(response.status == true){
        toastr.success(response.message);
        setTimeout(function() {
            window.location.reload();
        }, 2000);        
      }else{
        toastr.error(response.message);
      }
    }
  });
  
}
  
  
</script>