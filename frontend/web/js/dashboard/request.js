$(document).ready(function () {
    $(document).on('click', '.viewMainOfferInfo', function () {
        $('.mainOfferInfoBlock').toggle();
    });

    initMap([55.0302, 82.9204], 14);
});