@section('title', 'Banners')
@section('description', 'Banners')
@section('keywords', 'Banners')

@section('vendor_css')
@endsection

@section('page_css')
<link rel="stylesheet" href="../../assets/vendor/libs/sweetalert2/sweetalert2.css" />

@endsection

@section('manu', 'banners')
@include('layouts.header')

@include('layouts.sidebar')      
@include('layouts.nav') 

  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Banners</h5>
        <a href="{{url('team-add')}}" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#basicModal">Add Banner</a>
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
            <th>Banner</th>
            <th>alt</th>            
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
           @foreach($banners as $banner)
          <tr>
          	<td>{{ $loop->iteration }}</td>
            <td>
            	<img src="{{ asset('uploads/'. $banner->banners) }}" alt="{{ $banner->alt }}" width="200px">
            </td>
            <td>{{ $banner->alt }}</td>
            <td>
            	<a href="javascript:void(0);" onclick="myFunction({{$banner->id}})"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="Delete"><i class="ti ti-trash me-1 text-xl" style="font-size:2rem;"></i></a>
            </td>
          </tr>
           @endforeach
            
        </tbody>
      </table>
    </div>
  </div>

<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ url('update-banners')}}" method="POST" enctype="multipart/form-data">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Banner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="nameBasic" class="form-label">Banner</label>
            <input type="file" id="banner" name="banner" class="form-control" placeholder="Enter Name">
          </div>
        </div>
        <div class="row g-2">
          <div class="col mb-0">
            <label for="emailBasic" class="form-label">ALT</label>
            <input type="text" id="alt" name="alt" class="form-control" placeholder="image name">
          </div>          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>


@section('vendor_js')

@endsection

<!-- Page JS -->
@section('page_js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection


@include('layouts.footer')
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
          url: "{{url('banner-delete')}}",
          method: "POST",
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            swalWithBootstrapButtons.fire(
              'Deleted!',
              'Banner has been deleted.',
              'success'
            ).then(function() {
              window.location.reload();
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          'Cancelled',
          'Your banner is safe :)',
          'error'
        );
      }
    });
  }
</script>