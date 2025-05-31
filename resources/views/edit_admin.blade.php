@section('title', 'Edit Admins - CA CRM')
@section('description', 'Edit Admins - CA CRM')
@section('keywords', 'Edit Admins - CA CRM')

@section('vendor_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
@endsection

@section('manu', 'team')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  


<div class="card mb-4">
    <h5 class="card-header">Edit/View Admin</h5>
    <form class="card-body" method="POST" action="{{route('admin.update', ['admin'=>$admin])}}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row g-3">

        <div class="col-lg-12">
            <div class="row gap-2">
                <div class="col-md-12">
                    <label class="form-label" for="name">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="...." value="{{ $admin->fullname }}" required />
                    @error('username')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="phone..." value="{{ $admin->mobile }}" required />
                    @error('phone')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="email..." value="{{ $admin->email }}" required />
                    @error('email')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="form-alignment-password">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" id="form-alignment-password" value="" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="form-alignment-password2" />                            
                        </div>
                    </div>
                </div>                
            </div>
        </div>

      <div class="pt-1">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
        <a href="{{url('admins')}}" class="btn btn-label-secondary">Cancel</a>
      </div>
    </form>
</div>

<!-- Vendors JS -->
@section('vendor_js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/vendor/libs/autosize/autosize.js"></script>
<script src="../../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>

@endsection

<!-- Page JS -->
@section('page_js')
<script src="../../assets/js/forms-file-upload.js"></script>
@endsection

@section('main_js')
<script src="../../assets/js/main.js"></script>
@endsection

@include('layouts.footer')
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