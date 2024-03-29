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

<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"> -->

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
  var loading_element = document.getElementById('loading-box');
  setTimeout(function(){
    $.ajaxSetup({
      error: function(data) {
        if(data.responseText) {
          loading_element.innerHTML = data.responseJSON.message;
        } else {
          loading_element.innerHTML = 'Internal server error. Coba beberapa saat lagi.';
        }
        setTimeout(function() {
          document.location.href = '{{ url('/cart') }}';
        }, 100000000);
      }
    });
    $.get("{{ route('order.proses.payment') }}", function(data, status) {
      if(data.msg_error) {
        document.location.href = '{{ url('/cart') }}';
        return;
      } else if(data.snap_token){
        var url_to = 'https://app.sandbox.veritrans.co.id/snap/v2/vtweb/'+data.snap_token;
        document.location.href = url_to;
      }
    });
  });
</script>
@endsection

@section('content-body')
<div class="mt-5 mb-5" style="min-height:600px;">
    <div class="container">
      <div class="d-flex justify-content-center align-items-center flex-column" id="loading-box">
        <h3>Tunggu sebentar. Sedang memproses pesanananmu.</h3>
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
</div>
@endsection

        