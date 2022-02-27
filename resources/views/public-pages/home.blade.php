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
    $(document).ready(function() {
        var images = document.querySelectorAll('.img-fluid');
        images.forEach(function(item) {
            item.style.height = item.offsetWidth+"px";
            console.log(item.offsetWidth)
        });
    })
</script>
@endsection

@section('content-body')
<div class="p-0">

    <div class="jumbotron bg-image-center d-flex justify-content-center align-items-center mb-4" style='min-height: 500px;background-image: url("data:image/jpeg;base64,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");'>
        <!-- <h1 class="display-4">Hello, world!</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> -->
        <div class="d-flex justify-content-center bg-white rounded-md px-4 py-3 rounded-5 bd bd-2 bd-indigo">
            <form action="{{ route('set.duration') }}" method="post">
                @csrf
                <div class="row row-xs">
                    <div class="col-md-12 mb-2">
                        <div class="tx-16 tx-medium">Ingin Menyewa Kapan ?</div>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="from" class="form-control" placeholder="" value="" required>
                    </div><!-- col -->
                    <div class="col-md-4">
                        <input type="date" name="to" class="form-control" placeholder="" value="" required>
                    </div><!-- col -->
                    <div class="col-md-4">
                        <button class="btn btn-indigo w-100" type="submit">Lihat Katalog</button>
                    </div><!-- col -->
                </div><!-- row -->
                <!-- <div class="tx-11 tx-danger mg-t-10">Pencarian waktu dalam prosess</div> -->
            </form>
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
                        <div class="col-md-3 mb-3">
                            <div class="card bd-0 position-relative">
                                <img class="img-fluid" src="{{ asset('/assets/uploads/produk/'.$produk->gambar) }}" alt="Produk Images">
                                <div class="card-img-overlay bg-black-4 d-flex flex-column justify-content-end">
                                <a class="btn pd-0 tx-white tx-semibold tx-18 mg-b-15" href="{{ route('product-view', ['kategori' => $produk->kategori->nama_kategori,'slug' => $produk->nama_produk, 'id' => $produk->id_produk]) }}">{{ $produk->nama_produk }}</a>
                                
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
                                    <a class="pd-0 tx-white" style="text-decoration: none;" href="{{ route('product-view', ['kategori' => $produk->kategori->nama_kategori,'slug' => $produk->nama_produk, 'id' => $produk->id_produk]) }}">
                                        <div class="tx-semibold tx-14">{{ ucfirst($produk->nama_produk) }}</div>
                                        <div class="position-absolute bg-indigo px-2 py-1 tx-9" style="top: 0;right: 0;">{{ ucfirst($produk->kategori->nama_kategori) }}</div>
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