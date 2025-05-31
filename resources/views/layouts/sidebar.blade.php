<!-- / Layout page -->
<div class="layout-page">

<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  @php
    if(session('type') == 'admin'){
      $allpermission = 1;
    }else if(session('type') == 'user'){      
      $allpermission = 0;
      $admin = App\Models\Team::where('id', session('id'))->with('permissions')->first();                    
      $search_client = $admin->permissions->search_client;
      $services = $admin->permissions->services;
      $search_token = $admin->permissions->search_token;
      $payments = $admin->permissions->payments;
      $announcements = $admin->permissions->announcements;
      $team_users = $admin->permissions->team_users;
      $cms = $admin->permissions->cms;
  	  $reports = $admin->permissions->reports;
    }                  
  @endphp
  <style>
    .menu-vertical .app-brand{
      padding-left: unset;
    }
    .app-brand-logo.demo{
      width: 187px;
      height: 100%;
    }
  </style>
  <script>
    // Pass the session variable to a JavaScript variable
      window.userType = "{{ session('type') ?? 'guest' }}";
  </script>

  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      {{-- <span class="app-brand-logo demo">
        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
          <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
          <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
        </svg>
      </span>
      <span class="app-brand-text demo menu-text fw-bold">CA CRM</span> --}}
      <img src="{{ asset('uploads/logo/LOGO BLUEBELL GROUP.JPG') }}" alt="" class="app-brand-logo demo">
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>

  
  <ul class="menu-inner py-1 gap-3">
    <!-- Dashboards -->

    <li class="menu-item {{ request()->is('/*') || trim($__env->yieldContent('manu')) == 'Dashboards' ? 'active' : '' }}">
      <a href="{{url('/')}}" class="menu-link" >
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Dashboards">Dashboards</div>
      </a>
    </li>

    @if ($allpermission == 1 || $search_client == 1)        
      <li class="menu-item {{ request()->is('/users*') || trim($__env->yieldContent('manu')) == 'Users' ? 'active' : '' }}">
        <a href="{{url('/users')}}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div data-i18n="Search Client">Search Client</div>
        </a>
      </li>
    @endif

    @if ($allpermission == 1 || $services == 1) 
    <li class="menu-item {{ request()->is('/services*') || trim($__env->yieldContent('manu')) == 'Services' ? 'active' : '' }}">
      <a href="{{url('/services')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-list-check"></i>
        <div data-i18n="Services">Services</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $search_token == 1)
    <li class="menu-item {{ request()->is('/tokens*') || trim($__env->yieldContent('manu')) == 'Tokens' ? 'active' : '' }}">
      <a href="{{url('/tokens')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-brand-oauth"></i>
        <div data-i18n="Search Token">Search Token</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $payments == 1)
    <li class="menu-item {{ request()->is('/payments*') || trim($__env->yieldContent('manu')) == 'Payments' ? 'active' : '' }}">
      <a href="{{url('/payments')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-currency-rupee"></i>
        <div data-i18n="Payments">Payments</div>
      </a>
    </li>
    @endif
	@if ($allpermission == 1 || $reports == 1)
    <li class="menu-item {{ request()->is('/reports*') || trim($__env->yieldContent('manu')) == 'Reports' ? 'active' : '' }}">
      <a href="{{url('/reports')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-report-analytics"></i>
        <div data-i18n="Reports">Reports</div>
      </a>
    </li>
	@endif
    @if ($allpermission == 1 || $announcements == 1)
    <li class="menu-item {{ request()->is('/announcements*') || trim($__env->yieldContent('manu')) == 'Announcements' ? 'active' : '' }}">
      <a href="{{url('/announcements')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-speakerphone"></i>
        <div data-i18n="Announcements">Announcements</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $team_users == 1)
    <li class="menu-item {{ request()->is('/team*') || trim($__env->yieldContent('manu')) == 'team' ? 'active' : '' }}">
      <a href="{{url('/team')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users-group"></i>
        <div data-i18n="Team/Users">Team/Users</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $cms == 1)
    <li class="menu-item {{ request()->is('/about-us*') || trim($__env->yieldContent('manu')) == 'about-us' ? 'active' : '' }}">
      <a href="{{url('/about-us')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-id"></i>
        <div data-i18n="About Us">About Us</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $cms == 1)
    <li class="menu-item {{ request()->is('/privacy-policy*') || trim($__env->yieldContent('manu')) == 'privacy-policy' ? 'active' : '' }}">
      <a href="{{url('/privacy-policy')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-checkbox"></i>
        <div data-i18n="Privacy Policy">Privacy Policy</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $cms == 1)
    <li class="menu-item {{ request()->is('/terms-conditions*') || trim($__env->yieldContent('manu')) == 'terms-conditions' ? 'active' : '' }}">
      <a href="{{url('/terms-conditions')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-lock"></i>
        <div data-i18n="T&C's">T&C's</div>
      </a>
    </li>
    @endif

    @if ($allpermission == 1 || $cms == 1)
    <li class="menu-item {{ request()->is('/contact-us*') || trim($__env->yieldContent('manu')) == 'contact-us' ? 'active' : '' }}">
      <a href="{{url('/contact-us')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Contact Us">Contact Us</div>
      </a>
    </li>
    @endif

	@if ($allpermission == 1 || $cms == 1)
    <li class="menu-item {{ request()->is('/banners*') || trim($__env->yieldContent('manu')) == 'banners' ? 'active' : '' }}">
      <a href="{{url('/banners')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-brand-google-home"></i>
        <div data-i18n="Banners">Banners</div>
      </a>
    </li>
    @endif


  </ul>
  
  

</aside>
<!-- / Menu -->