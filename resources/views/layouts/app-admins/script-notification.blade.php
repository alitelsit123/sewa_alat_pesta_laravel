<script>

function htmlContent(data) {
    return ''+
        '<div class="p-3">'+
                '<div class="alert alert-info">'+
                '<a href="'+app_url+'/admin/order/v/'+data.kode_pesanan+'">'+data.text+'</a>' + ' pada ' + data.created_at
                '</div>'+
        '</div>'+
    '';
}

function notificationContent(data) {
    $('#'+data.type+'-content').prepend();
}
function increaseNotificationCount(data) {
    var unread_notification_count = $('#notification-badge').text();
    $('#notification-badge').text(parseInt(unread_notification_count)+1);
    if(data.type == 'App\\Notifications\\Admin\\NewOrderCreatedNotification') {
        var unread_notification_neworder_count = $('#notification-neworder').text();
        $('#notification-neworder').text(parseInt(unread_notification_neworder_count) + 1);
        $('#notification-neworder-time').text(timeConverter(data.created_at));
    } else if(data.type == 'App\\Notifications\\Admin\\UserPaymentSuccessNotification') {
        var unread_notification_payment_count = $('#notification-payment').text();
        $('#notification-payment').text(parseInt(unread_notification_payment_count) + 1);
        $('#notification-payment-time').text(timeConverter(data.created_at));
    }

}

function subscribeToNotificationSocket() {
    notification_channel = pusher.subscribe('private-notification.'+current_user.id_user);
    notification_channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
        increaseNotificationCount(data);
    });
}

function activateNotificationSession() {
    subscribeToNotificationSocket();
    handleLoading();
}    
</script>