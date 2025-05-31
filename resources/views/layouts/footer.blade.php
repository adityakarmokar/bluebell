a    
            </div>
            <!-- / Content -->
            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    
  </div>
  <!-- / Layout wrapper -->

  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
  <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
  <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
   <script src="../../assets/vendor/js/menu.js"></script>
  
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
  <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
  <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
  <script src="../../assets/vendor/libs/moment/moment.js"></script>
  <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
  <script src="../../assets/vendor/libs/select2/select2.js"></script>
  <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
  
  @yield('vendor_js')

  <!-- Form Validation -->
  <script src="../../assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js"></script>
  <script src="../../assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js"></script>
  <script src="../../assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js"></script>  

  <!-- Page JS -->
  <script src="../../assets/js/form-layouts.js"></script>
  @yield('page_js')

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>
  <script src="../../assets/js/app-ecommerce-dashboard.js"></script>
  <script src="../../assets/js/app-logistics-dashboard.js"></script>
  <script src="../../assets/js/dashboards-analytics.js"></script>
  
  @yield('main_js')  
  
  <script src="../../assets/js/kurban.js"></script>
  
  <script>

    document.getElementById('search_user').addEventListener('keyup', function() {
        const searchValue = this.value.trim();
        const resultWrapper = document.querySelector('.search-results');

        if (searchValue.length > 0) {
            fetch(`/search-user?search_user=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#search_result-wrapper').classList.remove('d-none');                       
                    if (data.status == 'found') {                                                                       
                        resultWrapper.innerHTML = ''; 
                        
                        if(data.type == 'user'){
                            data.user.forEach(user => {
                                    const fname = user.fname != null ? user.fname : '';
                                    const mname = user.mname != null ? user.mname : '';
                                    const lname = user.lname != null ? user.lname : '';
                                    const userItem = document.createElement('a');
                                    userItem.href = `/view-user/${user.id}`;
                                    userItem.style = "margin-top:unset;padding:unset;background-color:unset;color: black;";
                                    userItem.style.display = 'block';
                                    userItem.style.marginBottom = '4px';
                                    userItem.innerHTML = `<strong>Name: ${fname} ${mname} ${lname}</strong> (Phone: ${user.phone}) (PAN: ${user.pan_no})`;
                                    resultWrapper.appendChild(userItem);
                            });                        
                        }else if(data.type == 'token'){
                            data.token.forEach(token => {
                                    const userItem = document.createElement('a');
                                    userItem.href = `/view-token/${token.id}`;
                                    userItem.style = "margin-top:unset;padding:unset;background-color:unset;color: black;";
                                    userItem.style.display = 'block';
                                    userItem.style.marginBottom = '4px';
                                    userItem.innerHTML = `<strong>Token: ${token.token} </strong>`;
                                    resultWrapper.appendChild(userItem);
                            });  
                        }                        

                    } else if(data.status === 'Not found'){
                        resultWrapper.innerHTML = `
                        <p>No user found with this number or PAN: ${searchValue}</p>
                        <a href="/user-add?phone=${encodeURIComponent(searchValue)}" class="btn btn-success">Create New User</a>`;                        
                    }
                })
                .catch(error => console.error('Error:', error));
        }else{
            document.querySelector('.search-results').innerHTML = '';
            document.querySelector('#search_result-wrapper').classList.add('d-none');
        }
    });

    document.getElementById('result_close_button').addEventListener('click', function() {
        console.log('close button hit');
        document.querySelector('.search-results').innerHTML = "";
        document.querySelector('#search_result-wrapper').classList.add('d-none');

    });

    document.addEventListener('DOMContentLoaded', function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "1000"
        }
    });
    </script>
    
    @if(session('success'))
    <script>
        toastr.success('{{ session('success') }}', 'Success');
    </script>
    @endif
    @if(session('error'))
    <script>
        toastr.error('{{ session('error') }}', 'Error');
    </script>
    @endif    

    <script>        
        
        function change_token_status_modal(id, token, service)
        {            
            let options = { 
                1: 'Token Generated',
                2: 'Return Data Validated',
                3: 'Return Not Filed / Not Finalized',
                4: 'Return Not Filed / Finalized',
                // 5: 'Payments Completed / Ready to File',                       
                6: 'Returns Filed - Not Verified',
                7: 'Return Filed - Verified',
                8: 'Documents Delivered'
            };

            $.ajax({
                url: "{{route('token.check.status')}}", 
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,                     
                },
                success: function(response)
                {
                    // console.log(response);
                    if(response.status == true){
                        // toastr.success(response.message); 
                        
                        var existingStatuses = response.data.map(function(item) {
                            return parseInt(item.status);
                        });

                        var lastStatus = existingStatuses[existingStatuses.length - 1];                        

                        var filteredOptions = Object.entries(options).filter(function([key, value]) {
                            return parseInt(key) > lastStatus && !existingStatuses.includes(parseInt(key)); 
                        });                                              
                        
                        var optionsHtml = '<option value="" disabled selected>Choose...</option>';
                        optionsHtml += filteredOptions.map(function([key, value]) {
                            return `<option value="${key}">${value}</option>`;
                        }).join('');

                        $('#Modal_token_id').text(token);
                        $('#modal_service_change').text(service);
                        $('#modal_token_status_change_id').val(id);
                        $('select[name^=modal_payment_status]').html(optionsHtml);

                    }else if(response.status == false){
                        toastr.error(response.message);
                    }
                }
            });                                    
        }

        $(document).ready(function()
        {
          	$('.token-status').on('change', function(){

				var status = $(this).val();              
              	if(status == 4){
                    $('#status4Modal').css('display', 'block');
                  	$('#save-div').css('display', 'none');
                    return false;
                }
              
            });
            $('#changetokenstatusbymodal').on('click', function(){
                // alert("test");                
              	var status = $('#get_modal_payment_status').val();
                var token = $('#modal_token_status_change_id').val();

                if(status == 4){
                    $('#status4Modal').css('display', 'block');
                    return false;
                }else{
                    $.ajax({
                        url: "{{route('token.change.status')}}", 
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            token: token, 
                            status: status,
                        },
                        success: function(response)
                        {
                            if(response.status == true){
                            toastr.success(response.message);
                            window.location.reload();
                            }else if(response.status == false){
                            toastr.error(response.message);
                            }
                        }
                    });
                }

            });            

        });

        function saveTokenStatus()
        {

            var status = $('#get_modal_payment_status').val();
            var token = $('#modal_token_status_change_id').val();
            var refund = $('#refund_amount_status').val();
            var payable = $('#payable_amount_status').val();
            var consultency = $('#consultency_fees_status').val();          	

            $.ajax({
                url: "{{route('token.change.status')}}", 
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    token: token, 
                    status: status,
                    refund: refund,
                    payable: payable,
                    consultency: consultency,
                },
                success: function(response)
                {
                    if(response.status == true){
                    toastr.success(response.message);
                    window.location.reload();
                    }else if(response.status == false){
                    toastr.error(response.message);
                    }
                }
            });

        }
      
      $(document).on('keyup', '#refund_amount_status', function() {
          let value = $(this).val();

          // Trim the value to handle spaces
          if ($.trim(value) !== '') {
              // Only reset these fields if they exist
              if ($('#payable_amount_status').length) {
                  $('#payable_amount_status').val('');
              }
              
          }
      });
      
      $(document).on('keyup', '#payable_amount_status', function(){
        let value = $(this).val();
        
        if ($.trim(value) !== '') {          
          if ($('#refund_amount_status').length) {
            $('#refund_amount_status').val('');
          }

        }
        
      });            


    </script>

</body>
</html>