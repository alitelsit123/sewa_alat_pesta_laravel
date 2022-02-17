<script>
var chat_history = [];
var newchat_requests = [];
var newchat_lists = [];
var newchat_count = 0;

function insertContentChat(data) {
    var content = ''+
    '<div id="chat-'+data.id_chat_sesi+'" data-target-id="'+data.id_chat_sesi+'" role="tabpanel" class="card tab-pane fade chat-data">'+
        '<div class="card-header">'+
            '<div class="d-flex align-items-center justify-content-between">'+
                '<div class="d-flex flex-grow-1 align-items-center bg-gray-300">'+
                    '<img src="'+(data.user.profile.photo ? '{{ asset('assets/uploads/users') }}/'+data.user.profile.photo: page_data.user_image)+'" alt="" srcset="" style="width: 20px; height: 20px;" class="mr-1" />'+
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
            '<div id="chat-body-'+data.id_chat_sesi+'" class="chat chat-body px-2 pt-2" style="height: 340px;max-height: 340px!important;overflow-y: auto!important;" data-target-id="'+data.id_chat_sesi+'"></div>'+
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
                    '<img src="'+(data.user.profile.photo ? "{{ asset('assets/uploads/users') }}/"+data.user.profile.photo : page_data.user_image)+'" alt="" srcset="" style="width: 20px; height: 20px;" class="mr-1" />'+
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
        insertRightChat(data.msg)
    }).done(function() {
        scrollBottom(id_sesi);
    });
}
function uuidv4() {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}
function handleChatPageSocket(sesi, msg) {
    let chat_body = $('.chat-body[data-target-id="'+sesi.id_chat_sesi+'"]');
    let e2 = uuidv4();
    let photo_uri = (sesi.user.profile.photo ? photo_url+'/'+sesi.user.profile.photo : page_data.user_image);
    chat_body.append(insertLeftChat(msg, {photo: photo_uri}));     
    scrollBottom(sesi.id_chat_sesi);
}

// console.log(Date.UTC());
// console.log(Date.now());

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
                removeRequestedChat(data.data.sesi);
                setMiniChatBadge();
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
                removeRequestedChat(data.data.sesi);
                setMiniChatBadge();
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
                    $('#chat-request-content-'+current_el.data('target-id')).remove();
                });   
            }
            channels['channel_'+data.data.sesi.id_chat_sesi].unbind('App\\Events\\Chat', function() {
                console.log('chat disconnected');
            }); 
            channels['channel_'+data.data.sesi.id_chat_sesi] = pusher.unsubscribe('private-chat.'+data.data.sesi.id_chat_sesi);
            var index_chat = newchat_lists.findIndex(function(item) {
                return item.sesi.id_chat_sesi == data.data.sesi.id_chat_sesi;
            });

            if(index_chat > -1) {
                newchat_lists.splice(index_chat,1);
            }
            handleChatMini();
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

function minichatCount(operator, value = -1) {
    var minichat_count = parseInt($('#minichat-badge').text());
    if(operator == '+' || operator == 'increase') {
        $('#minichat-badge').text(minichat_count+1);    
    } else if(operator == '-' || operator == 'decrease'){
        if(minichat_count > 0) {
            $('#minichat-badge').text(minichat_count-1);
        }
    }
}
function setMiniChatBadge() {
    var minichat_count = newchat_requests.length + newchat_lists.length;
    $('#minichat-badge').text(minichat_count);    
}

function handleRequestedChatPage(datasesi) {
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
}

function emptyListContents(text, key = '') {
    return '<div class="'+key+' w-100"><div class="px-4">'+text+'</div><div class="dropdown-divider my-2"></div>'+
    '</div>';
}

// REQUEST MINICHAT

function removeRequestedChat(sesi) {
    var index_request = newchat_requests.findIndex(function(item) {
        return item.id_chat_sesi == sesi.id_chat_sesi;
    });

    if(index_request > -1) {
        // $('#chat-request-content-'+sesi.id_chat_sesi).remove();
        newchat_requests.splice(index_request,1);

        setTimeout(function() {
            handleRequestedChatMini();
        });
    }
}

function requestedMiniChatContent(sesi) {
    var chat_url = '{{ route('admin.livechat.index') }}';
    var user_name = sesi.user.profile.nama;
    var user_photo = photo_url+'/'+sesi.user.profile.photo;
    return ''+
        '<div id="chat-request-content-'+sesi.id_chat_sesi+'">'+
            '<div class="dropdown-divider my-2"></div>'+
            '<a href="'+chat_url+'?s='+sesi.id_chat_sesi+'" class="dropdown-item">'+
                '<div class="media">'+
                    '<img src="'+user_photo+'" alt="User Avatar" class="mr-3 img-circle" width="40px" height="40px">'+
                    '<div class="media-body">'+
                    '<h3 class="dropdown-item-title">'+
                        user_name+
                    '</h3>'+
                    '<p class="text-sm">'+
                        '<span type="button" class="badge badge-primary">Connect</span>'+
                    '</p>'+
                    '</div>'+
                '</div>'+
            '</a>'+
        '</div>'+
    '';
}

function handleRequestedChatMini() {
    var showed_list = newchat_requests.slice(0,4);
    $('#minichat-request').empty();

    if(newchat_requests.length > 0) {
        $.each(showed_list, function(index, item) {
            $('#minichat-request').append(requestedMiniChatContent(item));
        });
        if(newchat_requests.length > 4) {
            var rest_list = newchat_requests.slice(4, newchat_requests.length);
            $('#minichat-request').append(emptyListContents('+' + rest_list.length + ' Request'));
        }
    } else {
        $('#minichat-request').prepend(emptyListContents('Tidak ada chat baru'));
    }
    setMiniChatBadge();
}

function subscribeRequestedChatSocket() {
    channels['channel_chat_request'] = pusher.subscribe('private-chat-request.'+current_user.id_user);
    channels['channel_chat_request'].bind('App\\Events\\Chat', function(datasesi) {
        @if(request()->segment(2) == 'livecommunication')
        handleRequestedChatPage(datasesi);
        @endif
        newchat_requests.unshift(datasesi.data.sesi);
        handleRequestedChatMini();
    });
}

// MINICHAT

function bindChatChannel(sesi) {
    channels['channel_'+sesi.id_chat_sesi] = pusher.subscribe('private-chat.'+sesi.id_chat_sesi);
    channels['channel_'+sesi.id_chat_sesi].bind('App\\Events\\Chat', function(data) {
        if(data.data.type == 'user_request') {
            if(data.data.sesi) {
                
            } else {
                toastr.success('Ada request baru mohon refresh Halaman.');
            }
        } else if(data.data.type == 'received' && data.data.receiver == current_user.id_user) {
            @if(request()->segment(2) == 'livecommunication')
            handleChatPageSocket(data.data.sesi, data.msg);
            @endif
            var chat_item = {
                'msg': data.msg,
                'created_at': data.timestamp
            };
            chat_item['sesi'] = data.data.sesi;

            var index_chat = newchat_lists.findIndex(function(item) {
                return item.sesi.id_chat_sesi == data.data.sesi.id_chat_sesi;
            });

            if(index_chat > -1) {
                newchat_lists.splice(index_chat,1,chat_item);
            } else {
                newchat_lists.push(chat_item);
            }
            handleChatMini();
        }
    });
}

function miniChatContent(chat) {
    var chat_url = '{{ route('admin.livechat.index') }}';
    var user_name = chat.sesi.user.profile.nama;
    var user_photo = chat.sesi.user.profile.photo ? photo_url+'/'+chat.sesi.user.profile.photo: img_default;
    return ''+
        '<div id="chat-request-content-'+chat.sesi.id_chat_sesi+'">'+
            '<div class="dropdown-divider my-2"></div>'+
            '<a href="'+chat_url+'?c='+chat.sesi.id_chat_sesi+'" class="dropdown-item" style="background-color: rgba(0,0,0,0.1);">'+
                '<div class="media">'+
                    '<img src="'+user_photo+'" class="mr-3 img-circle" width="40px" height="40px">'+
                    '<div class="media-body">'+
                    '<h3 class="dropdown-item-title">'+
                        user_name+
                    '</h3>'+
                    '<p class="text-sm">'+chat.msg+'</p>'+
                    '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+timeConverter(chat.created_at)+'</p>'+
                    '</div>'+
                '</div>'+
            '</a>'+
        '</div>'+
    '';
}

function handleChatMini() {
    var showed_list = newchat_lists.slice(0,4);
    $('#minichat-list').empty();
    if(newchat_lists.length > 0) {
        $.each(showed_list, function(index, item) {
            $('#minichat-list').prepend(miniChatContent(item));        
        });
        if(newchat_lists.length > 4) {
            var rest_list = newchat_lists.slice(4, newchat_lists.length);
            $('#minichat-request').append(emptyListContents('+' + rest_list.length + ' Chat Baru'));
        }
    } else {
        $('#minichat-list').append(emptyListContents('Tidak ada chat baru'));
    }
    setMiniChatBadge();
}
function subscribeChatSocket() {
    var last_newchat = [];
    $.each(chat_history, function(index, item) {
        $.each(item.chats, function(index2, item2) {
            let chat_body = $('.chat-body[data-target-id="'+item.id_chat_sesi+'"]');
            let e2 = uuidv4();
            if(item2.pengirim == current_user.id_user) {
                chat_body.append(insertRightChat(item2.chat, e2));
            } else {
                let photo_url = '{{ asset("assets/uploads/users") }}/';
                chat_body.append(insertLeftChat(item2.chat, {photo: (item.user.profile.photo ? photo_url+item.user.profile.photo: page_data.user_image) }));
            }
        });
        if(item.status == 1) {
            $(".chat-content[data-target-id='"+item.id_chat_sesi+"'] *").prop('disabled',true);
        } else {
            connected(item.id_chat_sesi);
        }
        // Bind Channel
        bindChatChannel(item);

        // Request Lists
        if(item.status == '1') {
            newchat_requests.unshift(item);
        }

        // Recent Chat List
        if(item.chats[item.chats.length-1]?.pengirim == item.id_user && !item.chats[item.chats.length-1]?.read_at) {
            var chat_item = {
                'msg': item.chats[item.chats.length-1].chat,
                'created_at': item.chats[item.chats.length-1].created_at
            };
            chat_item['sesi'] = item;
            last_newchat.push(chat_item);
        }
    });
    last_newchat.sort(function(a,b) {
        return a.created_at.localeCompare(b.created_at);
    });

    newchat_lists = last_newchat;
    
    handleChatMini();
    handleRequestedChatMini();
}

function activateChatSession() {
    $.get('{{ route("sesi.collect") }}', function(data, status) {
        if(data.sesi.length > 0) {
            chat_history = data.sesi;
            subscribeRequestedChatSocket();
            subscribeChatSocket()
        }
    }).done(function() {

    });
    handleLoading();
}
</script>