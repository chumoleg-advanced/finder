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
    if ($('#yandexMapCompany').length > 0) {
        initMainOfferMap();
    }

    if ($('#yandexMapRequest').length > 0) {
        initMainRequestMap();
    }

    $(document).on('click', '.viewMainOfferInfo', function () {
        $(this).closest('.rowOffer').find('.mainOfferInfoBlock').toggle();
    });

    $(document).on('click', '.requestInfoView', function () {
        $('.requestInfo').toggle();
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

    function initMainOfferMap() {
        var coordinates = $('.addressCoordinates').val();
        if (coordinates) {
            coordinates = coordinates.split(',');
            initMap(coordinates, 17, false, 'yandexMapCompany');
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
        openEffect: 'elastic',
        closeEffect: 'elastic'
    });

    $(".requestOfferDynamicForm").on("beforeInsert", function (e, item) {
        preLoaderShow();
    });

    $(".requestOfferDynamicForm").on("afterInsert", function (e, item) {
        $('input[type=checkbox], input[type=radio]').val(function (i, val) {
            return $(this).data('value');
        });

        $('.requestOfferDynamicForm .dynamicFormRow:last').find('.imagesPreview').html('').hide();

        var form = $('#request-form');
        var index = $('.requestOfferDynamicForm .dynamicFormRow').length - 1;
        console.log(index);

        addInputForValidation(form, index, 'partsCondition');
        addInputForValidation(form, index, 'partsOriginal');
        addInputForValidation(form, index, 'availability');

        preLoaderHide();
    });
});