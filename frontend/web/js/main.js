$(document).ready(function () {
    $('.loginButton').click(function () {
        $('#loginForm').modal();
    });

    $('.showAdditionOptions').click(function () {
        $('.additionOptions').toggle();
    });

    $('.showDistrictSelect').change(function () {
        $('.districtSelect').toggle();
    });

    $('.showDeliveryAddress').change(function () {
        var obj = $('.deliveryAddressBlock');
        obj.toggle();

        if (obj.is(':visible')) {
            ymaps.ready(initMap([55.0302, 82.9204]));
        }
    });

    $(document).on('click', '.showFileUpload', function () {
        $(this).closest('.dynamicFormRow').find('.uploadFilesBlock').toggle();
    });

    $(document).on('change', '.buttonListPartsCondition', function () {
        var obj = $(this).closest('.dynamicFormRow').find('.partsOriginal');
        var value = $(this).find('.active input[value="1"]');
        if (value.length) {
            obj.show();
        } else {
            obj.hide();
        }
    });

    $(document).on('change', '.buttonListTireType', function () {
        var obj = $('.tireTypeWinterParams');
        var value = $(this).find('.active input[value="2"]');
        if (value.length) {
            obj.show();
        } else {
            obj.hide();
        }
    });

    $(document).on('beforeSubmit', 'form#login-form', function () {
        var errorDiv = $('.error-summary');
        errorDiv.hide();

        var form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response == 1) {
                    $('button.close').trigger('click');
                    window.location.reload();

                } else {
                    $('.error-summary ul').html('<li>Incorrect username or password.</li>');
                    errorDiv.show();
                }
            }
        });

        return false;
    });
});

function initMap(coords, redraw) {
    if (redraw) {
        myCollection.removeAll();
    } else {
        myMap = new ymaps.Map('yandexMap', {
            center: coords,
            zoom: 10,
            controls: ['zoomControl']
        });
    }

    var myPlacemark = new ymaps.Placemark(coords);
    myCollection = new ymaps.GeoObjectCollection();
    myCollection.add(myPlacemark);

    myMap.geoObjects.add(myCollection);
    myMap.setCenter(coords, 10);
}