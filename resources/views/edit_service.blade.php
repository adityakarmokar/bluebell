@section('title', 'Edit Service')
@section('description', 'Edit Service Details')
@section('keywords', 'Service description')

@section('vendor_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css" />
@endsection

@section('page_css')
@endsection

@section('manu', 'Services')
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
    <h5 class="card-header">Edit Service</h5>
    <form class="card-body" method="POST" action="{{route('service.update', ['service'=>$data])}}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <h6>1. Service Info</h6>
      <div class="row g-3">
        <div class="col-md-12">
          <label class="form-label" for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Annual Return" value="{{ $data->name }}" required />
          @error('name')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-md-6">            
          <label class="form-label" for="service_icon">Service Icon</label>
          <input type="file" name="service_icon" id="service_icon" class="form-control" placeholder="Please upload Service icon" />
          <img src="{{url('uploads/'.$data->service_icons)}}" alt="" width="100px" height="100px">
        </div>
        
        <div class="col-md-6">            
            <label class="form-label" for="service_banner">Service Banner</label>
            <input type="file" name="service_banner" id="service_banner" class="form-control" placeholder="Please upload Service Banner" />
            <img src="{{url('uploads/'.$data->service_banner)}}" alt="" width="100px" height="100px">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="service_banner">Price</label>
            <input type="number" step="0.01" name="service_price" id="service_price" value="{{ $data->service_price }}" class="form-control" placeholder="500.00" />
            @error('service_price')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-12">
            <label class="form-label" for="service_details">Service Details</label>
            <textarea name="service_details" id="service_details" cols="30" rows="5" class="form-control" placeholder="Service Details">{{ $data->service_details }}</textarea>
            @error('service_details')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <hr>
        <h6>2. Additional Required Documents List</h6>
        <div class="form-repeater">
            <div class="mb-0">
                <a class="btn btn-primary" data-repeater-create>
                <i class="ti ti-plus me-1"></i>
                <span class="align-middle">Add</span>
                </a>
            </div><br>
            
            @foreach ($data->serviceDocuments as $docIndex => $item)
                
                <div class="row" id="{{$docIndex+50}}">
                    <input type="hidden" name="group-a[{{$docIndex+50}}][doc_id]" value="{{$item->id}}">
                    <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                        <label class="form-label" for="form-repeater-1-1">Document Name</label>
                        <input type="text" name="group-a[{{$docIndex+50}}][doc_name]" id="form-repeater-1-1" class="form-control" placeholder="Required Document name" value="{{$item->doc_name}}" />
                    </div>
                    
                    <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                        <label class="form-label" for="form-repeater-1-1">Document Icon</label>
                        <input type="file" name="group-a[{{$docIndex+50}}][doc_icon]" id="form-repeater-1-1" class="form-control" placeholder="Required Document name" />
                        <input type="hidden" name="group-a[{{$docIndex+50}}][doc_icon_hidden]" value="{{$item->doc_icon}}" />
                        @if (!empty($item->doc_icon))
                            <img src="{{ url('uploads/' . $item->doc_icon) }}" alt="" width="100px" height="100px">
                        @endif
                    </div>                            
                    <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-start mb-0">
                        <a class="btn btn-label-danger mt-4 item_remove" data-row="{{$docIndex+50}}">
                            <i class="ti ti-x ti-xs me-1"></i>
                            <span class="align-middle">Remove</span>
                        </a>
                    </div>
                </div>                           
            @endforeach                                                         
            <div data-repeater-list="group-a">
                <div data-repeater-item>                  
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                            <label class="form-label" for="form-repeater-1-1">Document Name</label>
                            <input type="text" name="group-a[50][doc_name]" id="form-repeater-1-1" class="form-control" placeholder="Required Document name" />
                        </div>
                        
                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                            <label class="form-label" for="form-repeater-1-1">Document Icon</label>
                            <input type="file" name="group-a[50][doc_icon]" id="form-repeater-1-1" class="form-control" placeholder="Required Document name" />                            
                        </div>                            
                        <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-start mb-0">
                            <a class="btn btn-label-danger mt-4" data-repeater-delete>
                                <i class="ti ti-x ti-xs me-1"></i>
                                <span class="align-middle">Delete</span>
                            </a>
                        </div>
                    </div>                         
                </div>                    
            </div>
        </div>        

      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
        <a href="{{url('services')}}" class="btn btn-label-secondary">Cancel</a>
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
        // ClassicEditor
        // .create(document.querySelector('#service_details'))
        // .catch(error => {
        //     console.error(error);
        // });

        $('.item_remove').on('click', function(){
            var id = $(this).data('row');
            if (confirm('Are you sure you want to remove this item?')) {
                $('#' + id).remove(); 
            }
        });
    });

    
</script>

@include('layouts.footer')