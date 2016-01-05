$(document).ready(function () {
    initRequestMap();

    $(document).on('click', '.viewMainOfferInfo', function () {
        $('.mainOfferInfoBlock').toggle();
    });

    function initRequestMap() {
        var coordinates = $('.addressCoordinates').val();
        if (coordinates) {
            coordinates = coordinates.split(',');
        } else {
            coordinates = [55.0302, 82.9204];
        }

        initMap(coordinates, 14);
    }
});