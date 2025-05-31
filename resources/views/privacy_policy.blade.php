@section('title', 'Privacy Policy')
@section('description', 'Privacy Policy')
@section('keywords', 'Privacy Policy')

@section('vendor_css')
@endsection

@section('page_css')
<link rel="stylesheet" href="../../assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

@section('manu', 'privacy-policy')
@include('layouts.header')

@include('layouts.sidebar')      
@include('layouts.nav') 

<div class="card mb-4">
  <h5 class="card-header">Update Privacy Policy</h5>
  <form class="card-body" method="POST" action="{{url('update-privacy-policy')}}">
    @csrf
    <div class="row g-3">
      
      <div class="form-repeater">
         
          <div data-repeater-list="group-a"> 
            @if (!empty($privacy->privacy_policy))
              @foreach ($privacy->privacy_policy as $item)
                <div data-repeater-item>
                    <div class="row">
                        <div class="mb-3 col-lg-12 mb-0">
                            <label class="form-label" for="form-repeater-1-1">Title</label>
                            <input type="text" name="group-a[1][title]" id="form-repeater-1-1" class="form-control" placeholder="title.." value="{{$item->title}}"/>
                            <small class="error-title-message text-danger"></small>
                        </div>
                        
                        <div class="mb-3 col-lg-12 mb-0">
                            <label class="form-label" for="form-repeater-1-1">Paragraph</label>
                            <textarea name="group-a[1][paragraph]" id="form-repeater-1-1" class="form-control" rows="2" placeholder="Paragraph..">{{$item->paragraph}}</textarea>                          
                            <small class="error-paragraph-message text-danger"></small>
                        </div>
                        
                        <div class="mb-3 col-lg-12 col-xl-12 col-12 d-flex align-items-end mb-0 justify-content-end">
                            <button class="btn btn-label-danger mt-4 remove-button">
                                <i class="ti ti-x ti-xs me-1"></i>
                                <span class="align-middle">Delete</span>
                            </button>
                        </div>
                    </div>                
                </div>  
              @endforeach                
            @endif                      
                                    
          </div>
          <div class="mb-0">
            <a class="btn btn-primary" data-repeater-create>
            <i class="ti ti-plus me-1" style="color: white"></i>
            <span class="align-middle text-white">Add</span>
            </a>
        </div><br>
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
<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection

<!-- Page JS -->
@section('page_js')
<script src="../../assets/js/forms-file-upload.js"></script>
<script src="../../assets/js/forms-extras.js"></script>
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>
@endsection

@section('main_js')
<script>
  document.querySelector('.form-repeater').addEventListener('input', function (event) {
     // Check if the event is triggered from the relevant input field or textarea
     if (event.target.matches('input[name^="group-a\\["][name$="\\[title\\]"], textarea[name^="group-a\\["][name$="\\[paragraph\\]"]')) {
 
         const container = event.target.closest('[data-repeater-item]'); // Locate the parent container of the current item
         const errorMessageTitle = container.querySelector('.error-title-message');
         const errorMessageParagraph = container.querySelector('.error-paragraph-message');
 
         const titleField = container.querySelector('input[name$="[title]"]');
         const paragraphField = container.querySelector('textarea[name$="[paragraph]"]');
 
         // Title Validation
         if (titleField && titleField.value.trim() === '') {
             errorMessageTitle.textContent = 'Title cannot be blank.';
             titleField.classList.add('is-invalid');
         } else if (titleField && titleField.value.trim().length < 3) {
             errorMessageTitle.textContent = 'Title must be at least 3 characters.';
             titleField.classList.add('is-invalid');
         } else {
             errorMessageTitle.textContent = '';
             titleField.classList.remove('is-invalid');
         }
 
         // Paragraph Validation
         if (paragraphField && paragraphField.value.trim() === '') {
             errorMessageParagraph.textContent = 'Paragraph cannot be blank.';
             paragraphField.classList.add('is-invalid');
         } else if (paragraphField && paragraphField.value.trim().length < 20) {
             errorMessageParagraph.textContent = 'Paragraph must be at least 20 characters.';
             paragraphField.classList.add('is-invalid');
         } else {
             errorMessageParagraph.textContent = '';
             paragraphField.classList.remove('is-invalid');
         }
     }
 });
 </script>
@endsection

@include('layouts.footer')
<script>
  $(document).ready(function(){

    $(document).on('click', '.remove-button', function(e){
      e.preventDefault();
      const $repeaterItem = $(this).closest('[data-repeater-item]');

      Swal.fire({
          title: '<span class="fw-medium">Are <u>You</u> Sure</span>',
          icon: "warning",
          html: 'You want to delete this title and paragraph',
          showCloseButton: !0,
          showCancelButton: !0,
          focusConfirm: !1,
          confirmButtonText: '<i class="ti ti-thumb-up"></i> Yes!',
          confirmButtonAriaLabel: "Thumbs up, Yes!",
          cancelButtonText: '<i class="ti ti-thumb-down"></i>',
          cancelButtonAriaLabel: "Thumbs down",
          customClass: { confirmButton: "btn btn-primary me-3 waves-effect waves-light", cancelButton: "btn btn-label-secondary waves-effect waves-light" },
          buttonsStyling: !1,
      }).then((result) => {
        if (result.isConfirmed) {
            // Perform the deletion
            $repeaterItem.remove();
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'The item has been deleted.',
                customClass: { confirmButton: "btn btn-success waves-effect waves-light" },
            });
        }
      });
    });
    
  })
</script>