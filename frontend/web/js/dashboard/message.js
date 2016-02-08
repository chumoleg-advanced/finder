$(document).ready(function () {
    function _scrollTopDialogHistory() {
        var obj = $('.dialogHistory');
        obj.scrollTop(1E10);
    }

    $(document).on('click', '.returnBackDialogList, .messageButton', function () {
        var obj = $('#messageModal');
        obj.modal();
        $.post('/ajax/message/get-dialog-list', {}, function (data) {
            obj.find('.modal-body').html(data);
            obj.find('.modal-header h3').text('Диалоги');
        }, 'html');
    });

    $(document).on('click', '.sendMessageFromRequest', function () {
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
        preLoaderShow();

        var params = {dialogId: $(this).data('id'), mainRequestOfferId:  $(this).data('offer-id')};
        $.post('/ajax/message/open-message-dialog', params, function (data) {
            if (!data) {
                preLoaderHide();
                return false;
            }

            obj.find('.modal-header h3').text('Переписка по заявке №' + data.requestId);
            obj.find('.modal-body').html(data.html);

            _scrollTopDialogHistory();
            preLoaderHide();
        }, 'json');
    });
});