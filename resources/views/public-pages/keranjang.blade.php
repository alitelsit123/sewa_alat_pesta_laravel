@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/plugins/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>
@endsection

@section('js_body')
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('/assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/js/select2.min.js') }}"></script>

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
        var btn_submit = document.getElementById("btn_submit");
        var all_cart_check = document.querySelector("input[name='semua_keranjang']");
        var carts = document.querySelectorAll("input[name='keranjang[]']");
        var checked_carts = [];
        all_cart_check.addEventListener("change", function() {
            if(this.checked) {
                for(let i = 0 ; i < carts.length ; i++) {
                    carts[i].checked = true;
                }
                btn_submit.disabled = false;
            } else {
                for(let i = 0 ; i < carts.length ; i++) {
                    carts[i].checked = false;
                }
                btn_submit.disabled = true;
            }
        });
        carts.forEach(function(item) {
            item.addEventListener("change", function() {
                if(!this.checked) {
                    all_cart_check.checked = false;
                } else {
                    var checked_count = 0
                    carts.forEach(function(item) {
                        if(item.checked) {
                            checked_count+=1
                        }
                    });
                    if(checked_count == carts.length) {
                        all_cart_check.checked = true;
                        btn_submit.disabled = false;
                    } else if(checked_count > 0) {
                        btn_submit.disabled = false;
                    } else {
                        btn_submit.disabled = true;
                    }
                }    
            })
        });
    })
</script>
@endsection

@section('content-body')
<div class="mt-5 mb-5" style="min-height:600px;">
    <div class="container px-0">
        <!-- <div class="az-content-label mg-b-10">Keranjang</div> -->
        <div class="d-flex">
            <div class="flex-grow-1">
                <ul class="list-group">
                    <li class="list-group-item" style="min-height: 500px;">
                        <h6 class="tx-inverse tx-semibold mg-b-30 mg-t-8 tx-24">Keranjang</h6>
                        <div class="form-check w-100 bd-b bd-4 pd-b-10 mg-b-20 bd-gray-100 d-flex align-items-center">
                            <input class="form-check-input mg-r-10 mg-t-1" type="checkbox" value="0" name="semua_keranjang"
                            id="semua_keranjang_checkbox" style="width: 20px;height: 20px;">
                            <label class="form-check-label tx-medium tx-gray-500 mg-t-1" for="defaultCheck1">
                                Pilih Semua
                            </label>
                        </div>
                        @for($i = 0 ; $i < 11 ; $i++)
                        <div class="bd-b bd-4 pd-b-10 bd-gray-100 mg-b-20">
                            <div class="d-flex align-items-start mg-b-10">
                                <div class="image mg-r-10">
                                    <img src="{{ asset('/assets/dist-base/img/faces/face11.jpg') }}" class="img-fluid rounded-10" 
                                    style="width: 80px; height: 80px;" alt="Responsive image">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="tx-16">Judul barang keranjang 1</div>
                                    <div class="tx-14 tx-semibold">Rp. 100000</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="form-check mg-r-auto mg-l-0">
                                    <input class="form-check-input mg-r-10 mg-t-1" type="checkbox" name="keranjang[]" value="" 
                                    id="" style="width: 20px;height: 20px;">
                                </div>
                                <div class="d-flex mg-l-auto align-items-center">
                                    <div class="bd-r bd-2 bd-r-gray-500 px-3 tx-gray-500 tx-12">1000 stok tersisa</div>
                                    <div class=""><button class="btn btn-with-icon btn-block tx-danger"><i class="typcn typcn-trash"></i> Hapus</button></div>
                                    <button class="btn btn-icon"><i class="typcn typcn-minus-outline"></i></button>
                                    <div class="flex-grow-1 mx-2">100</div>
                                    <button class="btn btn-icon"><i class="typcn typcn-plus-outline"></i></button>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </li>
                </ul>
            </div>
            <div class="pd-l-10" style="width: 250px;">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center w-100 mg-b-10">
                                <h6 class="tx-inverse tx-semibold mg-b-10 mg-t-8">Alamat Pengiriman</h6>
                                <button class="btn icon p-0">
                                    <i class="typcn icon typcn-pencil"></i> Edit
                                </button>
                            </div>
                            <div>
                                <p class="tx-medium tx-15 m-0" id="alamat-nama">Moch Reza</p>
                                <p class="tx-13">62895355094422</p>
                                <p>
                                moch reza (warna biru menghadap selatan) Utama
                                jalan bima rumah no 39 rt 02 rw 40 wedomartani sleman[Tokopedia notes: menghadap selatan]
                                Ngemplak, Kab. Sleman, 55584
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center">
                        <div class="w-100">
                            <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Ringkasan Produk</h6>
                            <div class="d-flex justify-content-between w-100 mg-b-10">
                                <div class="d-block tx-15 text-muted">Total Harga (0)</div>
                                <div class="d-block tx-15 text-muted">
                                    Rp <span>0</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Total</h6>
                            Rp <span>-</span>
                        </div>
                        <button class="btn btn-primary btn-block w-100" id="btn_submit" disabled="true">Pembayaran</button>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
</div>
@endsection
