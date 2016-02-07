$(document).ready(function () {
    function _scrollTopDialogHistory() {
        var obj = $('.dialogHistory');
        setTimeout(function () {
            obj.animate('slow').scrollTop(obj.height() + 400);
        }, 200);
    }

    $(document).on('click', '.returnBackDialogList, .messageButton', function () {
        var obj = $('#messageModal');
        obj.modal();
        $.post('/ajax/message/get-dialog-list', {}, function (data) {
            obj.find('.modal-body').html(data);
        }, 'html');
    });

    $('.sendMessageFromRequest').click(function () {
        var obj = $('#messageModal');
        var params = {
            requestId: $('#requestId').val(),
            requestOfferId: $(this).data('offer')
        };

        preLoaderShow();
        $.post('/ajax/message/open-request-dialog', params, function (data) {
            if (!data.html) {
                return false;
            }

            obj.modal();
            obj.find('.modal-body').html(data.html);
            obj.find('.modal-header h3').text('Диалог с ' + data.companyName);
            _scrollTopDialogHistory();
            preLoaderHide();
        }, 'json');
    });

    $(document).on('click', '#sendMessageButton', function () {
        if (!$('#message-data').val()) {
            return false;
        }

        var obj = $('#messageModal');
        preLoaderShow();
        $.post('/ajax/message/send-message', $('#message-form').serialize(), function (data) {
            $('#message-data').val('');

            obj.find('.dialogHistory').html(data);
            _scrollTopDialogHistory();

            preLoaderHide();
        }, 'html');
    });

    $(document).on('click', '.rowRequestMessage', function () {
        var obj = $('#messageModal');
        obj.modal();
        var requestId = $(this).data('request');
        var toUserId = $(this).data('to-user');
        preLoaderShow();

        $.post('/ajax/message/open-message-dialog', {requestId: requestId, toUserId: toUserId}, function (data) {
            obj.find('.modal-header h3').text('Переписка по заявке №' + requestId);
            obj.find('.modal-body').html(data);

            _scrollTopDialogHistory();
            preLoaderHide();
        }, 'html');
    });
});