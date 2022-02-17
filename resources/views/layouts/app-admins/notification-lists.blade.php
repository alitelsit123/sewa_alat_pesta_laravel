<div class="modal fade" id="{{ $modal_id }}">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ $title_modal }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="max-height: 80vh;overflow-y: auto;" id="{{ $modal_id.'-content' }}">
            @forelse($items as $row)
            <div class="p-3">
                <a href="{{ route('admin.order.show', $row->data['kode_pesanan']) }}">{{ $row->data['text'] }}</a> pada {{ $row->created_at }}
            </div>
            <div class="dropdown-divider"></div>
            @empty
            <div class="p-3">
                <div class="alert alert-info">
                    <strong>!</strong> Tidak ada notifikasi baru.
                </div>
            </div>
            @endforelse
        </div>
    </div>
  </div>
</div>