$(document).ready(function () {
    $(document).on('change', '.notificationList input[type="checkbox"]', function () {
        preLoaderShow();
        $.post('/ajax/user/manage-notification', {type: $(this).val()}, function () {
            preLoaderHide();
        }, 'json');
    });
});