 @extends('layouts.app-admin')
@section('css_head')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/toastr/toastr.min.css') }}">
@endsection

@section('script_body')
<!-- Toastr -->
<script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
    @if (session('notes') && (!in_array('type', session('notes')) || session('notes')['type'] == 'success') )
    window.addEventListener('load', function() {
        toastr.success('{{ session("notes")["text"] ?? "success" }}');
    });
    @elseif (session('notes') && (session('notes')['type'] == 'error'))
    window.addEventListener('load', function() {
        toastr.error('{{ session("notes")["text"] ?? "success" }}');
    });
    @else

    @endif
    var selected_data_id = -1;
    function hapusData() {
      $('#confirm-box').modal('hide');
      $('#form-delete').attr('action', "{{ url('/admin/kategori') }}/"+selected_data_id);
      $('#form-delete').submit();
      selected_data_id = -1;
    }
    function openModal(key) {
      selected_data_id = key
      $('#confirm-box').modal();
    }
    $(document).ready(function() {
		var result_list = $('#search-result-list').children();
		var item_sorted = [];
		// $.each(list, function() {
		// 	item_sorted.push(this);
		// });
		// // console.log(item_sorted);
		// list.sort(function(item1, item2) {
		// 	return $(item1).data('created').localeCompare($(item2).data('created'));
		// });
		result_list.detach().sort(function(e, o) {
			var astts = $(e).data('created');
	        var bstts = $(o).data('created');
	        return astts.localeCompare(bstts);
		}).appendTo('#search-result-list');
		// $('#search-result-list').empty();
		// $.each(item_sorted, function() {
		// 	$('#search-result-list').append(this);
		// });
    });

</script>

<!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
                </button> -->
@endsection
@section('content-body')
<div class="container-fluid">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="card" style="min-height: 500px;">
              <div class="card-header">
                    <h2>Pencarian</h2>
                    
              </div>
              <div class="card-header">
              	<!-- SidebarSearch Form -->
			    <form action="{{ route('admin.search.index') }}" method="get" class="form-inline">
			    	<input type="hidden" name="s" value="{{ request()->s }}">
			      	<div class="input-group">
			      		<div class="form-check form-check-inline">
						  <input class="form-check-input" name="filter_types[]" type="checkbox" id="inlineCheckbox1" value="categories" @if(in_array('categories', $checked_filter_types)) checked="true" @endif>
						  <label class="form-check-label" for="inlineCheckbox1">Category</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" name="filter_types[]" type="checkbox" id="inlineCheckbox2" value="products" @if(in_array('products',$checked_filter_types)) checked="true" @endif>
						  <label class="form-check-label" for="inlineCheckbox2">Produk</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" name="filter_types[]" type="checkbox" id="inlineCheckbox2" value="orders" @if(in_array('orders', $checked_filter_types)) checked="true" @endif>
						  <label class="form-check-label" for="inlineCheckbox2">Pesanan</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" name="filter_types[]" type="checkbox" id="inlineCheckbox2" value="payments" @if(in_array('payments', $checked_filter_types)) checked="true" @endif>
						  <label class="form-check-label" for="inlineCheckbox2">Transaksi</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" name="filter_types[]" type="checkbox" id="inlineCheckbox2" value="users" @if(in_array('users', $checked_filter_types)) checked="true" @endif>
						  <label class="form-check-label" for="inlineCheckbox2">Pengguna</label>
						</div>
			      	</div>
			      	<button type="submit" class="btn btn-sm btn-primary">Filter</button>
			    </form>
              </div>
              <!-- /.card-header -->
              <div class="card-header w-100">
                    <h5>Cari "<strong>{{ request()->s }}</strong>"</h5>
                    <h6>Total Hasil "<strong>{{ $total }}</strong>"</h6>
              </div>
              <div class="card-body p-0">
                <ul class="list-group" id="search-result-list">
                	@foreach($categories as $row)
				  	<li class="list-group-item d-flex align-items-center justify-content-between" data-created="{{ $row->created_at }}">
				  		<span class="mr-1 font-weight-semibold">{{ $row->nama_kategori }}</span>
				  		<span class="badge badge-secondary mr-1">Category</span>
				  	</li>
				  	@endforeach
				  	@foreach($products as $row)
				  	<li class="list-group-item d-flex align-items-center justify-content-between" data-created="{{ $row->created_at }}">
						<div class="d-flex align-items-center">
							<img class="mr-1" src="{{ asset('/assets/uploads/produk').'/'.$row->gambar }}" height="40px" width="40px">
				  			<span class="mr-1">{{ $row->nama_produk }} {{ $row->keterangan_pendek }}</span>
						</div>
				  		<span class="mr-1">
						  <a href="{{ route('admin.produk.edit', $row->id_produk) }}" class="btn btn-sm btn-warning">Edit</a>
						  <badge class="badge badge-secondary">Produk</badge>
						</span>
				  	</li>
				  	@endforeach
				  	@foreach($payments as $row)
				  	<li class="list-group-item d-flex align-items-center justify-content-between" data-created="{{ $row->created_at }}">
				  		<span class="mr-1">Pembayaran {{ $row->kode_pembayaran }} oleh {{ $row->order->user->profile->nama }}</span>
			  			<span class="badge badge-secondary mr-1">Transaksi</span>
				  	</li>
				  	@endforeach
				  	@foreach($users as $row)
				  	<li class="list-group-item d-flex align-items-center justify-content-between" data-created="{{ $row->created_at }}">
				  		<span class="mr-1">{{ $row->profile->nama }} </span>
				  		<span class="mr-2">
						  <a href="{{ route('admin.user.show', $row->id_user) }}" class="btn btn-xs btn-info">Lihat Profil</a>
						  <badge class="badge badge-secondary">Pengguna</badge>
						</span>
				  	</li>
				  	@endforeach
					@foreach($orders as $row)
				  	<li class="list-group-item d-flex align-items-center justify-content-between" data-created="{{ $row->created_at }}">
				  		<span class="mr-1">Pesanan {{ $row->kode_pesanan }}</span>
						<span class="mr-2">
						   <a href="{{ route('admin.order.show', $row->kode_pesanan) }}" class="btn btn-xs btn-info">Lihat Detail</a>
				  		   <badge class="badge badge-secondary">Pesanan</badge>
						</span>
				  	</li>
				  	@endforeach
				</ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div><!-- /.container-fluid -->

<form action="" method="post" id="form-delete" class="d-none">
  @csrf
  <input type="hidden" name="_method" value="DELETE" />
</form>

<div class="modal fade" id="confirm-box">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>Yakin ingin menghapus ?</p>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" onclick="hapusData()">Hapus</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
</script>
@endsection