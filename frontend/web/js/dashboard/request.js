$(document).ready(function () {
    if ($('#yandexMapCompany').length > 0) {
        initMainOfferMap();
    }

    if ($('#yandexMapRequest').length > 0) {
        initMainRequestMap();
    }

    $(document).on('click', '.viewMainOfferInfo', function () {
        $('.mainOfferInfoBlock').toggle();
    });

    $(document).on('click', '.requestInfoView', function () {
        $('.requestInfo').toggle();
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
});