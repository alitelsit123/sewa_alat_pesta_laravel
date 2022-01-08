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
    var chat_history = JSON.parse('{!! $sesi->toJson() !!}');
    var current_user = JSON.parse('{!! auth()->user()->toJson() !!}');
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
        var pill_pane = $($(this).data('target'))
        if(pill_pane.hasClass('show') || pill_pane.hasClass('active')) {
            return;
        } else {
            $(pill_pane_active).removeClass('show');    
            $(pill_pane_active).removeClass('active');    
        }
        pill_pane.addClass('show active')
        pill_pane_active = $(this).data('target');
    });

    function insertRightChat(chat) {
        var content = '<div class="chat-right d-flex justify-content-end align-items-start mb-1">'+
                '<div class="sub-chat-right">'+
                '<div class="py-1 px-2 bg-light rounded-5">'+chat+'</div>'+
                '</div>'+
                '<img src="{{ auth()->user() ? auth()->user()->getPhoto():'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png' }}"'+ 
                'class="rounded-circle ml-1" alt="" style="width: 40px; height: 40px;">'+
            '</div>';
        return content;
    }
    function insertLeftChat(chat, data) {
        var content = '<div class="chat-right d-flex align-items-start mb-1">'+
                '<img src="'+data.photo+'"'+ 
                'class="rounded-circle mr-1" alt="" style="width: 40px; height: 40px;">'+
                '<div class="sub-chat-right">'+
                '<div class="py-1 px-2 bg-indigo tx-white rounded-5">'+chat+'</div>'+
                '</div>'+
            '</div>';
        return content;
    }
    function insertCenterChat(chat, id) {
        var content = '<div class="chat-center w-100 d-flex justify-content-center align-items-center mb-1" id="'+id+'">'+
                '<div class="sub-chat-right">'+
                '<div class="py-1 px-2 bg-gray-300 rounded-5">'+chat+'</div>'+
                '</div>'+
            '</div>';
        return content;
    }
    function connected(id) {
        $('.btn-connect[data-target-id="'+id+'"]').hide();
        $('.btn-busy[data-target-id="'+id+'"]').hide();
        $('.btn-disconnect[data-target-id="'+id+'"]').show();
    }
    function disconnected(id) {
        $('.chat-data[data-target-id="'+id+'"]').remove();
        $('.user-chat-request[data-target-id="'+id+'"]').remove();
        pill_pane_active = '#chat-welcome';
        $(pill_pane_active).addClass('show');    
        $(pill_pane_active).addClass('active');   
        toastr.success('Disconnected');
    }
    function scrollBottom(id) {
        let container = document.getElementById('chat-body-'+id);
        if (container.scrollTop + container.clientHeight <= container.scrollHeight) {
            container.scrollTop = container.scrollHeight;
        }
    }
    function sendChat(url, chat, id_sesi) {
        $.post(url, {
            '_token': '{{ csrf_token() }}',
            'id_sesi': id_sesi,
            'chat': chat,
        }, function(data, status) {
            insertLeftChat(data.msg)
        }).done(function() {
            scrollBottom(id_sesi);
        });
    }
    function uuidv4() {
        return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }
    $('.btn-connect').click(function() {
        let current_el = $(this);
        let element_id = uuidv4();
        let chat_body = $('.chat-body[data-target-id="'+current_el.data('target-id')+'"]');
        chat_body.append(insertCenterChat('Conneting', element_id));
        $.post('{{ route("admin.livechat.connect-to-user") }}', {
            '_token': '{{ csrf_token() }}',
            'id_sesi': current_el.data('target-id')
        }, function(data, status) {
            if(data.status == 1) {
                connected(current_el.data('target-id'));
                let element_id_2 = uuidv4();
                chat_body.append(insertCenterChat(data.msg, element_id_2));
                setTimeout(function() {
                    
                }, 2000);
                $(".chat-content[data-target-id='"+current_el.data('target-id')+"'] *").prop('disabled',false);
                scrollBottom(current_el.data('target-id'));
            } 
        }).done(function() {

        });
    });

    $('.btn-disconnect').click(function() {
        let current_el = $(this);
        let element_id = uuidv4();
        let chat_body = $('.chat-body[data-target-id="'+current_el.data('target-id')+'"]');
        chat_body.append(insertCenterChat('diskonekting', element_id));
        $.post('{{ route("admin.livechat.disconnect-chat") }}', {
            '_token': '{{ csrf_token() }}',
            'id_sesi': current_el.data('target-id'),
        }, function(data, status) {
            if(data.status == 1) {
                disconnected(current_el.data('target-id'));
                let element_id_2 = uuidv4();
                chat_body.append(insertCenterChat(data.msg, element_id_2));
                setTimeout(function() {
                    
                }, 2000);   
            } 
        }).done(function() {

        });
    });
        
    $('.input-chat').keyup(function(e) {
        let current_el = $(this);
        if(e.key == 'Enter') {
            if(e.target.value.length > 0) {
                var v = e.target.value;
                let e2 = uuidv4();
                let chat_body = $('.chat-body[data-target-id="'+current_el.data('target-id')+'"]');
                e.target.value = '';
                chat_body.append(insertRightChat(v, e2));
                sendChat('{{ route("admin.livechat.chat-with-user") }}', v, current_el.data('target-id'));
            }
            scrollBottom(current_el.data('target-id'));
        }
    });

    $(document).ready(function() {
        $.each(chat_history, function(index, item) {
            if(item.status == 1) {
                $(".chat-content[data-target-id='"+item.id_chat_sesi+"'] *").prop('disabled',true);
            } else {
                connected(item.id_chat_sesi);
            }
            $.each(item.chats, function(index2, item2) {
                let chat_body = $('.chat-body[data-target-id="'+item.id_chat_sesi+'"]');
                let e2 = uuidv4();
                if(item2.pengirim == current_user.id_user) {
                    chat_body.append(insertRightChat(item2.chat, e2));
                } else {
                    let photo_url = '{{ asset("assets/uploads/users") }}/' 
                    chat_body.append(insertLeftChat(item2.chat, {photo: photo_url+item.user.profile.photo }));
                }
            });    
        });
    });

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
                        <li class="list-group-item" style="border-bottom: 0;">
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
                    <ul class="list-group">
                        @forelse($sesi as $row)
                        <li class="nav-pills user-chat-request" data-target-id="{{ $row->id_chat_sesi }}" style="border-bottom: 0;">
                            <a data-target="#chat-{{ $row->id_chat_sesi }}" class="list-group-item" style="cursor: pointer;" id="btn-open-chat-{{ $row->id_chat_sesi }}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <img src="{{ $row->user->getPhoto() }}" alt="" srcset="" style="width: 20px; height: 20px;" class="mr-1" />
                                        <div>{{ $row->user->profile->nama ?? $row->user->profile->email }}</div>
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
                <div id="chat-welcome" role="tabpanel" class="tab-pane fade show active">
                    <div class="card">
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