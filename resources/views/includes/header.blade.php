<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-chevron-double-left"></span>
          </button>
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../../assets/images/logo-mini.svg"
                alt="logo" /></a>
          </div>
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link" href="javascript:void(0);" onclick="history.back();">
                <i class="mdi mdi-arrow-left"></i>
              </a>

              
            </li>
           
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            
            
            <li class="nav-item nav-profile dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                <div class="nav-profile-text"><i class="mdi mdi-home-circle"></i> </div>
              </a>
             <div class="dropdown-menu dropdown-menu-end navbar-dropdown"
                aria-labelledby="profileDropdown">

              <!-- Reset Password -->
              <a class="dropdown-item" href="{{ url('staff/reset-password') }}">
                <i class="mdi mdi-lock-reset me-2 text-primary"></i>
                Reset Password
              </a>

              <div class="dropdown-divider"></div>

              <!-- Logout -->
              <a class="dropdown-item text-danger"
                href="{{ url('logout') }}"
                onclick="return confirm('Are you sure you want to logout?')">
                <i class="mdi mdi-logout me-2"></i>
                Logout
              </a>

            </div>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="index.html">
              
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>        