$(document).ready(function () {
    function _scrollTopDialogHistory() {
        var obj = $('.dialogHistory');
        obj.scrollTop(1E10);
    }

    function _updateCounterNewMessage(data) {
        if (data.countNewMessages == 0) {
            $('.messageBadgeMenu').text('');
        } else {
            $('.messageBadgeMenu').text(data.countNewMessages);
        }
    }

    $(document).on('click', '.returnBackDialogList, .messageButton', function () {
        var obj = $('#messageModal');
        obj.modal();
        $.post('/ajax/message/index', {}, function (data) {
            obj.find('.modal-body').html(data);
            obj.find('.modal-header h4').text('Оповещения');
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
            obj.find('.modal-header h4').text('Переписка с ' + data.companyName);
            _scrollTopDialogHistory();
            _updateCounterNewMessage(data);
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

        var params = {dialogId: $(this).data('id'), mainRequestOfferId: $(this).data('main-offer')};
        $.post('/ajax/message/open-message-dialog', params, function (data) {
            if (!data) {
                preLoaderHide();
                return false;
            }

            obj.find('.modal-header h4').text('Переписка по заявке №' + data.requestId);
            obj.find('.modal-body').html(data.html);
            _scrollTopDialogHistory();
            _updateCounterNewMessage(data);
            preLoaderHide();
        }, 'json');
    });
});