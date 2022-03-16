@extends('layouts.app-admin')

@section('content-body')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
              src="data:image/png;base64,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"
              alt="User profile picture">
          </div>
          <h3 class="profile-username text-center">{{ $user->email }}</h3>
          <a href="#" class="btn btn-primary btn-block disabled"><b>Blokir</b></a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
            <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Profile</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> -->
          </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="activity">
              <p>List Transaksi ...</p>
            </div>
            <div class="tab-pane" id="profile">
            <table class="table">
                  <tbody>
                    <tr>
                      <td>Nama</td>
                      <td class="text-center">{{ $user->profile->nama ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td class="text-center">{{ $user->profile->nik ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td class="text-center">{{ $user->email ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>Telepon</td>
                      <td class="text-center">{{ $user->profile->telepon ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Lahir</td>
                      <td class="text-center">{{ $user->profile->tanggal_lahir ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td class="text-center">{{ $user->profile->alamat ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>Kodepos</td>
                      <td class="text-center">{{ $user->profile->kodepos ?? '(Belum disetel)' }}</td>
                    </tr>
                    <tr>
                      <td>Pekerjaan</td>
                      <td class="text-center">{{ $user->profile->pekerjaan ?? '(Belum disetel)' }}</td>
                    </tr>
                    <!-- <tr>
                      <td>Photo</td>
                      <td class="text-center">{{ $user->profile->photo ?? '(Belum disetel)' }}</td>
                    </tr> -->
                  </tbody>
                </table>
            </div>
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection