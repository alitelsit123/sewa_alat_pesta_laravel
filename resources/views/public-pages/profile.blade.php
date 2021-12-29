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
  $(document).ready(function() {
    var btn_ubah_info = document.getElementById('btn-ubah-info');
    var profile_info_box = document.getElementById('profil-info');
    var profile_info_edit_box = document.getElementById('profil-info-edit');
    btn_ubah_info.addEventListener('click', function() {
      profile_info_box.style.display = 'none';
      profile_info_edit_box.style.display = 'block';
    });
  });
</script>
@endsection

@section('content-body')
<div class="az-content az-content-profile pd-t-0">
  <div class="container mn-ht-100p" style="min-height: 500px;">
    <div class="az-content-left az-content-left-profile pd-t-10">
      <div class="az-profile-overview">
        <div class="d-flex justify-content-between w-100 pd-b-20">
          <img src="{{ asset('/assets/dist-base/img/faces/face10.jpg') }}" alt="" class="rounded-10" style="max-width: 101px;max-height: 101px;">
          <button class="btn btn-with-icon btn-rounded btn-sm flex-grow-1"><i class="typcn typcn-pencil"></i> Ubah Gambar</button>
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
        <a href="#aktifitas-tab" class="nav-link active" data-toggle="tab"><i class="typcn typcn-chart-pie"></i> Aktifitas</a>
        <a href="#profile-setting-tab" class="nav-link" data-toggle="tab"><i class="typcn typcn-user"></i> Ubah Biodata</a>
        <a href="#" class="nav-link disabled"><i class="typcn typcn-cog"></i> Pengaturan</a>
      </nav>
      <div class="tab-content">
        <div class="az-profile-body tab-pane active" id="aktifitas-tab">
          <div class="bd-b bd-2 bd-gray-200 pd-b-10 mg-b-10">
            <div class="tx-medium tx-18">Transaksi</div>
            <div class="d-flex">
              <div>Anda melakukan transaksi pada 2020-01-01</div>
            </div>
          </div>
          <div class="bd-b bd-2 bd-gray-200 pd-b-10 mg-b-10">
            <div class="tx-medium tx-18"></div>
            <div class="d-flex">
              <div>Anda menyukai Produk Meja Besar</div>
            </div>
          </div>
        </div>
        <!-- az-profile-body -->

        <div class="az-profile-body tab-pane fade" id="profile-setting-tab">
          
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
            <div class="d-flex justify-content-end pd-b-10">
              <button class="btn btn-with-icon btn-indigo" id="btn-ubah-info"><i class="typcn typcn-pencil"></i> Ubah Biodata</button>
            </div>
          </div>

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
              <button class="btn btn-with-icon btn-indigo"><i class="typcn typcn-pencil"></i> Simpan</button>
            </div>
          </div>

        </div>
        <!-- az-profile-body -->
      </div>

    </div>
    <!-- az-content-body -->
  </div>
  <!-- container -->
</div>
<!-- az-content -->
@endsection