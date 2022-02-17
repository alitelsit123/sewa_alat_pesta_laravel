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
    $(function(){
    'use strict'

    $('#order-listing').DataTable({
    "aLengthMenu": [
    [5, 10, 15, -1],
    [5, 10, 15, "All"]
    ],
    "iDisplayLength": 10,
    "language": {
    search: ""
    },
    "bInfo": false,
    "bLengthChange": false,
    "bFilter": false,
    "bPaginate": false,
});
$('#order-listing').each(function() {
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    search_input.attr('placeholder', 'Search');
    search_input.removeClass('form-control-sm');
    // LENGTH - Inline-Form control
    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    length_sel.removeClass('form-control-sm');
});

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
</script>

<script>
    $(document).ready(function() {
        var content_wrapper = document.getElementById('content-wrapper');
        var btn_submit = document.getElementById("btn_submit");
        var all_cart_check = document.querySelector("input[name='semua_keranjang']");
        var carts = document.querySelectorAll("input[name='keranjang[]']");
        var inputs_init = document.querySelectorAll("input[name='kuantitas[]']");
        var btn_update_keranjang = document.getElementById('btn_update_keranjang');
        var submitter = [];
        var checked_carts = {};
        function add_checked_cart(key){
            var el = document.getElementById('quantity-for-'+key);
            checked_carts['quantity-for-'+key] = el;
        }
        function remove_checked_cart(key) {
            var el = document.getElementById('quantity-for-'+key);
            delete checked_carts['quantity-for-'+key];
        }

        inputs_init.forEach(function(item) {
            checked_carts[item.getAttribute('id')] = item;
        });
        all_cart_check.addEventListener("change", function() {
            if(this.checked) {
                for(let i = 0 ; i < carts.length ; i++) {
                    carts[i].checked = true;
                }
                btn_submit.disabled = false;
                btn_update_keranjang.disabled = false;
            } else {
                for(let i = 0 ; i < carts.length ; i++) {
                    carts[i].checked = false;
                }
                btn_submit.disabled = true;
                btn_update_keranjang.disabled = true;
            }
        });
        carts.forEach(function(item) {
            item.addEventListener("change", function(e) {
                function currentStateChange() {
                    var checked_count = 0
                    carts.forEach(function(iteme) {
                        if(iteme.checked) {
                            checked_count+=1
                        }
                    });
                    if(checked_count == carts.length) {
                        all_cart_check.checked = true;
                        btn_submit.disabled = false;
                        btn_update_keranjang.disabled = false;
                    } else if(checked_count > 0) {
                        btn_submit.disabled = false;
                        btn_update_keranjang.disabled = false;
                    } else {
                        btn_submit.disabled = true;
                        btn_update_keranjang.disabled = true;
                    }
                }
                if(!this.checked) {
                    all_cart_check.checked = false;
                    currentStateChange();
                    remove_checked_cart(e.target.dataset.produk);
                } else {
                    currentStateChange();
                    add_checked_cart(e.target.dataset.produk);
                }   
            });
        });

        var button_remove_quantity = document.querySelectorAll('.removeQuantity');
        var button_add_quantity = document.querySelectorAll('.addQuantity');
        var quantity = document.querySelectorAll('.quantity');

        function disableBtn(element) {
            element.disabled = true;
        }
        function enableBtn(element) {
            element.disabled = false;
        }

        function check(e, min, max, current) {
            let o = e.target.value;
            let n = e.data;
            if(/^(0)(0)+$/.test(o)) {
                e.target.value = "0";
            } else if(/^(100)\d+/.test(o)) {
                e.target.value = o.slice(0,3);  
            } else if(parseInt(o) > max) {
                e.target.value = max;
            }
        };

        function isInt(value) {
            return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
        }

        quantity.forEach(function(item, index) {
            item.addEventListener("input", function(e) {
                var stok = item.dataset.stok;
                check(e, 0, stok, item.value)
            }, false);
        });
        button_add_quantity.forEach(function(item, index) {
            item.addEventListener("click", function() {
                var id_produk = this.dataset.produk;
                var stok = this.dataset.stok;
                var target = document.getElementById('quantity-for-'+id_produk);
                if(!isInt(target.value)) {
                    target.value = 1;
                }
                if(parseInt(target.value) >= stok) {
                    return;
                }
                target.value=parseInt(target.value)+1;
            });
        });
        button_remove_quantity.forEach(function(item, index) {
            item.addEventListener("click", function() {
                var id_produk = this.dataset.produk;
                var target = document.getElementById('quantity-for-'+id_produk);
                if(!isInt(target.value)) {
                    target.value = 1
                }
                if(parseInt(target.value) > 1) {
                    target.value=parseInt(target.value)-1;
                } else {
                    return;
                }
            });
        });
        
        btn_update_keranjang.addEventListener('click', function() {
            var form_keranjang = document.createElement("form");
            form_keranjang.style.display = 'none';
            form_keranjang.setAttribute('method', 'post');
            form_keranjang.setAttribute('action', '{{ route("update-cart") }}');
            content_wrapper.appendChild(form_keranjang);
            
            var inputs_keranjang = checked_carts;
            var input_token = document.createElement("input");
            input_token.setAttribute('type', 'hidden');
            input_token.setAttribute('name', '_token');
            input_token.setAttribute('value', '{{ csrf_token() }}');
            
            var inputs_keranjang_to_array = Object.values(inputs_keranjang);
            inputs_keranjang_to_array.map(function(item) {
                var input_val = item.cloneNode();
                input_val.removeAttribute('id');
                input_val.setAttribute('name', 'kuantitas_'+input_val.dataset.produk);
                form_keranjang.appendChild(input_val);    
            });
            form_keranjang.appendChild(input_token);
            form_keranjang.submit();
        });

        btn_submit.addEventListener('click', function() {
            var form_keranjang = document.createElement("form");
            var inputs_keranjang = checked_carts;
            var input_token = document.createElement("input");
            form_keranjang.style.display = 'none';
            form_keranjang.setAttribute('method', 'post');
            form_keranjang.setAttribute('action', '{{ route("order.proses.checkdata") }}');
            content_wrapper.appendChild(form_keranjang);
            input_token.setAttribute('type', 'hidden');
            input_token.setAttribute('name', '_token');
            input_token.setAttribute('value', '{{ csrf_token() }}');
            form_keranjang.appendChild(input_token);
            Object.keys(checked_carts).map(function(item) {
                var input_val = item.replace('quantity-for-', ''); 
                var input_selected_keranjang = document.createElement("input");
                input_selected_keranjang.setAttribute('type', 'text');
                input_selected_keranjang.setAttribute('name', 'produk[]');
                input_selected_keranjang.setAttribute('value', input_val);
                form_keranjang.appendChild(input_selected_keranjang);
            });
            form_keranjang.submit();
        });

        
    });
</script>
@endsection

@section('content-body')
<div class="mt-5 mb-5" style="min-height:600px;" id="content-wrapper">
    <div class="container px-0">
        <!-- <div class="az-content-label mg-b-10">Keranjang</div> -->
        <div class="d-flex">
            <div class="flex-grow-1">
                <ul class="list-group">
                    <li class="list-group-item" style="min-height: 500px;">
                        <div class="d-flex align-items-center justify-content-between mg-b-30">
                            <h6 class="tx-inverse tx-semibold flex-grow-1 mg-t-8 tx-24">Keranjang ({{ sizeof($keranjangs) }})</h6>
                            <div class="d-flex align-items-center">
                                <button 
                                type="button"
                                data-toggle="modal"
                                data-target="#modal-help-funding-fee"
                                class="btn tx-semibold tx-indigo" style="text-decoration: underline;" >Funding Fee rate</button>
                                <span class="tx-semibold">30%</span>
                            </div>
                        </div>
                        <div class="mg-b-20 alert alert-info">
                            <strong>Catatan: </strong> 
                            <br />
                            - Jika update kuantitas barang mohon klik update keranjang agar kuantitas diubah.
                            <br />
                            - Alamat harus diisi!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @if(sizeof($keranjangs) > 0)
                        <div class="form-check w-100 bd-b bd-4 pd-b-10 mg-b-20 bd-gray-100 d-flex align-items-center">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <input class="form-check-input mg-r-10 mg-t-1" type="checkbox" value="0" name="semua_keranjang"
                                    id="semua_keranjang_checkbox" style="width: 20px;height: 20px;" checked="true">
                                    <label class="form-check-label tx-medium tx-gray-500 mg-t-1" for="defaultCheck1">
                                        Pilih Semua
                                    </label>
                                </div>
                                <button class="btn tx-indigo" style="text-decoration: none;" id="btn_update_keranjang">Upgrade Keranjang</button>
                            </div>
                        </div>
                        @else
                        <div class="form-check w-100 bd-b bd-4 pd-b-10 mg-b-20 bd-gray-100 d-flex align-items-center">
                            <label class="form-check-label tx-medium tx-gray-500 mg-t-1" for="defaultCheck1">
                                Keranjang Kosong
                            </label>
                        </div>
                        @endif
                        @forelse($keranjangs as $row)
                        <div class="bd-b bd-4 pd-b-10 bd-gray-100 mg-b-20">
                            <div class="d-flex align-items-start mg-b-10">
                                <div class="image mg-r-10">
                                    <img src="{{ asset('/assets/uploads/produk/'.$row['gambar']) }}" class="img-fluid rounded-10" 
                                    style="width: 80px; height: 80px;" alt="Responsive image">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="tx-24">{{ $row['nama_produk'] }}</div>
                                    <div class="tx-14 tx-semibold">Rp. {{ number_format($row['harga']) }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="form-check mg-r-auto mg-l-0">
                                    <input class="form-check-input mg-r-10 mg-t-1" type="checkbox" name="keranjang[]" value="" data-produk="{{ $row['id_produk'] }}"
                                    id="" style="width: 20px;height: 20px;" checked="true">
                                </div>
                                <div class="d-flex mg-l-auto align-items-center">
                                    <div class="bd-r bd-2 bd-r-gray-500 px-3 tx-gray-500 tx-12">{{ $row['stok'] - $row['ordered_sum_kuantitas'] }} stok tersisa</div>
                                    <div class="px-3 tx-medium @if($row['pivot']['kuantitas'] > ($row['stok'] - $row['ordered_sum_kuantitas'])) tx-danger @endif">Kuantitas</div>
                                    <button class="btn btn-icon removeQuantity" data-produk="{{ $row['id_produk'] }}"><i class="typcn typcn-minus-outline"></i></button>
                                    <input type="text" name="kuantitas[]" data-stok="{{ $row['stok'] - $row['ordered_sum_kuantitas'] }}" data-produk="{{ $row['id_produk'] }}" 
                                    class="bd @if($row['pivot']['kuantitas'] > ($row['stok'] - $row['ordered_sum_kuantitas'])) bd-danger @endif form-control rounded-pill text-center wd-100 quantity" id="quantity-for-{{ $row['id_produk'] }}" data-produk="{{ $row['id_produk'] }}" value="{{ $row['pivot']['kuantitas'] }}" />
                                    <button class="btn btn-icon addQuantity" data-stok="{{ $row['stok'] - $row['ordered_sum_kuantitas'] }}" data-produk="{{ $row['id_produk'] }}"><i class="typcn typcn-plus-outline"></i></button>
                                    <form action="{{ route('delete-singleton-cart', $row['id_produk']) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <div class=""><button class="btn btn-with-icon btn-block tx-danger" type="submit"><i class="typcn typcn-trash"></i> Hapus</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="tx-semibold tx-18 d-flex justify-content-center align-items-center" style="height: 100px;">
                            Opps Keranjang Kosong Silahkan pilih barang di <a href="{{ url('/products') }}" class="tx-indigo mg-l-10">Halaman Produk</a> 
                        </div>
                        @endforelse
                    </li>
                </ul>
            </div>
            <div class="pd-l-10" style="width: 300px;">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center">
                        <div class="w-100">
                            <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Ringkasan Produk</h6>
                            @foreach($keranjangs as $row)
                            <div class="d-flex justify-content-between w-100 mg-b-10">
                                <div class="d-block tx-15">{{ $row['nama_produk'] }} ({{ $row['pivot']['kuantitas'] }})</div>
                                <div class="d-block tx-15">
                                    Rp <span>{{ number_format($row['total']) }}</span>
                                </div>
                            </div>
                            @endforeach
                            <!-- <div class="d-flex justify-content-between w-100 mg-b-10">
                                <div class="d-block tx-15">Total Harga({{ $stat['total_kuantitas'] }})</div>
                                <div class="d-block tx-15">
                                    Rp <span>{{ number_format($stat['total_harga']) }}</span>
                                </div>
                            </div> -->
                        </div>
                    </li>
                    <li class="list-group-item d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Total</h6>
                            <span class="tx-semibold">Rp. {{ number_format($stat['total_harga']) }}</span>
                        </div>
                        @auth
                        <button class="btn btn-indigo btn-block w-100" id="btn_submit" @if(auth()->user()->carts->count() == 0) disabled="true" @endif>Checkout</button>
                        @endauth
                        @guest
                        <div class="w-100 d-flex justify-content-center align-items-center">
                            <p class="tx-medium tx-indigo tx-18 mg-t-10"><a href="{{ url('/auth/login') }}">Masuk</a> Untuk Checkout</p>
                        </div>
                        @endguest
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
