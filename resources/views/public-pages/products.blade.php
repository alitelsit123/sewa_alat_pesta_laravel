@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>
@endsection

@section('js_body')

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>

<script>
</script>
@endsection

@section('content-body')

<div class="az-content az-content-profile bd-b mg-t-10 pd-b-10 pd-t-0">
  <div class="d-flex mx-auto" style="width: 85%;">
    <div class="flex-grow-1">
      @if(session()->has('book'))
        @if(session('book')['from'] && session('book')['to'])
        <div class="content-wrapper w-100">
          <div class="t">
            <h5>Durasi</h5>
          </div>
          <div class="d-flex align-items-center">
            <div class="tx-medium tx-gray-500">
              <span>Dari {{ session('book.from') }}</span>
            </div>
            <span class="mg-x-20">|</span>
            <div class="tx-medium tx-gray-500">
              <span>Sampai {{ session('book.to') }}</span>
            </div>
            <span class="mg-x-20">|</span>
            <div class="d-flex align-items-center">
              <button type="button" class="btn btn-indigo modal-effect" data-toggle="modal" data-target="#change-duration">Ubah</button>
            </div>
          </div>
        </div>
        @endif
        <div id="change-duration" class="modal">
          <div class="modal-dialog" role="document">
            <form action="{{ route('set.duration') }}" method="post">
              <div class="modal-content modal-content-demo">
                <div class="modal-header">
                  <h6 class="modal-title">Ubah Durasi</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="t">
                      <h5>Pilih Durasi</h5>
                    </div>
                    <div class="">
                      <div class="mg-b-10">
                        <p class="mg-b-5 mg-r-10 tx-semibold">Dari</p>
                        <input type="date" name="from" value="{{session('book.from')}}" class="form-control" placeholder="MM/DD/YYYY">
                      </div>
                      <div class="mg-b-10 ">
                        <p class="mg-b-5 mg-r-10 tx-semibold">Sampai</p>
                        <input type="date" name="to" value="{{session('book.to')}}" class="form-control" placeholder="MM/DD/YYYY">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-indigo">Cari Produk</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      @else
      <div class="content-wrapper w-100">
        <form action="{{ route('set.duration') }}" method="post">
          @csrf
          <div class="t">
            <h5>Pilih Durasi</h5>
          </div>
          <div class="d-flex align-items-end">
            <div class="mg-r-10 d-flex align-items-center">
              <p class="mg-b-5 mg-r-10 tx-semibold">Dari</p>
              <input type="date" name="from" class="form-control" placeholder="MM/DD/YYYY">
            </div>
            <div class="mg-r-10 d-flex align-items-center">
              <p class="mg-b-5 mg-r-10 tx-semibold">Sampai</p>
              <input type="date" name="to" class="form-control" placeholder="MM/DD/YYYY">
            </div>
            <div class="d-flex align-items-center">
              <button type="submit" class="btn btn-indigo">Cari</button>
            </div>
          </div>
        </form>
      </div>
      @endif
    </div>
    <div class="d-flex align-items-center">
      <button
      type="button"
      data-toggle="modal"
      data-target="#modal-help-funding-fee"
      class="btn tx-semibold tx-indigo" style="text-decoration: underline;" >Funding Fee rate</button>
      <span class="tx-semibold">30% (per 2 hari)</span>
    </div>
  </div>
</div>

<div class="az-content pd-0">
  <div class="container">
    <div class="az-content-left az-content-left-components pd-y-20">
      <div class="component-item mg-b-10">
        <span class="tx-20 tx-medium">Filter</span>
      </div><!-- component-item -->
      <div class="component-item py-2">
        <label class="d-flex justify-content-between align-items-center pd-b-10">
          <span>Kategori</span>
          @if(request()->get('k'))
          <a href="{{ url('/products') }}" class="mg-r-10 pd-0 " style="text-decoration: none;">Hapus</a>
          @endif
        </label>
        <nav class="nav flex-column">
          @foreach($kategoris as $row)
          <a href="{{ '?'.Support::appendQueryUrl('k', $row->id_kategori) }}" class="nav-link text-capitalize @if(request()->query('k') == $row->id_kategori) active @endif">{{ strtolower($row->nama_kategori) }}</a>
          @endforeach
        </nav>
      </div><!-- component-item -->

    </div><!-- az-content-left -->
    <div class="az-content-body pd-lg-l-40 d-flex flex-column pd-y-20">
      @if(array_key_exists('q', request()->query()))
      <div class="tx-32 tx-semibold tx-gray-400">Hasil Pencarian</div>
      <div class="tx-24 tx-semibold tx-gray-700 mg-b-10">"{{ request()->query()['q'] }}"</div>
      @endif
      <!-- <div class="az-content-breadcrumb">
        <span>Utilities</span>
        <span>Display</span>
      </div> -->
      <div class="row mg-b-20">
        <div class="col-md-12 d-flex align-items-center mg-b-20">
          <div class="tx-13 tx-medium tx-gray-500">({{ $produk_new->total() }}) Produk Ditemukan</div>
        </div>
        @forelse($produk_new as $row)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item mb-2 ">
          <div class="card w-100 position-relative">
            <div class="card-body">
                @php
                $stoks = $filteredPesanan->whereDoesntHave('details', function($query) use($row){
                    $query->whereId_produk($row->id_produk);
                })->first();
                // return dd($stoks->details->first());
                if($stoks) {
                    $stoks = $stoks->details()->selectRaw('id_produk, sum(kuantitas) as ordered_sum_kuantitas')->groupBy('id_produk')->first();
                    // dd($stoks);
                }
                // $stoks = \App\Models\DetailPesanan::whereId_produk($row->id_produk)->whereHas('order', function($query) {
                //     $query->where([['tanggal_mulai', '>', session('book')['from']], ['tanggal_mulai', '<', session('book')['to']]])
                //     ->orWhere([['tanggal_selesai', '>', session('book')['from']], ['tanggal_selesai', '<', session('book')['to']]])
                //     ->orWhere([['tanggal_mulai', '<', session('book')['from']], ['tanggal_selesai', '>', session('book')['to']]])
                //     ->has('sewa')->get();
                // });
                // dd($stoks);
                @endphp
              <div class="position-absolute {{ $row->stok - $row->ordered_sum_kuantitas < 1 ? 'bg-danger':'bg-indigo'  }} px-2 py-1 tx-9 tx-white" style="top: 0;right: 0;">
                {{-- {{ $row->stok - $row->ordered_sum_kuantitas < 1 ? 'Stok Habis':($row->stok - $row->ordered_sum_kuantitas).' Stok tersisa'  }} --}}
                @if($stoks)
                {{ $row->stok - $stoks->ordered_sum_kuantitas < 1 ? 'Stok Habis':($row->stok - $stoks->ordered_sum_kuantitas).' Stok tersisa' }}
                @else
                {{ $row->stok.' Stok tersisas' }}
                @endif
            </div>
              <div class="product-img-outer w-100">
                <img class="product_image mg-b-5" src="{{ asset('/assets/uploads/produk/'.$row->gambar) }}" alt="prduct image" class="img-fluid" width="100%">
              </div>
              <a href="{{ route('product-view', ['kategori' => $row->kategori->nama_kategori ?? uniqid(),'slug' => $row->nama_produk, 'id' => $row->id_produk]) }}" class="btn pd-0">
                <div class="product-title tx-18">{{ $row->nama_produk }}</div>
              </a>
              <p class="product-price"><span class="tx-bold">Rp. {{ number_format($row->harga) }}</span> /unit</p>
              <!-- <p class="product-actual-price">$99.00</p> -->
              <!-- <ul class="product-variation">
                <li><a href="#">S</a></li>
                <li><a href="#">M</a></li>
              </ul> -->
              <p class="product-description">{{ $row->keterangan_pendek ?? '' }}</p>
            </div>
            <!-- <div class="card-footer pd-5">
              <form action="{{ route('add-to-cart') }}" method="post">
                @csrf
                <div class="d-flex justify-content-end">
                  <input type="hidden" name="produk_id" value="{{ $row->id_produk }}" />
                  <input type="hidden" name="kuantitas" class="form-control rounded-pill text-center wd-100" value="1" />
                  <button class="btn btn-icon tx-medium disabled"><i class="typcn icon typcn-heart-outline"></i></button>
                  <button class="btn btn-icon tx-medium btn-rounded">
                    <i class="typcn typcn-shopping-cart"></i>
                  </button>
                </div>
              </form>
            </div> -->
          </div>
        </div>
        @empty
        <div class="tx-18 tx-medium">Opps produk tidak ada!</div>
        @endforelse
      </div>
      <div class="d-flex justify-content-end">
        {{ $produk_new->appends($query_new)->links('vendor.pagination.default') }}
      </div>
    </div><!-- az-content-body -->
  </div><!-- container -->
</div><!-- az-content -->
@endsection
