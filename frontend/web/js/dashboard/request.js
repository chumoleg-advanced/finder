function addInputForValidation(form, index, fieldName) {
    var lowerName = fieldName.toLowerCase();

    var attribute = {
        container: ".field-requestofferform-" + index + "-" + lowerName,
        error: ".help-block",
        id: "requestofferform-" + index + "-" + lowerName,
        input: "#requestofferform-" + index + "-" + lowerName,
        name: "[" + index + "]" + fieldName,
        enableAjaxValidation: true,
        encodeError: true
    };

    form.yiiActiveForm('add', attribute);
}

$(document).ready(function () {
    $('.dynamicFormRow a.deleteItem').hide();

    initMainOfferMap($('.requestOfferBlock[data-counter=1]'));

    if ($('#yandexMapRequest').length > 0) {
        initMainRequestMap();
    }

    $(document).on('click', '.viewMainOfferInfo', function () {
        var obj = $(this).closest('.dynamicFormRowView').find('.mainOfferInfoBlock');
        obj.toggle();

        var text = 'Скрыть предложение';
        if (obj.is(':visible') === false) {
            text = 'Посмотреть предложение';
        } else {
            $('html,body').animate({scrollTop: obj.offset().top - 100}, 'slow');
        }

        $(this).text(text);
        initMainOfferMap(obj);
    });

    $(document).on('click', '.requestInfoView', function () {
        var obj = $('.requestInfo');
        obj.toggle();

        var text = 'Скрыть информацию по заявке';
        if (!obj.is(':visible')) {
            text = 'Показать информацию по заявке';
        }

        $(this).text(text);
    });

    $(document).on('change', '.buttonListAvailability', function () {
        var value = $(this).find('.active input').val();
        var obj = $(this).closest('.dynamicFormRow').find('.deliveryDays');
        if (value == 1) {
            obj.hide();
        } else {
            obj.show();
        }
    });

    $(document).on('change', '.buttonListPartsCondition', function () {
        var value = $(this).find('.active input').val();
        var obj = $(this).closest('.dynamicFormRow').find('.partsOriginalBlock');
        if (value == 1) {
            obj.show();
        } else {
            obj.hide();
        }
    });

    function initMainOfferMap(obj) {
        var coordinates = obj.find('.addressCoordinates').val();
        var yandexMabBlock = obj.find('.yandexMapCompany');
        if (coordinates && yandexMabBlock && yandexMabBlock.find('ymaps').length == 0) {
            coordinates = coordinates.split(',');
            initMap(coordinates, 17, false, yandexMabBlock.attr('id'));
        }
    }

    function initMainRequestMap() {
        var coordinates = $('#addressCoordinatesRequest').val();
        if (coordinates) {
            coordinates = coordinates.split(',');
            initMap(coordinates, 17, false, 'yandexMapRequest');
        }
    }

    $(".fancybox").fancybox({
        helpers: {
            overlay: {
                locked: false
            }
        },
        openEffect: 'fade',
        closeEffect: 'fade'
    });

    function _getAttributesForm() {
        return [
            'description',
            'comment',
            'price',
            'companyId',
            'availability',
            'deliveryDayFrom',
            'deliveryDayTo',
            'partsCondition',
            'partsOriginal',
            'discType',
            'tireType',
            'tireTypeWinter'
        ];
    }

    $(".requestOfferDynamicForm").on("beforeDelete", function (e, item) {
        preLoaderShow();
    });

    $(".requestOfferDynamicForm").on("afterDelete", function (e, item) {
        preLoaderHide();
    });

    $(".requestOfferDynamicForm").on("beforeInsert", function (e, item) {
        preLoaderShow();
    });

    $(".requestOfferDynamicForm").on("afterInsert", function (e, item) {
        var itemObj = $('.requestOfferDynamicForm .dynamicFormRow:last');
        var destination = itemObj.offset().top - 60;
        $('html, body').animate({scrollTop: destination}, 500);

        $('input[type=checkbox], input[type=radio]').val(function (i, val) {
            return $(this).data('value');
        });

        $('label.active').trigger('click');

        itemObj.find('.imagesPreview').html('').hide();

        var form = $('#request-form');
        var index = $('.requestOfferDynamicForm .dynamicFormRow').length - 1;

        itemObj.find('input, select').prop('readonly', false).prop('disabled', false);

        $.each(_getAttributesForm(), function (i, name) {
            addInputForValidation(form, index, name);
        });

        preLoaderHide();
    });
});