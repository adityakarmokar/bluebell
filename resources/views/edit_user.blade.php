@section('title', 'Edit / View User')
@section('description', 'Edit / View User Details')
@section('keywords', 'Edit / View User Details')

@section('vendor_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
@endsection

@section('page_css')
<style>
  
</style>
@endsection

@section('manu', 'Users')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav') 

<style>
  .kcustom-align-center {
      display: flex;
      justify-content: start !important;
      align-items: center;
  }
  .kcustom-align-center h6,
  .kcustom-align-center label {
      margin-bottom: 0;
  }

  .ck-editor__editable_inline {
      min-height: 200px; /* Adjust height as needed */
  }
  a.btn.btn-primary.waves-effect.waves-light{
      color: #fff;
  }

</style>
<!-- Multi Column with Form Separator -->
  
<div class="row">
  <div class="col-md-12 d-flex justify-content-end mb-3 gap-2">
    <a href="{{route('view_user_token', ['user'=>$data])}}" class="btn btn-primary">Tokens</a>
    <a href="{{route('user_ledger', ['user'=>$data])}}" class="btn btn-info">Ledger</a>
  </div>
</div>
<div class="card mb-4">
    <h5 class="card-header">Edit / View User</h5>
    <form class="card-body" id="user_form" method="POST" action="{{route('user.update', ['user'=>$data])}}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" name="user_id" value="{{$data->id}}">
      <!-- Dropzone Component -->
      <h6>1. Personal Info</h6>
      <div class="row g-3">

        <div class="col-md-4">
          <label class="form-label" for="pan_no">PAN No</label>
          <input type="text" name="pan_no" id="pan_no" class="form-control k-readonly" placeholder="AB367JK12" value="{{ $data->pan_no }}" required readonly />
          <span style="color: green" id="pan_no_validation"></span>
          @error('pan_no')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="dob">Birth Date</label>
          <input type="text" name="dob" id="dob1" class="form-control" placeholder="DD-MM-YYYY" value="{{ \Carbon\Carbon::parse($data->dob)->format('d-m-Y') }}" required />
          @error('dob')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="adhar_number">Adhar No</label>
          <input type="text" name="adhar_number" id="adhar_number" class="form-control k-readonly" placeholder="12XX23XX45XX56" value="{{ $data->adhar_number }}" required readonly />
          <span style="color: green" id="aadhar_validation"></span>
          @error('adhar_number')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-1" style="align-content:center;">
          <label class="form-label" for="adhar_number">Name: </label>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="name">First</label>
          <input type="text" name="fname" id="fname" class="form-control" value="{{ $data->fname }}" />
          @error('fname')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="name">Mid</label>
          <input type="text" name="mname" id="mname" class="form-control" value="{{ $data->mname }}" />
          @error('mname')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-3">
          <label class="form-label" for="name">Last</label>
          <input type="text" name="lname" id="lname" class="form-control" value="{{ $data->lname }}" required />
          @error('lname')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-1" style="align-content:center;">
          <label class="form-label" for="adhar_number">Father's Name: </label>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="name">First</label>
          <input type="text" name="f_fname" id="f_fname" class="form-control" value="{{ $data->f_fname }}" />
          @error('f_fname')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="name">Mid</label>
          <input type="text" name="f_mname" id="f_mname" class="form-control" value="{{ $data->f_mname }}" />
          @error('f_mname')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-3">
          <label class="form-label" for="name">Last</label>
          <input type="text" name="f_lname" id="f_lname" class="form-control" value="{{ $data->f_lname }}" required />
          @error('f_lname')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="phone">Phone No</label>
          <div class="input-group">   
            <span class="input-group-text">IN (+91)</span>  
            <input type="number" name="phone" id="phone" class="form-control k-readonly" value="{{ $data->phone }}" required readonly />            
          </div>
          <span style="color: green" id="phoner_validation"></span>
          @error('phone')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="phone">Mobile No</label>
          <div class="input-group">            
            <span class="input-group-text">IN (+91)</span>
            <input type="number" name="mobile" id="mobile" class="form-control" value="{{ $data->mobile }}"  />
          </div>
          @error('mobile')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>
                
        <div class="col-md-4">
          <label class="form-label" for="email">Email</label>
          <input type="text" name="email" id="email" class="form-control" value="{{ $data->email }}" required />
          @error('email')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>
        
      </div>

      <div class="row">
        <hr class="my-4 mx-n4" />
        <h6>2. Address</h6>

        <div class="col-md-4">
          <label class="form-label" for="house_no">HOUSE NO</label>
          <input type="text" name="house_no" id="house_no" class="form-control" placeholder="" value="{{ optional($data->userAddress)->house_no }}" />
          @error('house_no')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">HOUSE NAME</label>
          <input type="text" name="house_name" id="house_name" class="form-control" placeholder="" value="{{ optional($data->userAddress)->house_name }}" />
          @error('house_name')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">STREET</label>
          <input type="text" name="street" id="street" class="form-control" placeholder="" value="{{  optional($data->userAddress)->street }}" />
          @error('street')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">AREA</label>
          <input type="text" name="area" id="area" class="form-control" placeholder="" value="{{ optional($data->userAddress)->area }}" />
          @error('area')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">CITY</label>
          <input type="text" name="city" id="city" class="form-control" placeholder="" value="{{  optional($data->userAddress)->city }}" required />
          @error('city')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">STATE</label>
          <input type="text" name="state" id="state" class="form-control" placeholder="" value="{{ optional($data->userAddress)->state }}" required />
          @error('state')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">COUNTRY</label>
          <input type="text" name="country" id="country" class="form-control" placeholder="" value="{{  optional($data->userAddress)->country }}" required />
          @error('country')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="house_no">PIN CODE</label>
          <input type="text" name="pin_code" id="pin_code" class="form-control" placeholder="" value="{{ optional($data->userAddress)->pin_code }}" required />
          @error('pin_code')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row"><br></div>
      <div class="row">

        <div class="col-md-12">
          <div class="d-flex kcustom-align-center">
            <h6>
              Office Address: 
            </h6>  
            &nbsp;&nbsp;<input type="checkbox" name="office_check" id="office_check" value="1" {{optional($data->userAddress)->office_check == 1 ? 'checked' : '' }} /> &nbsp;&nbsp;&nbsp;
            <label for="">Same as Above</label>          
          </div>          
        </div>
      </div>

    <div id="office-div" style="display:{{optional($data->userAddress)->office_check == 1 ? 'none' : 'block' }}">
      <br>
      <div class="row">
          <div class="col-md-4">
            <label class="form-label" for="house_no">HOUSE NO</label>
            <input type="text" name="office_house_no" id="office_house_no" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_house_no }}" />
            @error('office_house_no')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">HOUSE NAME</label>
            <input type="text" name="office_house_name" id="office_house_name" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_house_name }}" />
            @error('office_house_name')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">STREET</label>
            <input type="text" name="office_street" id="office_street" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_street }}" />
            @error('office_street')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">AREA</label>
            <input type="text" name="office_area" id="office_area" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_area }}" />
            @error('office_area')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">CITY</label>
            <input type="text" name="office_city" id="office_city" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_city }}" />
            @error('office_city')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">STATE</label>
            <input type="text" name="office_state" id="office_state" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_state }}" />
            @error('office_state')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">COUNTRY</label>
            <input type="text" name="office_country" id="office_country" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_country }}" />
            @error('office_country')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-4">
            <label class="form-label" for="house_no">PIN CODE</label>
            <input type="text" name="office_pin_code" id="office_pin_code" class="form-control" placeholder="" value="{{ optional($data->userAddress)->office_pin_code }}" />
            @error('office_pin_code')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>        
      </div> 
    </div>

      <hr class="my-4 mx-n4" />
      <h6>2. Bank Account Details</h6>
      <div class="form-repeater">
      
        <div data-repeater-list="group-a">

          @foreach ($data->userBankAccountDetail as $userBankAccountDetail)              
          <div data-repeater-item>
            <div class="row g-3">        
              <div class="col-md-6">
                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label" for="form-repeater-1-1">NAME OF BANK</label>
                  <div class="col-sm-9">
                    <input type="text" name="group-a[1][bank_name]" id="form-repeater-1-1" class="form-control" placeholder="e.g., HDFC" value="{{ $userBankAccountDetail->bank_name }}" required />
                  </div>
                  @error('bank_name')
                  <span style="color: red">{{ $message }}</span>
                  @enderror
                </div>
              </div>
  
              <div class="col-md-6">
                
              </div>
  
              <div class="col-md-9">
                <div class="row mb-3">
                  <label class="col-sm-4 col-form-label" for="form-repeater-1-1">ADDRESS OF BANK BRANCH</label>
                  <div class="col-sm-6">            
                    <input type="text" name="group-a[1][branch]" id="form-repeater-1-1" class="form-control" placeholder="New Delhi" value="{{ $userBankAccountDetail->branch }}" required />
                  </div>
                  @error('branch')
                  <span style="color: red">{{ $message }}</span>
                  @enderror
                </div>
              </div>
  
              <div class="col-md-4">
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="form-repeater-1-1">IFSC</label>
                  <div class="col-sm-9">
                    <input type="text" name="group-a[1][ifsc]" id="form-repeater-1-1" class="form-control ifsc" placeholder="HDFC001" value="{{ $userBankAccountDetail->ifsc }}" required />
                    @error('ifsc')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
  
              <div class="col-md-6">
                <div class="row mb-3">
                  <label class="col-sm-4 col-form-label" for="form-repeater-1-1">RE-CONFIRM IFSC</label>
                  <div class="col-sm-6">
                    <input type="text" name="group-a[1][re_ifsc]" id="form-repeater-1-1" class="form-control ifsc" placeholder="HDFC001" value="{{ $userBankAccountDetail->ifsc }}" required />
                    @error('re_ifsc')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
  
              <div class="col-md-8">
                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label" for="form-repeater-1-1">TYPE OF ACCOUNT</label>
                  <div class="col-sm-8">
                    <select name="group-a[1][account_type]" id="form-repeater-1-1" class="form-control" required>
                      <option value="">-- Choose One -- </option>
                      <option value="Savings Account" {{ $userBankAccountDetail->account_type == 'Savings Account' ? 'selected' : '' }}>Savings Account</option>
                      <option value="Current Account" {{ $userBankAccountDetail->account_type == 'Current Account' ? 'selected' : '' }}>Current Account</option>
                      <option value="Salary Account" {{ $userBankAccountDetail->account_type == 'Salary Account' ? 'selected' : '' }}>Salary Account</option>
                      <option value="NRI Account" {{ $userBankAccountDetail->account_type == 'NRI Account' ? 'selected' : '' }}>NRI Account</option>                
                    </select>              
                    @error('account_type')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
  
              <div class="col-md-6">
                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label" for="form-repeater-1-1">ACCOUNT NO</label>
                  <div class="col-sm-8">
                    <input type="text" name="group-a[1][account_no]" id="form-repeater-1-1" class="form-control" placeholder="12253XX438548XX" value="{{ $userBankAccountDetail->account_no }}" required />
                    @error('account_no')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
  
              <div class="col-md-6">
                <div class="row mb-3">
                  <label class="col-sm-4 col-form-label" for="form-repeater-1-1">RE-CONFIRM A/C No.</label>
                  <div class="col-sm-8">
                    <input type="text" name="group-a[1][re_account_no]" id="form-repeater-1-1" class="form-control" placeholder="12253XX438548XX" value="{{ $userBankAccountDetail->account_no }}" required />
                    @error('re_account_no')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
  
              
              <div class="mb-3 col-md-12 d-flex align-items-center justify-content-end">
                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                    <i class="ti ti-x ti-xs me-1"></i>
                    <span class="align-middle">Delete</span>
                </button>
              </div>
              
            </div>
          </div>                  
          @endforeach

        </div>
        <div class="mb-0">
            <a class="btn btn-primary" data-repeater-create>
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">ADD ANOTHER BANK ACCOUNT</span>
            </a>
        </div><br>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="income_tax_password">Income Tax Password</label>
            <div class="col-sm-7 form-password-toggle">
              <div class="input-group input-group-merge">                
                <input type="password" name="income_tax_password" id="income_tax_password" class="form-control" placeholder="" value="{{ $data->userBankAccountDetail->isNotEmpty() ? optional($data->userBankAccountDetail)->first()->income_tax_password : '' }}" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
              @error('income_tax_password')
              <span style="color: red">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
      </div>

      {{-- <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header">Profile Image</h5>
            <div class="card-body">                
                <div class="dropzone needsclick" id="profile-image-dropzone">
                  <img src="{{url('uploads')}}{{'/'.$data->image}}" alt="" height="150px" width="150px">
                    <div class="dz-message needsclick text-center">
                        <p>Drop files here or click to upload</p>
                        <span class="note needsclick">(Selected files are added to the form and submitted together.)</span>
                    </div>
                </div>
                <!-- Hidden input to store file data -->
                <input type="hidden" name="image" id="profile_image">                  
            </div>
        </div>
      </div> --}}
      
      <hr class="my-4 mx-n4" />
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
        <a href="{{url('users')}}" class="btn btn-label-secondary">Cancel</a>
      </div>
    </form>
</div>

<!-- Vendors JS -->
@section('vendor_js')
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
@endsection

@section('main_js')
<script src="../../assets/js/main.js"></script>
@endsection

<!-- Page JS -->
@section('page_js')
<script src="../../assets/js/forms-file-upload.js"></script>
<script src="../../assets/js/forms-extras.js"></script>
@endsection



<script>
    $(document).ready(function(){

        $('input[name^=doc_type]').on('change', function(){
            var type = $(this).val();

            if(type == 'salaried'){
                $('#form16a').css('display', 'none');
                $('#bank_statement').css('display', 'none');
                $('#bills').css('display', 'none');
            }else if(type == 'business'){
                $('#form16a').css('display', 'block');
                $('#bank_statement').css('display', 'block');
                $('#bills').css('display', 'block');
            }
        });

        $('input[type^=checkbox]').on('click', function(){

          if ($(this).is(':checked')) {
            $('#office-div').fadeOut(); 
          } else {
              $('#office-div').fadeIn(); 
          }

        }); 

    });

    $(document).on('keyup', '.ifsc', function () {
      $(this).val($(this).val().toUpperCase());
    });

</script>

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

document.getElementById('dob1').addEventListener('input', function (e) {
    let value = e.target.value.replace(/[^0-9]/g, ''); 
    if (value.length > 2) value = value.slice(0, 2) + '-' + value.slice(2);
    if (value.length > 5) value = value.slice(0, 5) + '-' + value.slice(5);
    e.target.value = value;
});
</script>