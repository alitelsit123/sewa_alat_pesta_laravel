@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>

 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
@endsection

@section('js_body')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>
<script>
  $(document).ready(function() {
    var btn_ubah_info = document.getElementById('btn-ubah-info');
    var profile_info_box = document.getElementById('profil-info');
    var profile_info_edit_box = document.getElementById('profil-info-edit');
    var btn_edit_photo = document.getElementById('btn-edit-photo');
    var input_photo = document.querySelector('input[name="photo"]');
    var blah = document.getElementById('showed-photo');
    var btn_submit = document.getElementById('submit-photo');
    btn_ubah_info.addEventListener('click', function() {
      profile_info_box.style.display = 'none';
      profile_info_edit_box.style.display = 'block';
    });
    @if(session()->has('address_added')) 
    console.log('{{ session("address_added") }}');
    btn_ubah_info.click();
    @endif
    btn_edit_photo.addEventListener('click', function() {
      input_photo.click();
    });
    input_photo.addEventListener('change', function() {
        btn_submit.style.display = 'block';
        const [file] = this.files
        if (file) {
          blah.src = URL.createObjectURL(file)
        }
    });

    $.each($('.map'), function(index, item) {
      var default_lat = -7.993957436359008;
      var default_lng = 112.6318359375;
      if($(item).data('lat') != '' && $(item).data('lng') != '') {
        var default_lat = $(item).data('lat');
        var default_lng = $(item).data('lng');
      }
      var map = L.map(item).setView([default_lat, default_lng], 6);
      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWl0YXBlc3RhMTIzIiwiYSI6ImNsMTU1M2VnbjBkMmozanRleW02eHplODMifQ.5TxVEfhUO75qwJ6YSW-0Ug', {
          attribution: 'Mita',
          maxZoom: 18,
          id: 'mapbox/streets-v11',
          tileSize: 512,
          zoomOffset: -1,
          accessToken: 'pk.eyJ1IjoibWl0YXBlc3RhMTIzIiwiYSI6ImNsMTU1M2VnbjBkMmozanRleW02eHplODMifQ.5TxVEfhUO75qwJ6YSW-0Ug'
      }).addTo(map);

      if($(item).data('lat') != '' && $(item).data('lng') != '') {
        var marker = L.marker([$(item).data('lat'), $(item).data('lng')], {
          draggable:true
        }).addTo(map);
      } else {
        var marker = L.marker([default_lat, default_lng], {
          draggable:true
        }).addTo(map);
      }
      marker.on('move', function(e) {
        $('input[name="map_lat_'+$(item).data('id')+'"]').val(e.latlng.lat);
        $('input[name="map_lng_'+$(item).data('id')+'"]').val(e.latlng.lng);
      });

    });


    $('.btn-map-toggle').click(function() {

    });

    $('.az-toggle').on('click', function(){
      $(this).toggleClass('on');
      if($(this).hasClass('on')) {
        $("#container_map_"+$(this).data('id')+"").css('display', 'block');
        $('input[name="map_latlng_'+$(this).data('id')+'"]').val('on');
      } else {        
        $("#container_map_"+$(this).data('id')+"").css('display', 'none');
        $('input[name="map_latlng_'+$(this).data('id')+'"]').val('off');
      }
    })
  });
</script>


<script>

</script>
@endsection

@section('content-body')
<div class="az-content az-content-profile pd-t-0">
  <div class="container mn-ht-100p" style="min-height: 500px;">
    <div class="az-content-left az-content-left-profile pd-t-10">
      <div class="az-profile-overview">
        <div class="d-flex justify-content-between w-100 pd-b-20">
          <img src="{{ asset($user->profile->getPhoto()) }}" alt="" class="rounded-10" style="max-width: 101px;max-height: 101px;" id="showed-photo">
          @if(auth()->check() && $is_me)
          
          <form action="{{ url('/profile/'.$user->profile->id_profile.'/update_photo/') }}" class="flex-grow-1" enctype="multipart/form-data" method="post">
            @csrf
            @method('put')
            <input type="file" class="d-none" accept="image/*" name="photo" id="input_photo" />
            <label for="input_photo">
              <button class="btn btn-with-icon btn-rounded btn-sm mx-auto" id="btn-edit-photo" type="button"><i class="typcn typcn-pencil"></i> Ubah Gambar</button>
            </label>
            <button class="btn btn-indigo btn-with-icon btn-rounded btn-sm mx-auto" style="display: none;" id="submit-photo" type="submit"><i class="typcn typcn-check"></i> Simpan</button>
          </form>
          @endif
        </div>
        <!-- az-img-user -->
        <div class="d-flex justify-content-between mg-b-20">
          <div>
            <h5 class="az-profile-name">{{ $user->profile->nama ?? '[ Nama Belum di setel ]' }}</h5>
            <p class="az-profile-name-text">{{ $user->email }} 
              @if(auth()->check() && $is_me)
                @if(auth()->user()->email_verified_at == null)
                  <span class="badge badge-warning">Not Verified</span>
                @else 
                  <span class="badge badge-success">Verified</span>
                @endif
              @endif
            </p>
          </div>
          <div class="btn-icon-list">
          </div>
        </div>
        
      </div>
      <!-- az-profile-overview -->
    </div>
    <!-- az-content-left -->
    <div class="az-content-body az-content-body-profile">
      <nav class="nav az-nav-line">
        @if(auth()->check() && $is_me)
        <a href="#aktifitas-tab" class="nav-link {{ 
          (request()->input('o') == 'activity') ? 
          'active': (!request()->input('o') ? 
          'active': ((request()->input('o') != 'setting' && request()->input('o') != 'history') ? 
          'active': '')) 
        }}" data-toggle="tab" id="activity"><i class="typcn typcn-chart-pie"></i> Aktifitas</a>
        <a href="#profile-setting-tab" class="nav-link {{ request()->input('o') == 'setting' ? 'active': '' }}" data-toggle="tab" id="setting"><i class="typcn typcn-user"></i> Biodata</a>
        <a href="#profile-history-tab" class="nav-link {{ request()->input('o') == 'history' ? 'active': '' }}" data-toggle="tab" id="history"><i class="typcn typcn-document-text"></i> Riwayat</a>
        <a href="#" class="nav-link disabled"><i class="typcn typcn-cog"></i> Pengaturan</a>
        @else
        <a href="#profile-setting-tab" class="nav-link {{ request()->input('o') == 'setting' ? 'active': '' }}" data-toggle="tab" id="setting"><i class="typcn typcn-user"></i> Biodata</a>
        @endif
      </nav>
      <div class="tab-content">
        @if(auth()->check() && $is_me)
        
        <div class="az-profile-body tab-pane {{
          (request()->input('o') == 'activity') ? 
          'active': (!request()->input('o') ? 
          'active': ((request()->input('o') != 'setting' && request()->input('o') != 'history') ? 
          'active': 'fade'))
        }}" id="aktifitas-tab">
          <div class="bd-b bd-2 bd-gray-200 pd-b-10 mg-b-10">
            <!-- <div class="tx-medium tx-18">Transaksi</div> -->
            <div class="d-flex">
              <div>No data</div>
            </div>
          </div>
          <!-- <div class="bd-b bd-2 bd-gray-200 pd-b-10 mg-b-10">
            <div class="tx-medium tx-18"></div>
            <div class="d-flex">
              <div>Anda menyukai Produk Meja Besar</div>
            </div>
          </div> -->
        </div>
        <!-- az-profile-body -->
        @endif
        <div class="az-profile-body tab-pane @if(auth()->check() && $is_me) {{ request()->input('o') == 'setting' ? 'active': (auth()->check() ? 'fade':'active' ) }} @else active @endif" id="profile-setting-tab">
          
          <div id="profil-info">
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Nama</div>
              <div class="flex-grow-1">{{ $user->profile->nama ?? '[Belum disetel]' }}</div>
            </div>
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Nik</div>
              <div class="flex-grow-1">{{ $user->profile->nik ?? '[Belum disetel]' }}</div>
            </div>
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Tanggal Lahir</div>
              <div class="flex-grow-1">{{ $user->profile->tanggal_lahir ?? '[Belum disetel]' }}</div>
            </div>
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Nomor Hp.</div>
              <div class="flex-grow-1">{{ $user->profile->telepon ?? '[Belum disetel]' }}</div>
            </div>
            
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Alamat</div>
              <div class="flex-grow-1">
                <ul>
                @forelse($user->profile->addresses as $row)
                  @if($row->alamat)
                  <li>
                    {{ $row->alamat  }}
                  </li>
                  @endif
                @empty
                [Belum disetel]
                @endforelse
                </ul>
              </div>
            </div>
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Pekerjaan</div>
              <div class="flex-grow-1">{{ $user->profile->pekerjaan ?? '[Belum disetel]' }}</div>
            </div>
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div>Bergabung sejak {{ $user->created_at }}</div>
            </div>
            @if(auth()->check() && $is_me)
            <div class="d-flex justify-content-end pd-b-10">
              <button class="btn btn-with-icon btn-indigo" id="btn-ubah-info"><i class="typcn typcn-pencil"></i> Ubah Biodata</button>
            </div>
            @endif
          </div>
          @if(auth()->check() && $is_me)
          <form action="{{ url('/profile/'.$user->profile->id_profile.'/update/') }}" method="post">
            @csrf
            @method('put')
            <div id="profil-info-edit" style="display: none;">
              <div class="alert alert-info">
                <strong>Catatan</strong> Pastikan Data sesuai!
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label">Nama</label>
                  <input type="text" name="profile_nama" class="form-control" placeholder="" value="{{ $user->profile->nama }}">
                </div>
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label">Nik</label>
                  <input type="text" name="profile_nik" class="form-control" placeholder="" value="{{ $user->profile->nik }}">
                </div>
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label">Tanggal Lahir</label>
                  <input type="date" name="profile_tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="{{ $user->profile->tanggal_lahir }}">
                </div>
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label">Nomor Telepon</label>
                  <input type="text" name="profile_telepon" class="form-control" placeholder="Nomor telepon" value="{{ $user->profile->telepon }}">
                </div>
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label">Pekerjaan</label>
                  <input type="text" name="profile_pekerjaan" class="form-control" placeholder="Pekerjaanmu" value="{{ $user->profile->pekerjaan }}">
                </div>
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label">Kodepos</label>
                  <input type="text" name="profile_kodepos" class="form-control" placeholder="Kodepos" value="{{ $user->profile->kodepos }}">
                </div>
              </div>
              <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
                <div class="az-form-group w-100">
                  <label class="form-label d-flex justify-content-between" id="add-address" style="cursor: pointer;">
                    <span>Alamat</span>
                    <a href="{{ route('profile.add_address', [$user->profile->id_profile]) }}"><i class="fas fa-plus mg-r-5"></i>Tambah Alamat</a>
                  </label>
                  @php
                  $n = 1;
                  @endphp
                  @foreach($user->profile->addresses as $row)
                  <div class="pd-b-10">
                    <a href="{{ route('profile.remove_address', ['slug' => $user->profile->id_profile, 'id' => $row->id_address]) }}" class="btn"><i class="fas fa-trash-alt"></i></a>
                    <span>Alamat {{ $n++ }}</span> 
                  </div>
                  <div class="d-flex" style="align-items: center;padding-left: 57px;padding-right: 57px;">
                    <textarea type="text" name="alamat_{{ $row->id_address }}" required style="height: 100px;" class="form-control" placeholder="Alamat lengkap">{{ $row->alamat }}</textarea>
                  </div>
                  <!-- <div>
                    <div class="az-toggle-group-demo mg-t-10" style="align-items: center;">
                      <span type="button" class="btn btn-map-toggle" data-id="{{ $row->id_address }}" data-target="#map_{{ $row->id_address }}"><i class="fas fa-map-marked-alt"></i></span>
                      <div class="az-toggle on" data-id="{{ $row->id_address }}"><span></span></div>
                    </div>
                  </div>
                  <div id="container_map_{{ $row->id_address }}" class="pd-b-20 mg-b-10 bd-b bd-gray-200">
                    <div class="mg-t-10 mg-b-20" style="display: flex;" id="map_latlng_{{ $row->id_address }}">
                      <input type="hidden" name="map_latlng_{{ $row->id_address }}" readonly="true"  value="on" />
                      <input type="text" name="map_lat_{{ $row->id_address }}" readonly="true" placeholder="Latitude" class="form-control bd-b bd-gray-200 pd-x-10 pd-y-5" value="{{ $row->lat }}" />
                      <input type="text" name="map_lng_{{ $row->id_address }}" readonly="true" placeholder="Longitude" class="form-control bd-b bd-gray-200 pd-x-10 pd-y-5" value="{{ $row->lng }}" />
                    </div>
                    <div id="map_{{ $row->id_address }}" class="map" data-id="{{ $row->id_address }}" data-lat="{{ $row->lat }}" data-lng="{{ $row->lng }}" style="width: 100%;height: 305px;"></div>
                  </div> -->
                  @endforeach
                </div>
              </div>
              <div class="d-flex justify-content-end pd-b-10">
                <button class="btn btn-with-icon btn-indigo" type="submit"><i class="typcn typcn-pencil"></i> Simpan</button>
              </div>
            </div>
          </form>
          @endif
        </div>
        @if(auth()->check() && $is_me)
        <!-- az-profile-body -->
        <div class="az-profile-body tab-pane  {{ request()->input('o') == 'history' ? 'active': 'fade' }}" id="profile-history-tab">
          <div class="bd-b bd-2 bd-gray-200 mg-b-20 pd-b-10">
            <div class="d-flex align-items-center mg-b-20">
              <span class="tx-medium mg-r-10">Status</span>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history" class="btn {{
                (request()->input('t') == '0') ? 
                'btn-indigo': (!request()->input('t') ? 
                'btn-indigo': ((request()->input('t') != '1' && request()->input('t') != '2') && (request()->input('t') != '3') && (request()->input('t') != '4') ? 
                'btn-indigo': 'btn-outline-light'))
              }} mg-r-10 rounded-pill">Semua</a>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history&t=3" class="btn {{ request()->input('t') == '3' ? 'btn-indigo': 'btn-outline-light' }} mg-r-10 rounded-pill">Selesai</a>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history&t=1" class="btn {{ request()->input('t') == '1' || request()->input('t') == '2' ? 'btn-indigo': 'btn-outline-light' }} mg-r-10 rounded-pill">Belum di lunasi</a>
            </div>
          </div>
          @forelse($user->orderWithFilter(request()->input('t')) as $row)
          <div class="card mg-b-20">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                  <span class="tx-14 tx-semibold tx-gray-700">#{{ $row->kode_pesanan }}</span>
                  <div class="d-flex align-items-center">
                    <span class="tx-12 tx-gray-700 mg-r-5">{{ $row->created_at }}</span>
                    @if($row->status > 1)
                    <span class="badge {{ $row->badge() }}">{{ ucfirst($row->statusText()) }}</span>
                    @endif
                  </div>


                </div>
              </div>
            </div><!-- card-header -->
            
            <div class="card-body">
              @if($row->status > 1 && $row->sewa)
              <!-- Wizard -->
              <div class="d-flex w-80 justify-content-center mg-b-10 pd-b-10 bd-b">
                @if($row->sewa->status == 1) 
                <div class="tx-indigo d-flex flex-column justify-content-center align-items-center flex-grow-1">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-box" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-semibold">Disiapkan</div>
                </div>
                @else
                <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1" style="opacity: 0.4;">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-box" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-gray-700">Disiapkan</div>
                </div>
                @endif
                @if($row->sewa->status == 2) 
                <div class="tx-indigo d-flex flex-column justify-content-center align-items-center flex-grow-1 mx-2">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-truck-loading" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-semibold">Dikirim</div>
                </div>
                @else
                <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1 mx-2" style="opacity: 0.4;">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-truck-loading" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-gray-700">Dikirim</div>
                </div>
                @endif
                @if($row->sewa->status == 3) 
                <div class="tx-indigo d-flex flex-column justify-content-center align-items-center flex-grow-1 mx-2">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-glass-cheers" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-semiboldtx-gray-700">Sewa</div>
                </div>
                @else
                <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1 mx-2" style="opacity: 0.4;">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-glass-cheers" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-gray-700">Sewa</div>
                </div>
                @endif
                @if($row->dpPayment()->total_bayar > 0 && $row->status == 2) 
                <div class="tx-indigo d-flex flex-column justify-content-center align-items-center flex-grow-1">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-money-bill-wave" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-semibold">Lunasi Pembayaran</div>
                </div>
                @elseif($row->dpPayment()->total_bayar > 0 && $row->status == 1)
                <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1" style="opacity: 0.4;">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-money-bill-wave" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-gray-700">Lunasi Pembayaran</div>
                </div>
                @endif
                @if($row->dpPayment()->total_bayar > 0 && $row->status == 1)
                <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1" style="opacity: 0.4;">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-check" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-gray-700">Selesai</div>
                </div>
                @elseif($row->sewa->status == 4 && $row->status == 3) 
                <div class="tx-indigo d-flex flex-column justify-content-center align-items-center flex-grow-1">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-check" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-semibold">Selesai</div>
                </div>
                @else
                <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1" style="opacity: 0.4;">
                  <div class="text-center mg-b-5">
                    <i class="fas fa-check" style="font-size: 30px;"></i>
                  </div>
                  <div class="tx-gray-700">Selesai</div>
                </div>
                @endif
              </div>
              <!-- End Wizard -->
              @endif
              @if($row->details->count() > 0)
                <div class="d-flex pd-b-10 mg-b-10">
                  <div class="d-flex bd-r bd-2 bd-gray-300 flex-grow-1">
                    <img src="{{ asset('/assets/uploads/produk/'.$row->details()->firstOrFail()->produk->gambar) }}" alt="image responsive" srcset="" class="img-fluid mg-r-10" style="width: 80px; height: 80px;" />
                    <div class="d-flex flex-column">
                      <span class="tx-14">{!! $row->details->count() > 1 ? $row->details()->first()->produk->nama_produk.' <span class=\'badge badge-info\'>+'.($row->details->count()-1).' Produk</span>':$row->details->firstOrFail()->produk->nama_produk !!}</span>
                      <span class="tx-12">x{{ $row->details->sum('kuantitas') }} item</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column justify-content-center align-items-center" style="width: 150px;">
                    <div class="tx-14">Total</div>
                    <div class="tx-18 tx-medium">Rp. {{ number_format($row->total_bayar) }}</div>
                  </div>
                </div>  
                <div class="d-flex justify-content-end bd-t pd-t-10">
                  <button class="btn tx-semibold btn-sm rounded-pill tx-gray-700" data-toggle="modal" data-target="#detail-{{ $row->kode_pesanan }}">Lihat detail</button>
                  @if($row->dpPayment()->status == 1)
                  <a href="https://app.sandbox.veritrans.co.id/snap/v2/vtweb/{{ $row->dpPayment()->snap_token }}" target="_blank" class="btn btn-outline-indigo tx-medium btn-sm rounded-pill mg-l-10">
                    Bayar
                  </a>
                  @elseif($row->fullPayment()->status == 1)
                  <a href="https://app.sandbox.veritrans.co.id/snap/v2/vtweb/{{ $row->fullPayment()->snap_token }}" target="_blank" class="btn btn-outline-indigo tx-medium btn-sm rounded-pill mg-l-10">
                    Bayar
                  </a>
                  @else
                  
                  @endif
                @else 
                  <div>
                    <h6>Opss ada kesalahan data.</h6>
                  </div>
                @endif
              </div>
            </div><!-- card-body -->
          </div><!-- card -->
          <!-- BASIC MODAL -->
          <div id="detail-{{ $row->kode_pesanan }}" class="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content modal-content-demo">
                <div class="modal-header">
                  <h6 class="modal-title">Detail Transaksi</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="max-height: 80vh;overflow-y: auto;">
                  <h6 class="d-flex w-100 justify-content-between bd-b bd-gray-200 pd-b-10">
                    <span>Status Pesanan</span>
                    <span>@if($row->status == 2) Dipesan @elseif($row->status == 3) Selesai @endif</span>
                  </h6>
                  <div class="bd-b bd-5 bd-gray-100 pd-b-10 mg-b-10">
                    <div class="d-flex justify-content-between">
                      <div>Kode Pesanan</div>
                      <div class="tx-indigo tx-medium">{{ $row->kode_pesanan }}</div>
                    </div>
                    <div class="d-flex justify-content-between pd-b-20">
                      <div>Tanggal Order</div>
                      <div>{{ $row->created_at }}</div>
                    </div>
                    <h6 class="d-flex w-100 justify-content-between pd-b-0 mg-b-5">
                      <span>Pembayaran</span>
                    </h6>
                    @foreach($row->payment as $p_row)
                      @if($p_row->total_bayar > 0)
                        <div class="d-flex justify-content-between">
                          <div>
                            {{ $p_row->getTipes() }} 
                            @if($p_row->total_bayar == 0) 
                              <span class="badge badge-info">Skip</span>
                            @else
                              @if($p_row->status == 1)
                              <span class="badge badge-warning">Pending</span>
                              @else
                              <span class="badge badge-success">Sukses</span>
                              @endif
                            @endif
                          </div>
                          <div class="tx-medium">Rp. {{ $p_row->total_bayar }}</div>
                        </div>
                      @endif
                    @endforeach
                  </div>
                  <h6>Info</h6>
                  <div class="bd-b bd-5 bd-gray-100 pd-b-10 mg-b-10">
                    <div class="d-flex justify-content-between">
                      <div>Nama</div>
                      <div class="tx-medium">{{ $row->user->profile->nama }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div>Nomor Telepon</div>
                      <div>{{ $row->user->profile->telepon }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div>Alamat</div>
                      <div>{{ $row->address ? $row->address->alamat: '' }}</div>
                    </div>
                  </div>
                  <div>
                    <h6>Detail Produk</h6>
                    @foreach($row->details as $detail)
                    <div class="bd rounded-10 pd-10 mg-b-10">
                      <div class="d-flex align-items-center">
                        <div class="d-flex bd-r flex-grow-1">
                          <img src="{{ asset('/assets/uploads/produk/'.$detail->produk->gambar) }}" style="width: 80px; height: 80px;" alt="image responsive" srcset="" class="img-fluid mg-r-10" />
                          <div class="d-flex flex-column">
                            <span class="tx-14">{{ $detail->produk->nama_produk }}</span>
                            <span class="tx-12">{{ $detail->kuantitas }}</span>
                          </div>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center" style="width: 150px;">
                          <div>Total</div>
                          <div class="tx-medium">Rp. {{ number_format($row->total_bayar) }}</div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>  
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
          @empty
          <div class="d-flex w-100 justify-content-center">
            <h4>Tidak ada data</h4>
          </div>
          @endforelse
        </div>
        <!-- az-profile-body -->
        @endif
      </div>

    </div>
    <!-- az-content-body -->
  </div>
  <!-- container -->
</div>
<!-- az-content -->
@endsection