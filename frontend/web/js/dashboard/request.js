$(document).ready(function () {
    initMainOfferMap();

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
});