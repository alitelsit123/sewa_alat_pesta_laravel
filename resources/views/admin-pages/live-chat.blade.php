@extends('layouts.app-admin')
@section('css_head')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/toastr/toastr.min.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('script_body')
<!-- Toastr -->
<script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script>
    // Summernote
    $('.summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['link']
        ],
        height: 200
    });
    

    @if (session('notes') && (!in_array('type', session('notes')) || session('notes')['type'] == 'success') )
    window.addEventListener('load', function() {
        toastr.success('{{ session("notes")["text"] ?? "Success" }}');
    });
    @elseif (session('notes') && (session('notes')['type'] == 'error'))
    window.addEventListener('load', function() {
        toastr.error('{{ session("notes")["text"] ?? "Error" }}');
    });
    @elseif (session('notes') && (session('notes')['type'] == 'warning'))
    window.addEventListener('load', function() {
        toastr.warning('{{ session("notes")["text"] ?? "!" }}');
    });
    @else 

    @endif
    var selected_data_id = -1;
    var selected_sesi_id = -1;
    function hapusData() {
        $('#confirm-box').modal('hide');
        $('#form-delete').attr('action', "{{ url('/admin/livecommunication/bot') }}/"+selected_data_id+'/destroy');
        $('#form-delete').submit();
        selected_data_id = -1;
    }
    function openModal(key) {
        selected_data_id = key
        $('#confirm-box').modal();
    }

    var pill_pane_active = '#chat-welcome'; 
    $('.nav-pills a').click(function() {
        var pill_pane = $($(this).data('target'));
        var target_sesi_id = $(this).data('target-id');
        if(pill_pane.hasClass('show') || pill_pane.hasClass('active')) {
            return;
        } else {
            $(pill_pane_active).removeClass('show');    
            $(pill_pane_active).removeClass('active');    
        }
        pill_pane.addClass('show active')
        pill_pane_active = $(this).data('target');
        selected_sesi_id = target_sesi_id;
        
        $.post('{{ route('admin.livechat.mark-as-read-chat') }}', {
            '_token': '{{ csrf_token() }}',
            'id_chat_sesi': target_sesi_id
        });
    });
    
    // channel.bind('App\\Events\\Chat', function(data) {
    //     if(data.event == 'chat') {
    //         if(data.is_request == true && data.data.sesi.id_admin == current_user.id_user) {
    //             if(data.data.sesi) {
    //                 @if(sizeof($sesi) > 0) 
    //                 $('.chat-list-request').prepend(insertRequestLists(data.data.sesi));
    //                 @else
    //                 $('.chat-list-request').html(insertRequestLists(data.data.sesi));
    //                 @endif
    //                 $('.tab-content').append(insertContentChat(data.data.sesi));
    //             } else {
    //                 toastr.success('Ada request baru mohon refresh Halaman.');
    //             }
    //         } else {
    //             if(data.data.sesi) {
    //                 let chat_body = $('.chat-body[data-target-id="'+data.data.sesi.id_chat_sesi+'"]');
    //                 if(data.data.sesi.id_admin == current_user.id_user && data.data.sesi.id_user == selected_sesi_id) {
    //                     if(data.data.connection_status == 1 && data.data.connection_info_type == 1) {
    //                         if(data.data.type == 'receive') {
    //                             let e2 = uuidv4();
    //                             chat_body.append(insertLeftChat(data.msg, e2));
    //                         } else if(data.data.type == 'connection_info') {

    //                         }
    //                     }
    //                     scrollBottom(data.data.sesi.id_chat_sesi);
    //                 }
    //             }
    //         }            
    //     }
    // });
</script>

<!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
                </button> -->
@endsection
@section('content-body')
<div class="container-fluid">
    <div class="row">
        
        <!-- list -->
        <div class="col-md-5 tab-container" role="tablist">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chat Bot</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group">
                        @forelse($bots as $row)
                        <li class="list-group-item" style="border-bottom: 0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>{{ $row->chat }}</div>
                                <div class="d-flex align-items-center">
                                    <a href="#bot-chat-update-{{ $row->id_chat_bot }}" class="btn btn-xs btn-secondary mr-2" data-toggle="modal"><i class="typcn typcn-edit"></i> Edit</a>
                                    <button class="btn btn-xs btn-danger" onclick="openModal({{ $row->id_chat_bot }})" type="button">Hapus</button>
                                </div>
                            </div>
                            @include('admin-pages.live-chat.edit-bot', ['bot' => $row])
                        </li>
                        @empty
                        <li class="list-group-item" id="empty-chat-list" style="border-bottom: 0;">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="my-2">Opps tidak ada chat.</div>
                            </div>
                        </li>
                        @endforelse
                        <li class="list-group-item nav-pills">
                            <a class="btn btn-sm btn-primary ml-2" 
                            role="tab" data-target="#chat-bot-add">
                                <i class="typcn typcn-edit"></i> Tambah Chat
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permintaan Chat</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group chat-list-request">
                        @forelse($sesi as $row)
                        <li class="nav-pills user-chat-request" data-target-id="{{ $row->id_chat_sesi }}" style="border-bottom: 0;">
                            <a data-target="#chat-{{ $row->id_chat_sesi }}" data-target-id="{{ $row->id_chat_sesi }}" class="list-group-item" style="cursor: pointer;" 
                            id="btn-open-chat-{{ $row->id_chat_sesi }}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <img src="{{ $row->user->getPhoto() }}" alt="" srcset="" style="width: 20px; height: 20px;" class="mr-1" />
                                        <div>{{ $row->user->profile->nama ?? $row->user->email }}</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="list-group-item" style="border-bottom: 0;">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="my-2">tidak ada permintaan.</div>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.list -->
        <div class="col-md-7">
            <div class="tab-content">
                <div id="chat-welcome" role="tabpanel" class="tab-pane fade show active" >
                    <div class="card" style="height: 500px;">
                        <div class="card-header">
                            <h6 class="font-weight-bold">Halaman Chat</h6>
                        </div>
                    </div>
                </div>
                <!-- CHAT BOT -->
                <div id="chat-bot-add" role="tabpanel" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header">
                            <h6>Tambah Source</h6>
                        </div>
                        <div class="card-body position-relative" style="min-height: 400px;">
                            @include('admin-pages.live-chat.tambah-bot')
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- END CHAT BOT -->
                @include('admin-pages.live-chat.chat-item', ['sesi' => $sesi])
            </div>
        </div>
        <!-- /.list -->
    </div>
</div><!-- /.container-fluid -->

<form action="" method="post" id="form-delete" class="d-none">
  @csrf
  <input type="hidden" name="_method" value="DELETE" />
</form>

<div class="modal fade" id="confirm-box">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h4 class="modal-title">Default Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
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
@endsection