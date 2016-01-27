var myMap = null;

function initMap(coords, zoom, redraw, divId) {
    try {
        ymaps.ready(function () {
            if (redraw) {
                myCollection.removeAll();
            } else {
                if (!divId) {
                    divId = 'yandexMap';
                }

                myMap = new ymaps.Map(divId, {
                    center: coords,
                    zoom: zoom,
                    controls: ['zoomControl']
                });
            }

            var myPlaceMark = new ymaps.Placemark(coords);
            myCollection = new ymaps.GeoObjectCollection();
            myCollection.add(myPlaceMark);

            myMap.geoObjects.add(myCollection);
            myMap.setCenter(coords, zoom);
        });
    } catch (e) {
    }
}

$(document).ready(function () {
    $('.loginButton').click(function () {
        $('#loginForm').modal();
    });

    $('.loginIfRegister').click(function () {
        $("#loginForm").modal('hide');
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
            $('.addressCoordinates').val(b.item.point);

            try {
                initMap(b.item.point, 17, true);
            } catch (e) {
            }
        }
    });

    $(document).on('click', '.showFileUpload', function () {
        var rowBlock = $(this).closest('.dynamicFormRow').find('.uploadFilesBlock');
        rowBlock.show();
        rowBlock.find('.help-block').parent().hide();
        rowBlock.find('.btn-file input').trigger('click');
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

    $(document).on('beforeSubmit', 'form#login-form', function (event) {
        preLoaderShow();
        return _checkRequestForm($(this), 'login', $('#loginForm'));
    });

    $(document).on('beforeSubmit', 'form#signup-form', function (event) {
        preLoaderShow();
        return _checkRequestForm($(this), 'signup', $('#signUpForm'));
    });

    function _checkRequestForm(obj, action, modalObj) {
        var data = obj.serialize();

        $.ajax({
            url: '/ajax/auth/' + action,
            dataType: 'json',
            async: false,
            type: "POST",
            method: "POST",
            data: data,
            success: function (answer) {
                if (answer === false) {
                    return false;
                }

                modalObj.modal('hide');

                var form = $('form#request-form');
                if (form.length > 0) {
                    form.submit();
                    preLoaderHide();
                } else {
                    document.location.href = '/';
                }
            }
        });

        preLoaderHide();

        return false;
    }

    $(document).on('beforeSubmit', 'form#request-form', function (event) {
        preLoaderShow();
        var status = false;
        $.ajax({
            url: '/ajax/check/user',
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.status === false) {
                    $('.loginButton').trigger('click');
                } else {
                    event.preventDefault();
                    status = true;
                }
            }
        });

        preLoaderHide();
        return status;
    });
});

function preLoaderShow() {
    var body = $('body');
    var bodyH = $(window).height() / 2 - 90;
    body.css('opacity', 0.6).css('overflow', 'hidden');
    body.append('<div id="preLoader" style="position:fixed;'
        + 'top:0px; left:0px; width:100%; height:100%;'
        + 'z-index:99999999; color:#fff; padding-top:' + bodyH + 'px;"'
        + 'align="center">'
        + '<img src="/img/bigPreLoader.gif"'
        + ' alt="Пожалуйста, подождите..." /></div>');
}

function preLoaderHide() {
    setTimeout(function () {
        var obj = $('body #preLoader');
        obj.fadeOut('slow', function () {
            obj.remove();
            $('body').css('opacity', '').css('overflow', 'auto');
        });
    }, 200);
}