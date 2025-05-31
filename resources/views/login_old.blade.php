<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> Log In </title>    
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    
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
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />

    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/js/config.js"></script>

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>   
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    
</head>
<body>         

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-center" style="min-height: 93vh;">
            <form class="w-px-400 border rounded p-3 p-md-5" method="POST" id="login">
                @csrf
                <h3 class="mb-4 text-center">Admin Log In</h3>

                <div class="mb-3">
                <label class="form-label" for="form-alignment-username">Email</label>
                <input type="email" name="email" id="form-alignment-username" autofocus class="form-control" placeholder="CA admin" />
                </div>

                <div class="mb-3 form-password-toggle">
                <label class="form-label" for="form-alignment-password">Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" name="password" id="form-alignment-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="form-alignment-password2" />
                    <span class="input-group-text cursor-pointer" id="form-alignment-password2"><i class="ti ti-eye-off"></i></span>
                </div>
                </div>
                <div class="mb-3">
                <label class="form-check m-0">
                    <input type="checkbox" class="form-check-input" />
                    <span class="form-check-label">Remember me</span>
                </label>
                </div>
                <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>


  
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
  <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>
  

  <!-- Page JS -->
  <script src="../../assets/js/form-layouts.js"></script>
<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
}
</script>
  <script>
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
});
</script>
  
</body>
</html>


