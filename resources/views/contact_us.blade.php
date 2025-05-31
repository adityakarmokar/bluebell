@section('title', 'contact-us - CA CRM')
@section('description', 'contact-us - CA CRM')
@section('keywords', 'contact-us - CA CRM')

@section('vendor_css')
@endsection

@section('page_css')
@endsection

@section('manu', 'contact-us')
@include('layouts.header')

@include('layouts.sidebar')      
@include('layouts.nav') 


<div class="card mb-4">
  <h5 class="card-header">Update Contact Details</h5>
  <form class="card-body" method="POST" action="{{url('update-contact-us')}}">
    @csrf                                  
    <div class="row">
        <div class="mb-3 col-lg-12 mb-0">
            <label class="form-label" for="form-repeater-1-1">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="email.." value="{{$contact_details->email}}" />
            <small id="email-error" class="text-danger"></small>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-3 col-lg-12 mb-0">
            <label class="form-label" for="form-repeater-1-1">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{$contact_details->phone}}" minlength="10" maxlength="18">    
            @error('phone')
                <span style="color: red;">{{ $message }}</span>
            @enderror                      
        </div>
        <div class="mb-3 col-lg-12 mb-0">
          <label class="form-label" for="form-repeater-1-1">Whatsapp Number</label>
          <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{$contact_details->whatsapp}}" minlength="10" maxlength="14">    
          @error('whatsapp')
              <span style="color: red;">{{ $message }}</span>
          @enderror                      
      </div>                      
    </div>                

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>      
    </div>
  </form>
</div>


@section('vendor_js')
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/vendor/libs/autosize/autosize.js"></script>
<script src="../../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
<script src="../../assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
@endsection

<!-- Page JS -->
@section('page_js')
<script src="../../assets/js/forms-file-upload.js"></script>
<script src="../../assets/js/forms-extras.js"></script>
@endsection

@section('main_js')
<script>

  document.querySelector('#phone').addEventListener('input', function (event) {
    // const input = event.target;
    // const value = input.value.replace(/\D/g, ''); // Remove non-digit characters
    // if (value.length > 3) {
    //   input.value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
    // } else {
    //   input.value = value;
    // }
  });

  document.querySelector('form').addEventListener('submit', function (event) {
    const phoneInput = document.querySelector('#phone');
    const phoneNumber = phoneInput.value;
    // if (!/^\d{3}-\d{3}-\d{4}$/.test(phoneNumber)) {
    //   event.preventDefault();
    //   alert('Please enter a valid phone number between 10 and 15 digits.');
    // }
  });

  document.querySelector('#email').addEventListener('keyup', function () {
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      const errorMessage = document.querySelector('#email-error');

      if (!emailPattern.test(this.value)) {
          errorMessage.textContent = 'Invalid email format.';
          this.classList.add('is-invalid');
      } else {
          errorMessage.textContent = '';
          this.classList.remove('is-invalid');
      }
  });


</script>

@endsection

@include('layouts.footer')

