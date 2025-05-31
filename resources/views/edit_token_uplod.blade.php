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

@php
$form_16_a = json_decode(optional($data->tokenDocument)->form_16_a);
$annex_use = json_decode(optional($data->tokenDocument)->annex_use);
$form_16_parantal = json_decode(optional($data->tokenDocument)->form_16_parantal);
$inv_lic_mf = json_decode(optional($data->tokenDocument)->inv_lic_mf);
$public_investment = json_decode(optional($data->tokenDocument)->public_investment);
$bank_statement = json_decode(optional($data->tokenDocument)->bank_statement);
$sales_purchase = json_decode(optional($data->tokenDocument)->sales_purchase);
$additional_documents = json_decode(optional($data->tokenDocument)->additional_documents);
@endphp
<div class="card mb-4">
    <h5 class="card-header">Edit Uploaded Documents</h5>
    <form class="card-body" method="POST" action="{{route('token.upload_document_edit_submit', ['token'=>$data])}}" enctype="multipart/form-data">
      @csrf
      <div class="row">

        <div class="col-md-12">
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" name="doc_type" id="salaried" value="salaried" {{ optional($data->tokenDocument)->doc_type == 'salaried' ? 'checked' : ''}}/>
              <label for="salaried" class="form-check-label">Salaried</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" name="doc_type" id="business" value="business" {{ optional($data->tokenDocument)->doc_type == 'business' ? 'checked' : ''}}/>
              <label for="business" class="form-check-label">Other than Salaried(Business)</label>
            </div>
        </div>
        <div class="col-md-12"><br></div>

        <div class="col-md-6" id="form16a" style="{{ optional($data->tokenDocument)->doc_type == 'salaried' ? 'display: none' : 'display: block'}};"><br>
            <label class="form-label" for="form_16_a">Form 16 (A)</label>
            <input type="file" name="form_16_a[]" id="form_16_a" class="form-control" multiple />            
            @if($errors->has('form_16_a.*'))
                @foreach($errors->get('form_16_a.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($form_16_a))
                @foreach ($form_16_a as $item)
                    <img src="{{ url('uploads/'.$item ) }}" alt="" width="100px" height="100px">    
                @endforeach
            @endif
            
        </div>
        <div class="col-md-6"><br>
            <label class="form-label" for="annex_use">Annex Use</label>
            <input type="file" name="annex_use[]" id="annex_use" class="form-control" multiple />            
            @if($errors->has('annex_use.*'))
                @foreach($errors->get('annex_use.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($annex_use))
                @foreach ($annex_use as $item)
                    <img src="{{ url('uploads/'.$item ) }}" alt="" width="100px" height="100px">    
                @endforeach   
            @endif         
        </div>
        <div class="col-md-6"><br>
            <label class="form-label" for="form_16_parantal">Form 16 (issued by parental dept)</label>
            <input type="file" name="form_16_parantal[]" id="form_16_parantal" class="form-control" multiple />            
            @if($errors->has('form_16_parantal.*'))
                @foreach($errors->get('form_16_parantal.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($form_16_parantal))
                @foreach ($form_16_parantal as $form_16_paran)
                    <img src="{{ url('uploads/'.$form_16_paran ) }}" alt="" width="100px" height="100px">    
                @endforeach   
            @endif 
        </div>
        <div class="col-md-6"><br>
            <label class="form-label" for="inv_lic_mf">Investment (LIC, MF)</label>
            <input type="file" name="inv_lic_mf[]" id="inv_lic_mf" class="form-control" multiple />            
            @if($errors->has('inv_lic_mf.*'))
                @foreach($errors->get('inv_lic_mf.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($inv_lic_mf))
                @foreach ($inv_lic_mf as $inv_lic)
                    <img src="{{ url('uploads/'.$inv_lic ) }}" alt="" width="100px" height="100px">    
                @endforeach   
            @endif 
        </div>
        <div class="col-md-6"><br>
            <label class="form-label" for="interest_certificate">Interest Certificate</label>
            <input type="file" name="intrest_certificate" id="interest_certificate" class="form-control" />
            @error('intrest_certificate')
            <span style="color: red">{{ $message }}</span>
            @enderror
            @if (!empty(optional($data->tokenDocument)->intrest_certificate))
                <img src="{{url('uploads/'. optional($data->tokenDocument)->intrest_certificate) }}" alt="" height="100px" width="100px">
            @endif
        </div>
        <div class="col-md-6"><br>
            <label class="form-label" for="public_investment">Investment in public mutual, Shares, Debenture</label>
            <input type="file" name="public_investment[]" id="public_investment" class="form-control" multiple />            
            @if($errors->has('public_investment.*'))
                @foreach($errors->get('public_investment.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($public_investment))
                @foreach ($public_investment as $public_invest)
                    <img src="{{ url('uploads/'.$public_invest ) }}" alt="" width="100px" height="100px">    
                @endforeach   
            @endif
        </div>
        <div class="col-md-6" id="bank_statement" style="{{ optional($data->tokenDocument)->doc_type == 'salaried' ? 'display: none' : 'display: block'}};"><br>
            <label class="form-label" for="bank_statement">Bank Statement</label>
            <input type="file" name="bank_statement[]" id="bank_statement" class="form-control" multiple />            
            @if($errors->has('bank_statement.*'))
                @foreach($errors->get('bank_statement.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($bank_statement))
                @foreach ($bank_statement as $bank_stat)
                    <img src="{{ url('uploads/'.$bank_stat ) }}" alt="" width="100px" height="100px">    
                @endforeach   
            @endif
        </div>
        <div class="col-md-6" id="bills" style="{{ optional($data->tokenDocument)->doc_type == 'salaried' ? 'display: none' : 'display: block'}};"><br>
            <label class="form-label" for="sales_purchase">Bills (Sales/Purchase)</label>
            <input type="file" name="sales_purchase[]" id="sales_purchase" class="form-control" multiple />            
            @if($errors->has('sales_purchase.*'))
                @foreach($errors->get('sales_purchase.*') as $error)
                    <span style="color: red">{{ $error[0] }}</span><br>
                @endforeach
            @endif
            @if (!empty($sales_purchase))
                @foreach ($sales_purchase as $sales_purch)
                    <img src="{{ url('uploads/'.$sales_purch ) }}" alt="" width="100px" height="100px">    
                @endforeach   
            @endif
        </div>
        <div class="col-md-12"><br><hr><br>
            <h5 class="">Additional Required Documents</h5>
        </div>
        @if (!empty($data->service->serviceDocuments))
            @foreach ($data->service->serviceDocuments as $serviceitem)
                <div class="col-md-6"><br>
                    <label class="form-label" for="public_investment">{{ $serviceitem->doc_name }}</label>
                    <input type="file" name="{{ $serviceitem->doc_name }}[]" id="{{ $serviceitem->doc_name }}" class="form-control" multiple />
                    @if($errors->has($serviceitem->doc_name . '.*'))
                        @foreach($errors->get($serviceitem->doc_name . '.*') as $error)
                            <span style="color: red">{{ $error[0] }}</span><br>
                        @endforeach
                    @endif                    
                    @if(!empty($additional_documents))
                        @foreach ($additional_documents as $key => $additional_doc)
                            @if ($key == $serviceitem->doc_name)
                                @foreach ($additional_doc as $item)
                                    <img src="{{ url('uploads/'.$item ) }}" alt="" width="100px" height="100px">    
                                @endforeach
                            @endif                            
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endif

        
        

        <div class="col-md-12"><br>
            <label class="form-label" for="comment">Others</label><br>
            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Comment..">{{ optional($data->tokenDocument)->comment }}</textarea>
            @error('comment')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
                 
        <div class="col-md-6 mb-4 align-content-end pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Upload</button>
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

@include('layouts.footer')