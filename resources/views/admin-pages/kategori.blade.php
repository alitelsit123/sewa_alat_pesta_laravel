@extends('layouts.app-admin')

@section('content-body')
<div class="container-fluid">
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>150</h3>

        <p>New Orders</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>53<sup style="font-size: 20px">%</sup></h3>

        <p>Bounce Rate</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>44</h3>

        <p>User Registrations</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>65</h3>

        <p>Unique Visitors</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="card">
              <div class="card-header d-flex">
                    <form action="" class="form-inline w-100">
                        <div class="form-group flex-grow-1">
                            <input type="text" class="form-control" placeholder="Cari Kategori">
                        </div>
                        <a class="btn btn-primary" href="{{ route('kategori.create') }}">Tambah Kategori</a>
                    </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th style="width: 20%" class="text-center">#</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($categories as $row)  
                    <tr>
                      <td>Update software</td>
                      <td class="text-center">
                          <button class="btn btn-sm btn-warning">Edit</button>
                          <button class="btn btn-sm btn-danger">Hapus</button>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="2">Tidak Ada Kategori!!!</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection