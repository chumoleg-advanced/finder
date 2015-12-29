$(document).ready(function () {
    $(document).on('change', 'input[type=radio][name=categoryId]', function () {
        var value = $(this).val();
        $.pjax({
            url: $('#filter-form').attr('action'),
            container: '#requestGrid',
            data: {'RequestSearch[categoryId]': value}
        });
    });

    $(document).on('change', 'input[type=radio][name=companyId]', function () {
        var value = $(this).val();
        $.pjax({
            url: $('#filter-form').attr('action'),
            container: '#requestGrid',
            data: {'RequestSearch[performer_company_id]': value}
        });
    });

    $(document).on('click', '.viewMainOfferInfo', function () {
        $('.mainOfferInfoBlock').toggle();
    });

    $(document).on('click', '.acceptOffer', function () {
        if (!confirm('Вы уверены, что хотите принять это предложение?')) {
            return false;
        }

        var params = {requestId: $('#requestId').val(), requestOfferId: $(this).data('id')};
        $.post('/ajax/request/accept-offer', params, function (answer) {
            if (answer.status) {
                document.location.href = answer.url;
            } else {
                alert(answer.msg);
                return false;
            }
        }, 'json');
    });
});