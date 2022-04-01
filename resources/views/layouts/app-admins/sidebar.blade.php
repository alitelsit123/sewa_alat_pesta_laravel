<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('admin/dashboard') }}" class="brand-link">
    <img src="{{ asset('/assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ env('APP_NAME') ?? 'Mita' }} Administrator</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ auth()->user()->profile->photo ?? auth()->user()->profile->getPhoto() }}" class="img-circle elevation-2" style="background-color: white;opacity: .8;" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block disabled">{{ auth()->user()->email }}</a>
      </div>
    </div>

    <!-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
    <!-- <li class="user-panel"></li> -->

        <li class="nav-item">
          <a href="{{ url('/admin/dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.kategori.index') }}" class="nav-link">
            <i class="nav-icon fas fa-swatchbook"></i>
            <p>
              Kategori
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.produk.index') }}" class="nav-link">
            <i class="nav-icon fab fa-accusoft"></i>
            <p>
              Produk
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.order.index') }}" class="nav-link">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Pesanan
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.transaksi.index') }}" class="nav-link">
            <i class="nav-icon fas fa-cash-register"></i>
            <p>
              Transaksi
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.sewa.index') }}" class="nav-link">
            <i class="nav-icon fas fa-fire"></i>
            <p>
              Sewa
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.user.index') }}" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Pengguna
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <!--<li class="nav-item">
          <a href="{{ route('admin.livechat.index') }}" class="nav-link">
            <i class="nav-icon fas fa-headset"></i>
            <p>
              Chat
            </p>
          </a>
        </li> -->
        <li class="nav-item">
          
              <a href="#" class="nav-link">
              <form action="{{ route('admin.logout') }}" method="post" id="logout" class="w-100" onclick="this.submit()">
              @csrf      <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
                </form>
              </a>    
          
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>