<div class="az-header">
  <div class="container">
    <div class="az-header-left">
      <a href="{{ url('/') }}" class="az-logo" style="text-decoration: none;text-transform: capitalize!important; color:#133863;"><span></span> Mita</a>
      <a href="#" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
    </div><!-- az-header-left -->

    <div class="az-header-menu flex-grow-1 px-5">
      <div class="az-header-menu-header">
        <a href="{{ url('/') }}" class="az-logo" style="text-decoration: none;text-transform: capitalize!important;"><span></span> Mita</a>
        <a href="#" class="close">&times;</a>
      </div><!-- az-header-menu-header -->
      <ul class="nav">
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link"><i class="typcn typcn-home-outline"></i> Home</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/products') }}" class="nav-link"><i class="typcn typcn-th-list-outline"></i> Produk</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/about') }}" class="nav-link"><i class="typcn typcn-news"></i> Tentang</a>
        </li>
        
      </ul>
    </div><!-- az-header-menu -->
    <div class="az-header-right justify-content-end">
      <form class="az-header-search-link" action="{{ url('/products') }}" method="get">
        <input type="text" name="q" class="form-control rounded-pill bd-indigo px-4" placeholder="Cari produk..." />
      </form>
      
      <div class="az-header-message">
        <a id="links" href="{{ url('/cart') }}" @auth class="{{ auth()->user()->carts()->count() > 0 ? 'new': '' }}" @endauth><i class="typcn typcn-shopping-cart"></i></a>
      </div>
      @auth
      <div class="dropdown az-header-notification">
        <a href="#" @if(auth()->user()->unreadNotifications()->count() > 0) class="new" @endif id="btn-notification"><i class="typcn typcn-bell"></i></a>
        <div class="dropdown-menu pd-0" style="width: 500px!important">
          <div class="az-dropdown-header mg-b-20 d-sm-none">
            <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
          </div>
          <h6 class="az-notification-title">Notifikasi</h6>
          <p class="az-notification-text mg-b-0 bd-b pd-b-10">Kamu memiliki {{ auth()->user() ? auth()->user()->unreadNotifications()->count():'0' }} notifikasi yang belum dibaca.</p>
          <div class="az-notification-list" id="notification-list" style="max-height: 400px;overflow-y: auto;">
            @auth
              @foreach(auth()->user()->notifications()->get() as $row)
              <div class="media notification-item notification-mark @if($row->unread()) notification-unread @else notification-read @endif">
                <!-- <div class="az-img-user"><img src="" alt=""></div> -->
                <div class="media-body flex-grow-1">
                  <p>{!! $row->data['text'] ?? '' !!}</p>
                  <span>{{ $row->created_at }}</span>
                </div>
                <!-- <div class="notification-mark @if($row->unread()) notification-unread @else notification-read @endif">
                    <i class="">&bull;</i>
                </div> -->
              </div>
              @endforeach
            @endauth

            <!-- <div class="media new">
              <div class="az-img-user online"><img src="../img/faces/face3.jpg" alt=""></div>
              <div class="media-body">
                <p><strong>Joyce Chua</strong> just created a new blog post</p>
                <span>Mar 13 04:16am</span>
              </div>
            </div> -->

          </div><!-- az-notification-list -->
          <!-- <div class="dropdown-footer"><a href="#">View All Notifications</a></div> -->
        </div><!-- dropdown-menu -->
      </div><!-- az-header-notification -->
      @endauth
      <!-- <a href="#" class="az-header-search-link"><i class="fas fa-search"></i></a> -->
      @guest
      <a href="{{ url('/auth/login') }}" class="nav-link tx-indigo bd-l bd-2 bd-indigo py-1 pd-r-0 mg-l-20 mg-r-0">
        <!-- <i class="typcn typcn-user"></i> -->
        Masuk
      </a>
      @endguest
      @auth
      <div class="dropdown az-profile-menu">
        <a href="#" class="az-img-user rounded-circle bd bd-2 bd-indigo">
          <!-- <i class="typcn typcn-user"></i> -->
          <img src="{{ asset('assets/'.(auth()->user()->profile->photo ? 'uploads/users/'.auth()->user()->profile->photo: 'dist-base/img/faces/face10.jpg')) }}" alt="">
        </a>
        <div class="dropdown-menu">
          <div class="az-dropdown-header d-sm-none">
            <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
          </div>
          <div class="az-header-profile">
            <div class="az-img-user">
              <img src="{{ asset('assets/'.(auth()->user()->profile->photo ? 'uploads/users/'.auth()->user()->profile->photo: 'dist-base/img/faces/face10.jpg')) }}" alt="">
            </div><!-- az-img-user -->
            <h6>{{ auth()->user()->profile ? auth()->user()->profile->nama: '[Belum di Setel]' }}</h6>
            <span>{{ auth()->user()->email }}</span>
          </div><!-- az-header-profile -->

          <a href="{{ route('profile.show', auth()->user()->email) }}" class="dropdown-item"><i class="typcn typcn-user-outline"></i> Profilku</a>
          <a href="{{ route('profile.show', auth()->user()->email) }}?o=setting" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
          <a href="{{ route('profile.show', auth()->user()->email) }}?o=history" class="dropdown-item"><i class="typcn typcn-document-text"></i> Pesananku</a>
          <form action="{{ route('user.logout') }}" method="post" id="logout" class="w-100 d-flex justify-content-center my-2">
            @csrf
            <button type="submit" class="btn btn-danger rounded-pill flex-grow-1">Keluar</button>
          </form>
        </div><!-- dropdown-menu -->
      </div>
      @endauth
    </div><!-- az-header-right -->
  </div><!-- container -->
</div><!-- az-header -->