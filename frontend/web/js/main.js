$(document).ready(function () {
    if ($('.carBg').length) {
        $('body').addClass('carBg');  
    };
    if ($('.wheelBg').length) {
        $('body').addClass('wheelBg');  
    };
});

new WOW().init();

var myMap = null;

function initMap(coords, zoom, redraw, divId) {
    try {
        if (!divId) {
            divId = 'yandexMap';
        }

        var divObj = $('#'+divId);
        if (divObj.find('ymaps').length == 0){
            divObj.html('<img src="/img/linePreLoader.gif" class="preLoaderYandexMax"/>');
        }

        ymaps.ready(function () {
            divObj.find('.preLoaderYandexMax').remove();
            if (redraw) {
                myCollection.removeAll();
            } else {
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

// function carSelect() {
//     if (jQuery(window).width() > 767) {
//         $(".carSelect").css({
//             position:'fixed',
//             margin:'0',
//             top:$(".carSelect").offset().top
//         });
//     } else {
//         $(".carSelect").css({
//             position:'relative',
//             margin:'0',
//             top:'0',
//         });
//     }
// }
// $(document).ready(function() {
//    carSelect();
// });
// $(window).resize(function() {
//    carSelect();
// });


$(document).ready(function () {
    $(document).on('click', '.newButton', function () {
        $('.addItemToRequest').trigger('click');
        
        if (jQuery(window).width() > 767) {
            if ($('.dynamicFormRow').length > 1) {
                $('.mainCont').addClass('fix');
            } 
        }
    });
    $(document).on('click', '.delete-item', function () {
        if ($('.dynamicFormRow').length <= 1) {
            $('.mainCont').removeClass('fix');
        }
    });

    $(document).on('click', '.showAdditionOptions', function () {
        $('.mainCont').toggleClass('pt173');
    })

    $(document).on('click', '.loginButton', function () {
        $('#loginForm').modal();
    });

    $(document).on('click', '.loginIfRegister', function () {
        $("#loginForm").modal('hide');
        $('#signUpForm').modal();
    });

    $(document).on('click', '.loginForm', function () {
        $("#signUpForm").modal('hide');
        $('#loginForm').modal();
    });

    $(document).on('change', '.showDistrictSelect', function () {
        $('.districtSelect').toggle();
    });

    $('.showDeliveryAddress').onoff();

    $(document).on('change', '.onoffswitch', function () {
        var obj = $(this).closest('.dynamicFormRow').find('.deliveryAddressBlock');
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

jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function (arg) {
    return function (elem) {
        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

function findByText(text, obj) {
    if (text) {
        $(obj).hide();
        $(obj + ':Contains("' + text + '")').show();
    } else {
        $(obj).show();
    }
}