@extends('layouts.app-admin')

@section('content-body')
<div class="container-fluid">
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $total_order_baru }}</h3>

        <p>New Orders</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{ route('admin.order.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $total_sewa }}
          <!-- <sup style="font-size: 20px">%</sup> -->
        </h3>

        <p>Sewa Berjalan</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="{{ route('admin.sewa.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>Rp. {{ number_format($total_pendapatan) }}</h3>

        <p>Pendapatan</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{ route('admin.transaksi.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $total_user }}</h3>

        <p>Total User</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('admin.user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-pie mr-1"></i>
          Sales
        </h3>
        <div class="card-tools">
          <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
              <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
            </li>
          </ul>
        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content p-0">
          <!-- Morris chart - Sales -->
          <div class="chart tab-pane active" id="revenue-chart"
               style="position: relative; height: 300px;">
              <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
           </div>
          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
            <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
          </div>
        </div>
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->

    
  </section>
  <!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
@endsection