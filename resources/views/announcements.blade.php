@section('title', 'Announcemnts - CA CRM')
@section('description', 'Announcemnts - CA CRM')
@section('keywords', 'Announcemnts - CA CRM')

@section('page_css')

@endsection

@section('manu', 'Announcements')
@include('layouts.header')
@include('layouts.sidebar')      
@include('layouts.nav')  

  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-3">All Announcements</h5>      
        <a href="#" class="btn btn-primary waves-effect waves-light">Add</a>  
      </div>
      <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
        <div class="col-md-4 user_role"></div>
        <div class="col-md-4 user_plan"></div>
        <div class="col-md-4 user_status"></div>
      </div>
    </div>
    <div class="card-datatable text-nowrap" style="margin: auto 2%">
      <table class="table" id="usersTable">
        <thead class="border-top">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>email</th>
            <th>PAN NO.</th>
            <th>STATUS</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            
            
        </tbody>
      </table>
    </div>
  </div>
  
@include('layouts.footer')