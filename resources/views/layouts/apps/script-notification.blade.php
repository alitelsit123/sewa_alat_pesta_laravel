<script>
var btn_notification = document.getElementById('btn-notification');
var notification_is_open = false;
var notifications_types = [
    'App\\Events\\Order'
];
var notification_items = {};
function notificationContent(data) {
    var image = data.image ? '<div class="az-img-user"><img src="'+data.image+'" alt=""></div>': '';
    var link = data.url ? 'onclick="document.location.href=\''+data.url+'\';"': '';
    var content = ''+
        '<div class="media new" '+link+'>'+
            image+
            '<div class="media-body flex-grow-1 notification-mark notification-unread">'+
                '<p>'+data.text+'</p>'+
                '<span>'+data.created_at+'</span>'+
            '</div>'+
            '<div class="">'+
                '<i class="notification-mark notification-unread">&bull;</i>'+
            '</div>'+
        '</div>'+
    '';
    return content;
}

function bindNotificationChannel() {
    notification_channel = pusher.subscribe('private-notification.'+current_user.id_user);
    notification_channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
        if(data) {
            $('#btn-notification').addClass('new');
            $('#notification-list').prepend(notificationContent(data));
        }
    });
}

function activateNotificationUserSession() {
    bindNotificationChannel();
}

function toggleOpenNotification() {
    notification_is_open = !notification_is_open
}

btn_notification.addEventListener('click', function() {
    toggleOpenNotification();
    if(notification_is_open) {
        $.ajax({
            url: '{{ route('notification.markread') }}',
            type: 'get',
            success:function(data) {
                return;
            }
        });
    } else {
        $('#btn-notification').removeClass('new');
        $('.notification-mark').removeClass('notification-unread');
        $('.notification-mark').addClass('notification-read');
    }
});
</script>