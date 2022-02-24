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
    // hampir sama di halaman keranjang (tambah kurangi stok bedanya ini single produk)
    var button_remove_quantity = document.querySelector('.remove-quantity');
    var button_add_quantity = document.querySelector('.add-quantity');
    button_add_quantity.addEventListener("click", function() {
        var target = document.getElementById('quantity-for-');
        if(parseInt(target.value) >= {{ $produk->stok - $produk->ordered_sum_kuantitas }}) {
            if(!this.disabled) {
                this.disabled = true;
            }
            return;
        }
        target.value=parseInt(target.value)+1;
        if(button_remove_quantity.disabled) {
            button_remove_quantity.disabled = false;
        }
        
    });
    button_remove_quantity.addEventListener("click", function() {
        var target = document.getElementById('quantity-for-');
        if(parseInt(target.value) > 1) {
            target.value=parseInt(target.value)-1;
            if(this.disabled) {
                this.disabled = false;
            }
            if(button_add_quantity.disabled) {
                button_add_quantity.disabled = false;
            }
        } else {
            this.disabled = true;
        }
    });
    
});
</script>
@endsection
<!-- test -->
@section('content-body')
<div class="pd-20" style="min-height:600px;">
    <div class="container">
        <div class="d-flex">
            <div class="row">
                <div class="col-md-12 mg-b-20 bd-b pd-l-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style2">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/products') }}">{{ explode('/', request()->path())[0] }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/products').'?k='.explode('/', request()->path())[1] }}">{{ explode('/', request()->path())[1] }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ explode('/', request()->path())[sizeof(explode('/', request()->path()))-2] }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-12 bd-b bd-gray-300 pd-b-20 mg-b-20">
                    <div class="row">
                        <div class="col-md-5 pd-l-0">
                            <!-- <img src="{{ asset('/uploads/produk/'.$produk->gambar) }}" alt="" srcset="" class="img-fluid"> -->
                            <img src="{{ asset('/assets/uploads/produk/'.$produk->gambar) }}" alt="" srcset="" class="img-fluid">
                        </div>
                        <div class="col-md-7">
                            <form action="{{ route('add-to-cart') }}" method="post">
                                <div class="bd-b bd-2 bd-gray-200 mg-b-20">
                                    <div class="tx-28 mg-b-10">{{ $produk->nama_produk }}</div>
                                    <div class="tx-18 tx-semibold mg-b-10">Rp. {{ number_format($produk->harga) }}</div>
                                    @csrf
                                    <div class="d-flex align-items-center mg-b-10">
                                        <div class="bd-r bd-2 bd-r-gray-500 px-3 tx-gray-500 tx-12">{{ number_format($produk->stok - $produk->ordered_sum_kuantitas) }} stok tersisa</div>
                                        <div class="px-3">Quantitas</div>
                                        <button class="btn btn-icon remove-quantity" type="button"><i class="typcn typcn-minus-outline"></i></button>
                                        <input type="hidden" name="produk_id" value="{{ $produk->id_produk }}" />
                                        <input type="text" name="kuantitas" class="form-control rounded-pill text-center wd-100" id="quantity-for-" @if($produk->stok - $produk->ordered_sum_kuantitas < 1) value="0" @else value="1" @endif />
                                        <button class="btn btn-icon add-quantity" type="button"><i class="typcn typcn-plus-outline"></i></button>
                                    </div>
                                </div>
                                @error('kuantitas')
                                <div class="mg-b-20">
                                    <div class="alert alert-danger mg-b-0" role="alert">
                                        {{ $message }}
                                    </div><!-- alert -->
                                </div>
                                @enderror
                                <div class="d-flex">
                                    <button class="btn btn-with-icon bd bd-2 bd-gray-700 mg-r-10 disabled"><i class="typcn icon typcn-heart-outline"></i> Favoritkan</button>
                                    <button class="btn btn-with-icon btn-indigo bd bd-2 bd-primary @if($produk->stok - $produk->ordered_sum_kuantitas < 1) disabled @endif" @if($produk->stok - $produk->ordered_sum_kuantitas < 1) @else type="submit" @endif><i class="typcn icon typcn-shopping-cart"></i> Masukkan ke Keranjang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 px-0 pd-b-10">
                    <strong>Keterangan:</strong>
                </div>
                <div class="col-md-12 bd-b bd-gray-300 bg-gray-200">
                    <div class="px-2 py-3" style="min-height: 200px;">{!! $produk->keterangan !!}</div>                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection