$(document).ready(function () {
    if ($('.carBg').length) {
        $('body').addClass('carBg');
    }

    if ($('.wheelBg').length) {
        $('body').addClass('wheelBg');
    }

    $('.btn').materialripple();
    $('.whiteCard').materialripple();
    $('.whiteCardSub').materialripple();
});

new WOW().init();

var myMap = {};
var myCollection = {};

/**
 * @param coords
 * @param zoom
 * @param redraw
 * @param blockObj
 * @param index
 */
function initMap(coords, zoom, redraw, blockObj, index) {
    try {
        if (blockObj.length == 0) {
            return false;
        }

        if (blockObj.find('ymaps').length == 0) {
            blockObj.html('<img src="/img/linePreLoader.gif" class="preLoaderYandexMax"/>');
        }

        if (!index) {
            index = 0;
        }

        var mapId = blockObj.attr('id');
        if (!mapId) {
            mapId = 'yandexMap_' + index;
        }

        ymaps.ready(function () {
            blockObj.find('.preLoaderYandexMax').remove();
            if (redraw) {
                myCollection[mapId].removeAll();
            } else {
                myMap[mapId] = new ymaps.Map(mapId, {
                    center: coords,
                    zoom: zoom,
                    controls: ['zoomControl']
                });
            }

            var myPlaceMark = new ymaps.Placemark(coords);
            myCollection[mapId] = new ymaps.GeoObjectCollection();
            myCollection[mapId].add(myPlaceMark);

            myMap[mapId].geoObjects.add(myCollection[mapId]);
            myMap[mapId].setCenter(coords, zoom);
        });
    } catch (e) {
    }
}

function carSelect() {
    if (jQuery(window).width() > 767) {
        $(".carSelect").css({
            position:'fixed',
            margin:'0',
            top:$(".carSelect").offset().top
        });
    } else {
        $(".carSelect").css({
            position:'relative',
            margin:'0',
            width:'auto',
            top:'0',
            left: '0',
            transform: 'translateX(0)',
        });
    }
}
$(document).ready(function() {
    if ($('.carSelect').length >= 1) {
        carSelect();
    }
});
$(window).resize(function() {
    if ($('.carSelect').length >= 1) {
        carSelect();
    }
});


function _updateItemsInForm() {
    $('input[type="checkbox"].showDeliveryAddress').onoff();
    $('.yandexMap').each(function (k) {
        $(this).attr('id', 'yandexMap_' + k);
    });
}

function _setDeliveryAutocomplete() {
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
            var block = $(this).closest('.dynamicFormRow');
            if (block.length == 0){
                block = $(this).closest('.row');
            }

            block.find('.addressCoordinates').val(b.item.point);

            try {
                initMap(b.item.point, 17, true, block.find('.yandexMap'), block.index());
            } catch (e) {
            }
        }
    });
}
$(document).ready(function () {
    _updateItemsInForm();
    _setDeliveryAutocomplete();

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
    });

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

    $(document).on('change', '.onoffswitch', function () {
        var block = $(this).closest('.dynamicFormRow');
        var obj = block.find('.deliveryAddressBlock');
        obj.toggle();

        if (obj.is(':visible')) {
            var mapId = 'yandexMap_' + block.index();
            if (myMap[mapId] == null) {
                initMap([55.0302, 82.9204], 14, false, block.find('.yandexMap'), block.index());
            }

            var destination = $(this).offset().top - 60;
            $('html, body').animate({scrollTop: destination}, 500);
            block.find('.deliveryAddress').focus();
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
                    if (checkClickRequestSubmitButton){
                        form.submit();
                        preLoaderHide();    
                    } else {
                        document.location.href = '/';
                    }
                    
                } else {
                    document.location.href = '/';
                }
            }
        });

        preLoaderHide();

        return false;
    }

    var checkClickRequestSubmitButton = false;
    $(document).on('beforeSubmit', 'form#request-form', function (event) {
        preLoaderShow();
        var status = false;
        $.ajax({
            url: '/ajax/check/user',
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.status === false) {
                    checkClickRequestSubmitButton = true;
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

(function($){
    $(document).ready(function(){
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault(); 
            event.stopPropagation(); 
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
})(jQuery);

$(document).on('click', '.yamm .dropdown-menu', function(e) {
   e.stopPropagation()
})