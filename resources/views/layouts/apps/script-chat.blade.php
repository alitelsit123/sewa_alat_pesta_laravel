<script>
var live_chat_active = false;
var box_cs_chat = document.getElementById('cs-chat-box');
var btn_cs_chat = document.getElementById('cs-chat-btn');
var btn_connect_cs = document.getElementById('btn-connect-cs');
var btn_cs_chat_close = document.getElementById('cs-chat-btn-close');
var input_chat = document.querySelector('input[name=input_chat]');
var chat_type = 0;
var opened_chat = 0;
var chat_session = @if(auth()->user()) @if(auth()->user()->sesiChat()) true @else false @endif @else false @endif;
var polling = {
    'chat': null
};
var pusher = new Pusher('{{config("pusher.APP_KEY")}}', {
    authEndpoint: '/auth/channels/authorize',
    cluster: '{{config("pusher.APP_CLUSTER")}}',
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}'
        }
    }
});
var channel = null;

var inp_ch = document.querySelector('input[name="input_chat"]');
var current_sesi = -1;
var chat_history = {};
var current_user = {};
box_cs_chat.style.bottom += 20 + btn_cs_chat.offsetHeight + 10 + 'px';
box_cs_chat.style.display = 'none';

function connectedToCs() {
    btn_connect_cs.style.display = 'none';
    $('#chat-user-name').text('Costumer Service');
    $('#chat-user-photo').attr('src', 'data:image/png;base64,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');

    chat_type = 1;
}
function unConnectedToCs() {
    chat_type = 0;
    btn_connect_cs.style.display = 'block';
    $('#chat-user-name').text('Bot');
    $('#chat-user-photo').attr('src', 'data:image/jpeg;base64,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');
}

function toogleCsChat() {
    live_chat_active = !live_chat_active;
    if(live_chat_active) {
        box_cs_chat.style.display = 'block';
        input_chat.focus();
        if(opened_chat == 0) {
            sendChat('{{ route("chat-with-bot") }}', 'welcome bot', chat_type);
            sendChat('{{ route("chat-with-bot") }}', '/menu', chat_type);
            opened_chat = 1;
        }
    } else {
        box_cs_chat.style.display = 'none';
    }
}
function insertRightChat(chat) {
    var content = '<div class="chat-right d-flex justify-content-end align-items-start mg-b-10">'+
            '<div class="sub-chat-right">'+
              '<div class="pd-y-10 pd-x-15 bg-gray-300 rounded-5">'+chat+'</div>'+
            '</div>'+
            '<img src="{{ auth()->user() ? auth()->user()->profile->getPhoto():'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png' }}"'+ 
            'class="rounded-circle mg-l-10" alt="" style="width: 40px; height: 40px;">'+
          '</div>';
    $('#chat-body').append(content);
}
function insertLeftChat(chat) {
    var content = '<div class="chat-right d-flex align-items-start mg-b-10">'+
            '<img src="data:image/jpeg;base64,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"'+ 
            'class="rounded-circle mg-r-10" alt="" style="width: 40px; height: 40px;">'+
            '<div class="sub-chat-right">'+
              '<div class="pd-y-10 pd-x-15 bg-indigo tx-white rounded-5">'+chat+'</div>'+
            '</div>'+
          '</div>';
    $('#chat-body').append(content);
}
function insertCenterChat(chat, id) {
    var content = '<div class="chat-center w-100 d-flex justify-content-center align-items-center mg-b-10" id="'+id+'">'+
            '<div class="sub-chat-right">'+
              '<div class="pd-y-10 pd-x-15 bg-light rounded-5">'+chat+'</div>'+
            '</div>'+
          '</div>';
    $('#chat-body').append(content);
}
function scrollBottom() {
    let container = document.getElementById('chat-body');
    if (container.scrollTop + container.clientHeight <= container.scrollHeight) {
        container.scrollTop = container.scrollHeight;
    }
}
function uuidv4() {
  return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
  );
}
function bindChatChannel() {
    chat_channel = pusher.subscribe('private-chat.'+chat_history.id_chat_sesi);
    chat_channel.bind('App\\Events\\Chat', function(data) {
        if(data.data.type == 'received' && data.data.receiver == current_user.id_user) {
            let e2 = uuidv4();
            insertLeftChat(data.msg, e2);
        } else if(data.data.type == 'connected') {
            let element_id = uuidv4();
            insertCenterChat(data.msg, element_id);
            connectedToCs();
            console.log('connected');
        } else if(data.data.type == 'disconnected' || data.data.type == 'rejected') {
            chat_channel.unbind('App\\Events\\Chat', function() {
                console.log('chat disconnected');
            });
            chat_channel = pusher.unsubscribe('private-chat.'+chat_history.id_chat_sesi);
            current_sesi = -1;
            for (var key in chat_history) {
                delete chat_history[key];
            }
            unConnectedToCs();
            let element_id = uuidv4();
            insertCenterChat(data.msg, element_id);
        }
        scrollBottom();
    });
}
function sendChat(url, chat, type) {
    if(type == 0) {
        if(/(.*)\/sambungkan_ke_cs(.*)/.test(chat)) {
            btn_connect_cs.click();
        } else {
            $.post(url, {
            '_token': '{{ csrf_token() }}',
            'chat': chat,
            }, function(data, status) {
                insertLeftChat(data.msg)
            }).done(function() {
                scrollBottom();
            });
        }
    } else if(type == 1){
        $.post(url, {
        '_token': '{{ csrf_token() }}',
        'id_sesi': chat_history.id_chat_sesi,
        'chat': chat,
        'user': current_user.id_user
        }, function(data, status) {

        }).done(function() {
            scrollBottom();
        });
    }
}
btn_cs_chat_close.addEventListener('click', function() {
    if(live_chat_active) {
        toogleCsChat();
    }
});
btn_cs_chat.addEventListener('click', function() {
    toogleCsChat();
});
btn_cs_chat.disabled = true;
inp_ch.addEventListener('keyup', function(e) {
    var v = e.target.value;
    if(e.key == 'Enter') {
        if(e.target.value.length > 0) {
            e.target.value = '';
            insertRightChat(v);
            if(chat_type == 0) {
                sendChat('{{ route("chat-with-bot") }}', v, chat_type);
            } else {
                sendChat('{{ route("chat-with-cs") }}', v, chat_type);
            }
        }
    }
    scrollBottom();
});
btn_connect_cs.addEventListener('click', function() {
    let element_id = uuidv4();
    insertCenterChat('Menghubungkan ...', element_id);
    $.post('{{ route("search-online-cs") }}', {
        '_token': '{{ csrf_token() }}',
    }, function(data, status) {
        if(data.sesi) {
            chat_history = Object.assign(chat_history, {}, data.sesi);
            bindChatChannel();
        } else {
            insertCenterChat(data.msg);
        }       
    }).done(function() {
        scrollBottom();
    });
});

@auth
$(document).ready(function() {
    
    
});
@endauth

$.get('{{ route("user.collect") }}', function(data, status) {
    if(data.user) {
        current_user = Object.assign(current_user, {}, data.user);
    } else {

    }
}); 
$.get('{{ route("sesi.collect.user") }}', function(data, status) {
    if(data.sesi) {
        chat_history = Object.assign(chat_history, {}, data.sesi);
        if(data.sesi.status == 1) {
            insertCenterChat('Menyambungkan ke Costumer Service ...');
        } else {
            insertCenterChat('Terhubung');
        }
        if(chat_history.chats){ 
            opened_chat = true;
            current_sesi = chat_history.id_chat_sesi;
            chat_type = 1;
            connectedToCs({sesi: chat_history, status: chat_history.status});
            setTimeout(function() {
                $.each(chat_history.chats, function(index2, item2) {
                    let chat_body = $('#chat-body');
                    let e2 = uuidv4();
                    if(item2.pengirim == current_user.id_user) {
                        insertRightChat(item2.chat, e2)
                    } else {
                        insertLeftChat(item2.chat, e2)
                    }
                });
                btn_cs_chat.disabled = false;
                bindChatChannel();
            });
        } else {
            unConnectedToCs();
        }
    } else {
        btn_cs_chat.disabled = false;
    }
}); 
</script>