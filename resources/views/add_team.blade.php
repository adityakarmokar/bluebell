@section('title', 'Team/User - CA CRM')
@section('description', 'Team/User - CA CRM')
@section('keywords', 'Team/User - CA CRM')

@section('vendor_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
@endsection

@section('manu', 'team')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  


<div class="card mb-4">
    <h5 class="card-header">Add New Team Member</h5>
    <form class="card-body" method="POST" action="{{url('team-add')}}" enctype="multipart/form-data">
      @csrf
      
      <div class="row g-3">

        <div class="col-lg-6">
            <div class="row gap-2">
                <div class="col-md-12">
                    <label class="form-label" for="name">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="...." value="{{ old('username')}}" required />
                    @error('username')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="phone..." value="{{ old('phone')}}" />
                    @error('phone')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="email..." value="{{ old('email')}}" />
                    @error('email')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="form-alignment-password">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" id="form-alignment-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="form-alignment-password2" required />
                            <span class="input-group-text cursor-pointer" id="form-alignment-password2"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="service_details">About Member</label>
                    <textarea name="member_details" id="member_details" cols="30" rows="3" class="form-control" placeholder="Member Details...">{{ old('member_details')}}</textarea>
                    @error('member_details')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="col-12">
                <div class="card mb-4 mt-4">
                    <h5 class="card-header">Member Image</h5>
                  	<img src="{{ asset('uploads/teams_image.jpg') }}" alt="Teams" width="100%" height="320px">                    
                </div>
            </div>
        </div>

      <div class="pt-1">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Add</button>
        <a href="{{url('team')}}" class="btn btn-label-secondary">Cancel</a>
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
