ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map('yandexMap', {
        center: [55.0302, 82.9204],
        zoom: 10,
        controls: ['zoomControl']
    });

    ymaps.geocode('Россия, Новосибирск', {
        results: 1
    }).then(function (res) {
        var firstGeoObject = res.geoObjects.get(0);
        var coords = firstGeoObject.geometry.getCoordinates();
        myMap.geoObjects.add(firstGeoObject);
    });
}