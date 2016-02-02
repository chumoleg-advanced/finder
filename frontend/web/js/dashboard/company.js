$(document).ready(function () {
    function _checkInputMask(type, obj) {
        if (type == 1) {
            obj.inputmask('+7 (999) 999-9999');
        } else if (type == 3) {
            obj.inputmask('email');
        } else if (type == 4) {
            obj.inputmask('url');
        } else {
            obj.inputmask('remove');
        }
    }

    $.each($('.maskedInput'), function () {
        var type = $(this).closest('div.row.item').find('select').val();
        var obj = $(this);
        _checkInputMask(type, obj);
    });

    $(document).on('change', '.typeContactData', function () {
        var type = $(this).val();
        var obj = $(this).closest('div.row.item').find('.maskedInput');
        _checkInputMask(type, obj);
    });

    $('.companyContactDataDynamic').on('afterInsert', function (e, item) {
        var type = $('.typeContactData:last').val();
        var obj = $('.maskedInput:last');
        _checkInputMask(type, obj);
    });
});