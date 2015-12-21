$(document).ready(function () {
    var myMap = null;

    function initMap(coords, zoom, redraw) {
        if (redraw) {
            myCollection.removeAll();
        } else {
            myMap = new ymaps.Map('yandexMap', {
                center: coords,
                zoom: zoom,
                controls: ['zoomControl']
            });
        }

        var myPlacemark = new ymaps.Placemark(coords);
        myCollection = new ymaps.GeoObjectCollection();
        myCollection.add(myPlacemark);

        myMap.geoObjects.add(myCollection);
        myMap.setCenter(coords, zoom);
    }

    $('.loginButton').click(function () {
        $('#loginForm').modal();
    });

    $('.signUpButton').click(function () {
        $('#signUpForm').modal();
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
            if (myMap == null) {
                initMap([55.0302, 82.9204], 14);
            }

            var destination = $(this).offset().top - 60;
            $('html, body').animate({scrollTop: destination}, 500);
            $('.deliveryAddress').focus();
        }
    });

    $(".deliveryAddress").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: '/ajax/search/address-list',
                dataType: 'json',
                data: {q: request.term},
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.text,
                            value: item.text,
                            point: item.point
                        };
                    }));
                }
            });
        },
        select: function (a, b) {
            try {
                initMap(b.item.point, 17, true);
            } catch (e) {
            }
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
        $(this).find('button').prop('disabled', true);
    });
});