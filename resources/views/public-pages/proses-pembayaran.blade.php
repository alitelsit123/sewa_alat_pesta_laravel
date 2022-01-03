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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">

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
    $.get("{{ route('order.proses.payment') }}", function(data, status) {
      if(status) {
        snap.pay(data['snap_token'], {
            onSuccess: function(result) {
                loading_element.innerHTML = '<h3>Tunggu sebentar. Sedang dialihkan.</h3>';
                document.location.href = "{{ route('profile.show', auth()->user()->email) }}?o=history";
                // loading_element.className += ' ' + 'd-none';
            },
            onPending: function(result) {
                loading_element.innerHTML = '<h3>Tunggu sebentar. Sedang dialihkan.</h3>';
                document.location.href = "{{ route('profile.show', auth()->user()->email) }}?o=history";
                // loading_element.className += ' ' + 'd-none';
            },
            onError: function(result) {
                // console.log(result);
                loading_element.innerHTML = '<h3>Error. '+result['status_message']+'</h3>';
                // document.location.href = "{{ route('profile.show', auth()->user()->email) }}?o=history";
                // loading_element.className += ' ' + 'd-none';
            },
            onClose: function(){
              loading_element.innerHTML = '<h3>Tunggu sebentar. Sedang dialihkan.</h3>';
              document.location.href = "{{ route('profile.show', auth()->user()->email) }}?o=history";
            }
        });
      }

    });
  }, 1000);
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

        