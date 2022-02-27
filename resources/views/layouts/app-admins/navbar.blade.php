<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> -->
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form action="{{ route('admin.search.index') }}" method="get" class="form-inline">
          <div class="input-group input-group-sm">
            <input id="search-general-input" name="s" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="submit" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge" id="minichat-badge">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="px-4 py-2 text-semibold">
          <strong>Requests</strong>
        </div>
        <div id="minichat-request"></div>
        
        <div class="px-4 py-2">
          <strong>Chats</strong>
        </div>
        <div id="minichat-list"></div>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.livechat.index') }}" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span id="notification-badge" class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.order.index').'?f=new' }}" 
          class="dropdown-item">
            <i class="fas fa-shopping-cart mr-1"></i> 
            <span id="notification-neworder">
              {{ auth()->user()->unreadNotifications()->whereType('App\\Notifications\\Admin\\NewOrderCreatedNotification')->count() }}
            </span> Pesanan Baru
            <span class="float-right text-muted text-sm" id="notification-neworder-time">
            @if(auth()->user()->unreadNotifications()->count() > 0)
              {{ \App\Helpers\AppSupport::timeConverter(auth()->user()->unreadNotifications()->whereType('App\\Notifications\\Admin\\NewOrderCreatedNotification')->first()->created_at)['conversion_text'] }}
            @endif
            </span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.transaksi.index').'?f=new' }}" class="dropdown-item">
        <i class="fas fa-money-bill-wave mr-1"></i> 
          <span id="notification-payment">
          {{ auth()->user()->unreadNotifications()->whereType('App\\Notifications\\Admin\\UserPaymentSuccessNotification')->count() }}
          </span> Pembayaran
          <span class="float-right text-muted text-sm" id="notification-payment-time">
            @if(auth()->user()->unreadNotifications()->whereType('App\\Notifications\\Admin\\UserPaymentSuccessNotification')->count() > 0)
              {{ 
                \App\Helpers\AppSupport::timeConverter(
                  auth()->user()->unreadNotifications()
                  ->whereType('App\\Notifications\\Admin\\UserPaymentSuccessNotification')
                  ->first()->created_at
                )['conversion_text'] 
              }}
            @endif
          </span>
        </a>
        <div class="dropdown-divider"></div>
        <!-- <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div> -->
        <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>

@include('layouts.app-admins.notification-lists', ['modal_id' => 'App\\Notifications\\Admin\\NewOrderCreatedNotification','title_modal' => 'Notifikasi pesanan baru', 'items' => auth()->user()->unreadNotifications()->whereType('App\\Notifications\\Admin\\NewOrderCreatedNotification')->get()])
