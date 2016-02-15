$(document).ready(function () {
    setInterval(function () {
        _autoUpdateCurrentCounters();
    }, 10000);

    function _autoUpdateCurrentCounters() {
        $.post('/ajax/message/update-counters', {}, function (data) {
            _updateAllCounters(data);
            if ($('#messageDialogTab').is(':visible')) {
                var searchText = $(this).data('search');
                $.post('/ajax/message/get-dialog-content', {search: searchText}, function (html) {
                    $('#messageDialogTab').html(html);
                    $('.searchText').trigger('keyup');
                }, 'html');

            } else if ($('#messageNotificationTab').is(':visible')) {
                $.post('/ajax/message/get-notification-content', {}, function (html) {
                    $('#messageNotificationTab').html(html);
                }, 'html');
            }
        }, 'json');
    }

    function _scrollTopDialogHistory() {
        var obj = $('.dialogHistory');
        setTimeout(function () {
            obj.scrollTop(1E10);
        }, 100);
    }

    function _updateAllCounters(data) {
        _updateCounterNewMessage(data.countAllNew, '.messageBadgeMenu');
        _updateCounterNewMessage(data.countNewMessages, '.messagesBadge');
        _updateCounterNewMessage(data.countNewNotifications, '.notificationsBadge');
    }

    function _updateCounterNewMessage(count, objClass) {
        if (count == 0) {
            $(objClass).text('');
        } else {
            $(objClass).text(count);
        }
    }

    $(document).on('keyup', '.searchText', function () {
        findByText($(this).val(), '.rowRequestMessage');
    });

    $(document).on('click', '.rowNotification', function () {
        var obj = $(this);
        preLoaderShow();
        $.post('/ajax/message/read-notification', {id: obj.data('id')}, function (data) {
            if (!obj.hasClass('notificationRead')) {
                obj.addClass('notificationRead');
            }

            if (data.location) {
                document.location.href = data.location;
            }

            preLoaderHide();
        }, 'json');
    });

    $(document).on('click', '.returnBackDialogList, .messageButton', function () {
        var obj = $('#messageModal');
        obj.modal();

        var searchText = $(this).data('search');

        $.post('/ajax/message/index', {search: searchText}, function (data) {
            obj.find('.modal-body').html(data);
            obj.find('.modal-header h4').text('Оповещения');
            $('.searchText').trigger('keyup');
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
            _updateAllCounters(data);
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

        var params = {dialogId: $(this).data('id'), mainRequestOfferId: $(this).data('main-offer')};
        $.post('/ajax/message/open-message-dialog', params, function (data) {
            if (!data) {
                preLoaderHide();
                return false;
            }

            obj.find('.modal-header h4').text('Переписка по заявке №' + data.requestId);
            obj.find('.modal-body').html(data.html);
            _updateAllCounters(data);
            _scrollTopDialogHistory();
            preLoaderHide();
        }, 'json');
    });
});