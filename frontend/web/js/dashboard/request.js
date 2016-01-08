$(document).ready(function () {
    initRequestMap();

    $(document).on('click', '.viewMainOfferInfo', function () {
        $('.mainOfferInfoBlock').toggle();
    });

    $(document).on('click', '.requestInfoView', function () {
        $('.requestInfo').toggle();
    });

    function initRequestMap() {
        var coordinates = $('.addressCoordinates').val();
        if (coordinates) {
            coordinates = coordinates.split(',');
            initMap(coordinates, 17);
        }
    }
});