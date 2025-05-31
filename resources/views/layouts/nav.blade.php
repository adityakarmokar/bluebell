<!-- Content wrapper -->
<div class="content-wrapper">

  <!-- Content -->
  
    <div class="container-xxl flex-grow-1 container-p-y">
<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
      
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="ti ti-menu-2 ti-sm"></i>
      </a>
    </div>
    

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

      
      <!-- Search -->
      <div class="navbar-nav align-items-center">
        <div class="nav-item navbar-search-wrapper mb-0">
          <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
            <i class="ti ti-search ti-md me-2"></i>
            <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
          </a>
        </div>
      </div>
      <!-- /Search -->
      
      

      

      <ul class="navbar-nav flex-row align-items-center ms-auto">        

        

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="{{ asset('uploads/avatar.jpg') }}" alt class="h-auto rounded-circle">
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('uploads/avatar.jpg') }}" alt class="h-auto rounded-circle">
                    </div>
                  </div>
                  @php
                  if(session('type') == 'admin'){
                    $admin = App\Models\Admin::find(session('id'));
                    $adminName = $admin->fullname;
                    $adminType = 'Admin';
                  }else{
                    $admin = App\Models\Team::where('id', session('id'))->with('permissions')->first();                    
                    $adminName = $admin->username;
                    $adminType = 'User';
                  }                  
                  @endphp
                  <div class="flex-grow-1">
                    <span class="fw-medium d-block">{{$adminName}}</span>
                    <small class="text-muted">{{$adminType}}</small>
                  </div>
                </div>
              </a>
            </li>            
            <li>
              <a class="dropdown-item" href="{{ url('logout') }}">
                <i class="ti ti-logout me-2 ti-sm"></i>
                <span class="align-middle">Log Out</span>
              </a>
            </li>
          </ul>
        </li>
        <!--/ User -->
        


      </ul>
    </div>

    
    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper  d-none">
      <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." name="search_user" id="search_user">
      <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
    <div class="d-none container-xxl navbar-expand-xl" style="position: absolute;top:100%; margin:0 !important; padding: 0 !important;margin-left: -24px !important;" id="search_result-wrapper">
      <span id="result_close_button" style="font-size: 2rem !important;color:red;position:absolute;top:-17px !important;right:-10px !important;cursor: pointer;"><i class="ti ti-square-x" style="font-size: 2rem !important;"></i></span>
      <div class="search-results mt-0" style="max-width: unset;text-align:unset;" id="search-results"></div>
    </div>
    
    

</nav>

<!-- / Navbar -->