@section('title', 'Generate Token')
@section('description', 'Generate Token')
@section('keywords', 'Token')

@section('vendor_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css" />
@endsection

@section('page_css')
@endsection

@section('manu', 'Tokens')
@include('layouts.header')

@include('layouts.sidebar')      
@include('layouts.nav')     
<style>
    .ck-editor__editable_inline {
        min-height: 200px; /* Adjust height as needed */
    }
    a.btn.btn-primary.waves-effect.waves-light{
        color: #fff;
    }
</style>
<!-- Multi Column with Form Separator -->
<div class="card mb-4">
    <h5 class="card-header">Generate New Token</h5>
    <form class="card-body" method="POST" action="{{url('token-generate')}}">
      @csrf

      <div class="row">
        <h6>1. Service Selection</h6>
        <div class="col-md-6 mb-4">
            <label for="user" class="form-label">Select User</label>
            <select name="user" id="user" class="select2 form-select form-select-lg" data-allow-clear="true" {{$selectedUserId != null ? 'disabled' : ''}}>
            @foreach ($users as $user)
                <option value="{{$user->id}}" {{$selectedUserId != null && $selectedUserId == $user->id ? 'selected' : ''}}>{{'Name: '.$user->fname.' '.$user->mname.' '.$user->lname.' (Phone: '.$user->phone.') (PAN: '.$user->pan_no.')'}}</option>
            @endforeach
            </select>
            @if ($selectedUserId != null)                
                <input type="hidden" name="user" value="{{$selectedUserId}}">
            @endif
            @error('user')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div> 
        <div class="col-md-6 mb-4">
            <label for="select2Basic" class="form-label">Select Service</label>
            <select name="service" id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
            @foreach ($services as $service)
                <option value="{{$service->id}}">{{$service->name}}</option>
            @endforeach
            </select>
            @error('service')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div> 
        
        <div class="col-md-6 mb-4 align-content-end">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Generate</button>
            <a href="{{url('tokens')}}" class="btn btn-label-secondary">Cancel</a>
        </div> 
      </div>
      
    </form>
  </div>
 
<!-- Vendors JS -->
@section('vendor_js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
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
<script src="../../assets/js/main.js"></script>
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

    });
</script>
<script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#service_details'))
            .catch(error => {
                console.error(error);
            });
    });
</script>

@include('layouts.footer')