<!DOCTYPE html>
 

<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

  
 <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login | CA Firm</title>

    
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://1.envato.market/vuexy_admin">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css"/>
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" /> 
    <!-- Vendor -->
<link rel="stylesheet" href="../../assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
<link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css">

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->    
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>   
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
</head>

<body>
  
  <!-- Content -->

<div class="authentication-wrapper authentication-cover authentication-bg">
  <div class="authentication-inner row">
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <img src="{{ asset('uploads/logo/LOGO BLUEBELL GROUP.JPG') }}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" data-app-dark-img="illustrations/auth-login-illustration-dark.html">

        <img src="../../assets/img/illustrations/bg-shape-image-light.png" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.html">
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
      <div class="w-px-400 mx-auto">
        
        {{-- <img class="mb-2" src="{{ asset('uploads/logo/LOGO BLUEBELL GROUP.JPG') }}" alt="BLUEBELL GROUP" style="max-width: 50%;"> --}}
        <h3 class="mb-1">Welcome to BLUEBELL GROUP!</h3>        

        <form class="mb-3" method="POST" id="login">
            @csrf            
            <div class="mt-4 mb-3">            
            <select id="formValidationSelect2" name="user_type" class="form-select select2 select2-hidden-accessible" data-allow-clear="true" data-select2-id="formValidationSelect2" tabindex="-1" aria-hidden="true">              
              <option value="1">User</option>
              <option value="0">Admin</option>             
            </select>            
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email </label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus>
          </div>          
          
          <div id="send_otp">
            <button type="button" class="btn btn-primary d-grid w-100">
              Send OTP
            </button>
          </div>
          
          <div class="mb-3 form-password-toggle" id="edit_paasword" style="display:none;">
            <label for="password">Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete/>
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>   
          
          <div class="mb-3 form-password-toggle" style="display:none" id="otp_input">
            <label for="otp">Otp</label>
            <div class="input-group input-group-merge">
              <input type="password" id="top" class="form-control" name="otp" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="otp" autocomplete/>
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>   
          
          <div id="submit" style="display:none;">
            <button type="submit" class="btn btn-primary d-grid w-100">
              Submit
            </button>
          </div>          
          
        </form>

      </div>
    </div>
    <!-- /Login -->
  </div>
</div>

<!-- / Content -->
  
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/libs/hammer/hammer.js"></script>

  <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
   <script src="../../assets/vendor/js/menu.js"></script>
  
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../../assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js"></script>

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>
  

  <!-- Page JS -->
  <script src="../../assets/js/pages-auth.js"></script>
  
  <script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "1000"
    }

    $(document).ready(function () {
        $('#login').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: "post",
                url: "/admin-login",
                data: formData,
                dataType: 'json', // Specify that you expect JSON in the response
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                success: function (data) {
                    if (data == '1') {
                        toastr.success("Login Successfully");
                        setTimeout(function () {
                            window.location.href = '/';
                        }, 2000);
                    } else if(data == '2'){
                      toastr.success("OTP Expired");
                      setTimeout(function () {
                            window.location.href = '/';
                        }, 1000);
                    } else {
                        toastr.warning("Invalid credentials");
                        setTimeout(function () {
                            window.location.href = '';
                        }, 4000);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error submitting form:', error);
                    // Handle the error as needed
                    toastr.error("An error occurred during login.");
                }
            });
        });
      
      	$('#send_otp').on('click', function(){
          
          let email = $('#email').val();          
          let user_type = $('#formValidationSelect2').val();
          
          $.ajax({
            type: "post",
            url: "/admin-otp",
            data: {
              user_type: user_type,
              email: email,              
              _token: '{{ csrf_token()}}'
            },            
            success: function (data) {
              if (data == '1') {
                toastr.success("OTP send Successfully");
                $('#send_otp').fadeOut();
                $('#otp_input').fadeIn();
                $('#edit_paasword').fadeIn();
                $('#submit').fadeIn();
              } else {
                toastr.warning("Invalid credentials");
                
              }
            },
            error: function (xhr, status, error) {
              console.error('Error sending otp form:', error);              
              toastr.error("An error occurred during sending otp.");
            }
          });
          
        });
      
    });
  </script>
</body>
</html>

