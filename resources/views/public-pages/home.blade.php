@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet" />

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ruda:wght@700&display=swap" rel="stylesheet">
@endsection

@section('js_body')

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>
<script>
    $(document).ready(function() {
        var images = document.querySelectorAll('.img-fluid');
        images.forEach(function(item) {
            item.style.height = item.offsetWidth + "px";
            console.log(item.offsetWidth)
        });
    })
</script>
@endsection

@section('content-body')
<div class="p-0">
    <div style="background: url('assets/img/imghome.jpg');
                background-position: center; background-repeat: no-repeat; background-size: cover; position: relative">
        <div class="p-1">
            <b style="font-size: 65px; font-family: 'Ruda', sans-serif; ">Mita Alat Pesta</b>
            <p style="margin-top:-10px; font-size: 20px; font-family: 'Ruda', sans-serif;">
                Persewaan Alat Pesta Terbaik di Surabaya</p>
        </div>
        <div class="jumbotron bg-image-center d-flex justify-content-center align-items-center mb-4" style="min-height: 200px;">
            <div class="d-flex justify-content-center bg-white rounded-md px-4 py-3 rounded-5 bd bd-2 bd-indigo">
                <form action="{{ route('set.duration') }}" method="post">
                    @csrf
                    <div class="row row-xs">
                        <div class="col-md-12 mb-2">
                            <div class="tx-16 tx-medium">Ingin Menyewa Kapan ?</div>
                        </div>
                        <div class="col-md-4">
                            Mulai Sewa :
                            <input type="date" name="from" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="col-md-4">
                            Sampai :
                            <input type="date" name="to" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <button class="btn btn-indigo w-100" type="submit">Lihat Katalog</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="w-100">
        <div class="az-content-body">
            <!-- Kategori -->
            <div class="container">
                <div class="pd-b-20 bd-b bd-2 bd-gray-200">
                    <div class="d-flex justify-content-center w-100">
                        @foreach($kategoris as $row)
                        <a href="{{ url('/products?k='.$row->id_kategori) }}" class="btn btn-with-icon btn-block">
                            <span class="tx-medium">{{ $row->nama_kategori }}</span>
                        </a>
                        @endforeach
                    </div><!-- row -->
                </div>
                <!-- End Kategori -->
            </div>

            <!-- Item -->
            <div class="py-5 bg-white">
                <!-- Popular -->
                <div class="container">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="az-content-label tx-22">Rekomendasi</div>
                    </div>
                    <div class="row mb-2">
                        @foreach($rekomendasi as $produk)
                        <div class="col-xs-4 col-sm-3 col-md-2 mb-3">
                            <div class="card bd-0 position-relative">
                                <img class="img-fluid" src="{{ asset('/assets/uploads/produk/'.$produk->gambar) }}" alt="Produk Images">
                                <div class="card-img-overlay bg-black-4 d-flex flex-column justify-content-end">
                                    <a class="btn pd-0 tx-white tx-semibold tx-18 mg-b-15" href="{{ route('product-view', ['kategori' => $produk->kategori->nama_kategori ?? uniqid(),'slug' => $produk->nama_produk, 'id' => $produk->id_produk]) }}">{{ $produk->nama_produk }}</a>

                                </div><!-- card-img-overlay -->
                            </div><!-- card -->
                        </div><!-- col -->
                        @endforeach

                    </div><!-- row -->
                </div>
                <!-- End Popular -->
                <div class="container">
                    <hr class="mg-y-30">
                </div>

                <!-- Produk -->
                <div class="container">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="az-content-label tx-22">Produk</div>
                        <a href="{{ url('/products') }}" class="btn tx-gray-600 tx-medium tx-15 pd-0">Tampilkan Lebih Banyak</a>
                    </div>
                    <div class="row mb-2">
                        @foreach($produk_new as $produk)
                        <div class="col-xs-4 col-sm-3 col-md-2 mb-3">
                            <div class="card bd-0 position-relative">
                                <img class="img-fluid" src="{{ asset('/assets/uploads/produk/'.$produk->gambar) }}" alt="Produk Images">
                                <div class="card-img-overlay bg-black-4 d-flex flex-column justify-content-end align-items-center">
                                    <a class="pd-0 tx-white" style="text-decoration: none;" href="{{ route('product-view', ['kategori' => $produk->kategori->nama_kategori ?? uniqid(),'slug' => $produk->nama_produk, 'id' => $produk->id_produk]) }}">
                                        <div class="tx-semibold tx-14">{{ ucfirst($produk->nama_produk) }}</div>
                                        <div class="position-absolute bg-indigo px-2 py-1 tx-9" style="top: 0;right: 0;">{{ ucfirst($produk->kategori->nama_kategori ?? uniqid()) }}</div>
                                    </a>

                                </div><!-- card-img-overlay -->
                            </div><!-- card -->
                        </div><!-- col -->
                        @endforeach

                    </div><!-- row -->
                </div>
                <!-- End Produk -->

                <div class="container">
                    <hr class="mg-y-30">
                </div>

                <div class="container">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="az-content-label tx-22">Pencarian Populer</div>
                    </div>
                    <div class="d-flex">
                        @forelse($popular_search as $row)
                        <a href="{{ url('/products') }}?q={{ $row }}" class="btn btn-outline-dark btn-rounded mg-r-10">#{{ $row }}</a>
                        @empty
                        <div>Tidak ada pencarian</div>
                        @endforelse
                    </div>
                </div>

            </div>
            <!-- End Item -->



        </div>
    </div>

</div>
@endsection