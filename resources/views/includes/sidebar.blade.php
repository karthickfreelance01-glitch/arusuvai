<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <!-- Profile -->
    <li class="nav-item nav-profile border-bottom">
      <a href="#" class="nav-link flex-column">
        <div class="nav-profile-image">
          <img src="{{asset('admin/assets/images/logo/logo.jpeg')}}" alt="profile" width="50%">
        </div>
        <div class="nav-profile-text d-flex ms-0 mb-3 flex-column">
          <span class="fw-semibold mb-1 mt-2 text-center">Admin</span>
          <span class="text-secondary icon-sm text-center">Administrator</span>
        </div>
      </a>
    </li>

    <!-- Dashboard -->
    <li class="nav-item pt-3">
      <a class="nav-link" href="{{url('dashboard')}}">
        <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Inventory -->
    <li class="pt-2 pb-1">
      <span class="nav-item-head">Meal Management</span>
    </li>

     <li class="nav-item pt-3">
      <a class="nav-link" href="{{url('meal-types')}}">
        <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
        <span class="menu-title">Meal Type</span>
      </a>
    </li>
    <li class="nav-item pt-3">
      <a class="nav-link" href="{{url('days')}}">
        <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
        <span class="menu-title">Days</span>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#inventory" aria-expanded="false">
        <i class="mdi mdi-warehouse menu-icon"></i>
        <span class="menu-title">Meal Type</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="inventory">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/meals')}}">Add Meals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/meal-map/create')}}">Meal Map Create</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/meal-map')}}">Meal Map View</a>
          </li>
          
        </ul>
      </div>
    </li>
     <li class="nav-item pt-3">
      <a class="nav-link" href="{{url('admin/reports')}}">
        <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
        <span class="menu-title">Reports</span>
      </a>
    </li>



  </ul>
</nav>
