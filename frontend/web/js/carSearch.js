$(document).ready(function () {
    $('.carFirmSelect').change(function () {
        _updateSelect($(this).val(), 'carModelSelect', 'car-model');
    });

    $('.carModelSelect').change(function () {
        _updateSelect($(this).val(), 'carBodySelect', 'car-body');
    });

    $('.carBodySelect').change(function () {
        _updateSelect($(this).val(), 'carMotorSelect', 'car-motor');
    });
});

function _updateSelect(selected, className, urlAction) {
    var modelObj = $('.' + className);
    var attributes = {
        id: modelObj.attr('id'),
        name: modelObj.attr('name'),
        class: modelObj.attr('class'),
        prompt: modelObj.find('option:first').text()
    };

    $.post('/ajax/car-search/' + urlAction, {id: selected, attributes: attributes}, function (data) {
        modelObj.html(data);
        modelObj.trigger('change');
    }, 'html');
}