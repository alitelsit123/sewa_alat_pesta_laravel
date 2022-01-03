@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>
@endsection

@section('js_body')
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('/assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>
<script>
  
</script>
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
  });
</script>
@endsection

@section('content-body')
@if(session()->has('msg_success'))
<div class="alert alert-success" role="alert">
    <div class="container">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Berhasil!</strong> {{ session('msg_success') }}
    </div>
</div><!-- alert -->
@endif
@if(session()->has('msg_error'))
<div class="alert alert-danger" role="alert">
    <div class="container">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>!</strong> {{ session('msg_error') }}
    </div>
</div><!-- alert -->
@endif
<div class="az-content az-content-profile pd-t-0">
  <div class="container mn-ht-100p" style="min-height: 500px;">
    <div class="az-content-left az-content-left-profile pd-t-10">
      <div class="az-profile-overview">
        <div class="d-flex justify-content-between w-100 pd-b-20">
          <img src="{{ asset('assets/'.($user->profile->photo ? 'uploads/users/'.$user->profile->photo: 'dist-base/img/faces/face10.jpg')) }}" alt="" class="rounded-10" style="max-width: 101px;max-height: 101px;" id="showed-photo">
          @if(auth()->check() && $is_me)
          
          <form action="{{ url('/profile/'.$user->email.'/update_photo/') }}" class="flex-grow-1" enctype="multipart/form-data" method="post">
            @csrf
            @method('put')
            <input type="file" class="d-none" name="photo" id="input_photo" />
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
            <p class="az-profile-name-text">{{ $user->email }}</p>
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
        @endif
        @guest
        <a href="#profile-setting-tab" class="nav-link active" data-toggle="tab" id="setting"><i class="typcn typcn-user"></i> Biodata</a>
        @endguest
      </nav>
      <div class="tab-content">
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

        <div class="az-profile-body tab-pane {{ request()->input('o') == 'setting' ? 'active': (auth()->check() ? 'fade':'active' ) }}" id="profile-setting-tab">
          
          <div id="profil-info">
            <div class="d-flex mg-b-10 pd-b-10 bd-b bd-gray-200">
              <div style="width: 100px;">Nama</div>
              <div class="flex-grow-1">{{ $user->profile->nama ?? '[Belum disetel]' }}</div>
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
              <div class="flex-grow-1">{{ $user->profile->alamat ?? '[Belum disetel]' }}</div>
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
          <form action="{{ url('/profile/'.$user->email.'/update/') }}" method="post">
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
                  <label class="form-label">Alamat</label>
                  <textarea type="text" name="profile_alamat" class="form-control" placeholder="Alamat lengkap" style="height: 200px;">{{ $user->profile->alamat }}</textarea>
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
              <span class="mg-r-10 tx-24"><i class="typcn typcn-filter"></i></span>
              <input type="text" class="form-control bd-indigo px-4 flex-grow-1 mg-l-10" placeholder="Cari pesananmu disini" disabled="true" />
              <select class="form-control select2-no-search flex-grow-1 mg-l-10" disabled="true">
                <option label="Kategori"></option>
                <option value="Firefox">Firefox</option>
                <option value="Chrome">Chrome</option>
                <option value="Safari">Safari</option>
                <option value="Opera">Opera</option>
                <option value="Internet Explorer">Internet Explorer</option>
              </select>
            </div>
            <div class="d-flex align-items-center">
              <span class="tx-medium mg-r-10">Status</span>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history" class="btn {{
                (request()->input('t') == '0') ? 
                'btn-indigo': (!request()->input('t') ? 
                'btn-indigo': ((request()->input('t') != '1' && request()->input('t') != '2') && (request()->input('t') != '3') && (request()->input('t') != '4') ? 
                'btn-indigo': 'btn-outline-light'))
              }} mg-r-10 rounded-pill">Semua</a>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history&t=1" class="btn {{ request()->input('t') == '1' || request()->input('t') == '2' ? 'btn-indigo': 'btn-outline-light' }} mg-r-10 rounded-pill">Belum di bayar</a>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history&t=3" class="btn {{ request()->input('t') == '3' ? 'btn-indigo': 'btn-outline-light' }} mg-r-10 rounded-pill">Sudah bayar</a>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history" class="btn btn-outline-light mg-r-10 rounded-pill disabled">Selesai</a>
              <a href="{{ url('/profile/'.auth()->user()->email) }}?o=history&t=4" class="btn  {{ request()->input('t') == '4' ? 'btn-indigo': 'btn-outline-light' }} rounded-pill">Kedaluarsa</a>
            </div>
          </div>
          @forelse($user->orderWithFilter(request()->input('t')) as $row)
          <div class="card mg-b-20">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <span class="badge {{ $row->badge() }}">{{ ucfirst($row->statusText()) }}</span>
                  <span class="tx-14 tx-semibold tx-gray-700 mx-2">&bull;</span>
                  <span class="tx-12 tx-gray-700">{{ $row->created_at }}</span>
                  <span class="tx-14 tx-semibold tx-gray-700 mx-2">&bull;</span>
                  <span class="tx-12 tx-gray-700">{{ $row->kode_pesanan }}</span>
                </div>
              </div>
            </div><!-- card-header -->
            <div class="card-body">
              <div class="d-flex pd-b-10 mg-b-10">
                <div class="d-flex bd-r bd-2 bd-gray-300 flex-grow-1">
                  <img src="{{ asset('/assets/uploads/produk/'.$row->details[0]->produk->gambar) }}" alt="image responsive" srcset="" class="img-fluid mg-r-10" />
                  <div class="d-flex flex-column">
                    <span class="tx-14">{{ $row->details->count() > 1 ? $row->details->get(0)->produk->nama_produk.' <span=\'tx-medium\'>+'.($row->details->count()-1).'</span>':$row->details->get(0)->produk->nama_produk }}</span>
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
                @if($row->status < 3)
                  @if(!$row->dpPayment() || !$row->fullPayment())
                  <a href="https://app.sandbox.veritrans.co.id/snap/v2/vtweb/{{ $row->status == 1 ? $row->payment->where('tipe_pembayaran', 1)->first()->snap_token: $row->payment->where('tipe_pembayaran', 2)->first()->snap_token }}" target="_blank" class="btn btn-outline-indigo tx-medium btn-sm rounded-pill mg-l-10">
                    Bayar
                  </a>
                  <!-- @endif -->
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
                    <span>{{ ucfirst($row->statusText()) }}</span>
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
                    <div class="d-flex justify-content-between">
                      <div>
                        {{ $p_row->getTipe() }} 
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
                      <div>Rp. {{ $p_row->total_bayar }}</div>
                    </div>
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
                      <div>{{ $row->user->profile->alamat }}</div>
                    </div>
                  </div>
                  <div>
                    <h6>Detail Produk</h6>
                    @foreach($row->details as $detail)
                    <div class="bd rounded-10 pd-10 mg-b-10">
                      <div class="d-flex align-items-center">
                        <div class="d-flex bd-r flex-grow-1">
                          <img src="{{ asset('/assets/uploads/produk/'.$detail->produk->gambar) }}" alt="image responsive" srcset="" class="img-fluid mg-r-10" />
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