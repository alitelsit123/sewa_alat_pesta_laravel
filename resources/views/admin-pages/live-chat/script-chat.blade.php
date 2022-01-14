<script>
var img_default = 'data:image/png;base64,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';
var chat_history = [];
var current_user = {};
var pusher = new Pusher('{{env("PUSHER_APP_KEY")}}', {
    authEndpoint: '/auth/channels/authorize',
    cluster: '{{env("PUSHER_APP_CLUSTER")}}',
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}'
        }
    }
});
var channels = [];

function insertContentChat(data) {
    var content = ''+
    '<div id="chat-'+data.id_chat_sesi+'" data-target-id="'+data.id_chat_sesi+'" role="tabpanel" class="card tab-pane fade chat-data">'+
        '<div class="card-header">'+
            '<div class="d-flex align-items-center justify-content-between">'+
                '<div class="d-flex flex-grow-1 align-items-center bg-gray-300">'+
                    '<img src="'+(data.user.profile.photo ? '{{ asset('assets/uploads/users') }}/'+data.user.profile.photo: img_default)+'" alt="" srcset="" style="width: 20px; height: 20px;" class="mr-1" />'+
                    '<div>'+(data.user.profile.nama ? data.user.profile.nama:data.user.email )+'</div>'+
                '</div>'+
                '<div class="btn-tools">'+
                    '<button type="button" class="btn btn-xs btn-primary badge btn-connect" data-target-id="'+data.id_chat_sesi+'" data-target-user-photo="data.user.profile.photo">Connect</button>'+
                    '<button class="btn btn-xs btn-secondary badge ml-1 btn-wait"'+ 
                    'data-target-id="'+data.id_chat_sesi+'">Tunggu</button>'+
                    '<button class="btn btn-xs btn-danger badge ml-1 btn-busy"'+
                    'data-target-id="'+data.id_chat_sesi+'">Sibuk</button>'+
                    '<button class="btn btn-xs btn-danger badge ml-1 btn-disconnect" style="display: none;"'+ 
                    'data-target-id="'+data.id_chat_sesi+'">Disconnect</button>'+
                '</div>'+
            '</div>'+
        '</div>'+
        '<div class="card-body p-0 position-relative chat-content" data-target-id="'+data.id_chat_sesi+'" style="min-height: 400px;">'+
            '<div id="chat-body-data.id_chat_sesi" class="chat chat-body px-2 pt-2" style="height: 340px;max-height: 340px!important;overflow-y: auto!important;" data-target-id="'+data.id_chat_sesi+'"></div>'+
            '<div class="d-flex position-absolute w-100 p-2" style="bottom: 0;left: 0;">'+
                '<input type="text" id="" class="form-control rounded-pill flex-grow-1 input-chat" data-target-id="'+data.id_chat_sesi+'" placeholder="Pesan">'+
            '</div>'+
        '</div>'+
    '</div>';
    return content;
}
function insertRequestLists(data) {
    var content = ''+ 
    '<li class="nav-pills user-chat-request" data-target-id="'+data.id_chat_sesi+'" style="border-bottom: 0;">'+
        '<a data-target="#chat-'+data.id_chat_sesi+'" class="list-group-item" style="cursor: pointer;" id="btn-open-chat-'+data.id_chat_sesi+'">'+
            '<div class="d-flex align-items-center justify-content-between">'+
                '<div class="d-flex flex-grow-1 align-items-center">'+
                    '<img src="'+(data.user.profile.photo ? "{{ asset('assets/uploads/users') }}/"+data.user.profile.photo : img_default)+'" alt="" srcset="" style="width: 20px; height: 20px;" class="mr-1" />'+
                    '<div>'+(data.user.profile.nama ? data.user.profile.nama:data.user.email )+'</div>'+
                '</div>'+
            '</div>'+
        '</a>'+
    '</li>';
    return content;
}

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
    $('.btn-wait[data-target-id="'+id+'"]').hide();
    $('.btn-disconnect[data-target-id="'+id+'"]').show();
}
function disconnected(id) {
    $('.chat-data[data-target-id="'+id+'"]').remove();
    $('.user-chat-request[data-target-id="'+id+'"]').remove();
    let i = chat_history.findIndex(function(item) {
        return item.id_chat_sesi == id
    });
    if(i >= 0) {
        chat_history.splice(i, 1);
    }
    if(chat_history.length > 0) {
        $('#empty-chat-list').first().addClass('d-none');
    } else {
        $('#empty-chat-list').first().removeClass('d-none');
    }
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
function bindChatChannel(sesi) {
    channels['channel_'+sesi.id_chat_sesi] = pusher.subscribe('private-chat.'+sesi.id_chat_sesi);
    channels['channel_'+sesi.id_chat_sesi].bind('App\\Events\\Chat', function(data) {
        if(data.data.type == 'user_request') {
            if(data.data.sesi) {
                
            } else {
                toastr.success('Ada request baru mohon refresh Halaman.');
            }
        } else if(data.data.type == 'received' && data.data.receiver == current_user.id_user) {
            let chat_body = $('.chat-body[data-target-id="'+data.data.sesi.id_chat_sesi+'"]');
            let e2 = uuidv4();
            chat_body.append(insertLeftChat(data.msg, e2));     
            scrollBottom(data.data.sesi.id_chat_sesi);
        }
    });
}
function btnActions() {
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

    $('.btn-busy').click(function() {
        let current_el = $(this);
        let element_id = uuidv4();
        let chat_body = $('.chat-body[data-target-id="'+current_el.data('target-id')+'"]');
        $.post('{{ route("admin.livechat.connect-to-user") }}', {
            '_token': '{{ csrf_token() }}',
            'id_sesi': current_el.data('target-id'),
            'rejection_id': uuidv4(),
            'reject': true,
        }, function(data, status) {
            if(data.status == 1) {
                let element_id_2 = uuidv4();
                chat_body.append(insertCenterChat(data.msg, element_id_2));
                setTimeout(function() {
                    disconnected(current_el.data('target-id'));                
                });
                channels['channel_'+data.data.sesi.id_chat_sesi].unbind('App\\Events\\Chat', function() {
                    console.log('chat disconnected');
                }); 
                channels['channel_'+data.data.sesi.id_chat_sesi] = pusher.unsubscribe('private-chat.'+data.data.sesi.id_chat_sesi);
            } 
        });
    });

    $('.btn-wait').click(function() {
        let current_el = $(this);
        let element_id = uuidv4();
        let chat_body = $('.chat-body[data-target-id="'+current_el.data('target-id')+'"]');
        $.post('{{ route("admin.livechat.connect-to-user") }}', {
            '_token': '{{ csrf_token() }}',
            'id_sesi': current_el.data('target-id'),
            'waiting_id': uuidv4(),
            'wait': true,
        }, function(data, status) {
            if(data.status == 1) {
                let element_id_2 = uuidv4();
                chat_body.append(insertCenterChat(data.msg, element_id_2));
                setTimeout(function() {
                    
                }, 2000);
            } 
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
                let element_id_2 = uuidv4();
                chat_body.append(insertCenterChat(data.msg, element_id_2));
                setTimeout(function() {
                    disconnected(current_el.data('target-id'));
                });   
            }
            channels['channel_'+data.data.sesi.id_chat_sesi].unbind('App\\Events\\Chat', function() {
                console.log('chat disconnected');
            }); 
            channels['channel_'+data.data.sesi.id_chat_sesi] = pusher.unsubscribe('private-chat.'+data.data.sesi.id_chat_sesi);
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
}

btnActions();

$(document).ready(function() {
    $.get('{{ route("user.collect") }}', function(data, status) {
        if(data.user) {
            current_user = Object.assign(current_user, {}, data.user);
            channels['channel_chat_request'] = pusher.subscribe('private-chat-request.'+current_user.id_user);
            channels['channel_chat_request'].bind('App\\Events\\Chat', function(datasesi) {
                chat_history.splice(chat_history.length, 0, datasesi.data.sesi);
                $('.chat-list-request').prepend(insertRequestLists(datasesi.data.sesi));
                $('.tab-content').append(insertContentChat(datasesi.data.sesi));
                if(datasesi.data.sesi.status == 1) {
                    $(".chat-content[data-target-id='"+datasesi.data.sesi.id_chat_sesi+"'] *").prop('disabled',true);
                } else {
                    connected(datasesi.data.sesi.id_chat_sesi);
                }
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
                });
                btnActions();
                bindChatChannel(datasesi.data.sesi);
                if(chat_history.length > 0) {
                    $('#empty-chat-list').first().addClass('d-none');
                } else {
                    $('#empty-chat-list').first().removeClass('d-none');
                }
            });
        }
    }); 
    $.get('{{ route("sesi.collect") }}', function(data, status) {
        if(data.sesi.length > 0) {
            chat_history = data.sesi;
        }
    }).done(function() {
        $.each(chat_history, function(index, item) {
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
            if(item.status == 1) {
                $(".chat-content[data-target-id='"+item.id_chat_sesi+"'] *").prop('disabled',true);
            } else {
                connected(item.id_chat_sesi);
            }
            // Bind Channel
            bindChatChannel(item);
        });
    });
});
</script>