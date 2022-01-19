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
@endsection

@section('content-body')
<div class="mt-5 mb-5" style="min-height:600px;">
    <div class="container">
        <div id="wizard1">
            <h3>Personal Information</h3>
            <section>
              <p class="mg-b-0">Try the keyboard navigation by clicking arrow left or right!</p>
            </section>
            <h3>Billing Information</h3>
            <section>
              <p class="mg-b-0">Wonderful transition effects.</p>
            </section>
            <h3>Payment Details</h3>
            <section>
              <p class="mg-b-0">The next and previous buttons help you to navigate through your content.</p>
            </section>
        </div>
    </div>
</div>
@endsection

        