$(document).ready(function () {
    $('.loginButton').click(function () {
        $('#loginForm').modal();
    });

    $('.showAdditionOptions').click(function () {
        $('.additionOptions').toggle();
    });

    $('.showDistrictSelect').change(function () {
        $('.districtSelect').toggle();
    });

    $('.showDeliveryAddress').change(function () {
        $('.deliveryAddress').toggle();
    });

    $('.addService').click(function () {
        var obj = $('.serviceRow:first-child').clone();
        obj.find('.form-control').val('');
        obj.find('.deleteService').show();
        obj.appendTo('.placeListServices');
    });

    $(document).on('click', '.deleteService', function () {
        $(this).closest('.serviceRow').remove();
    });

    $(document).on('change', '.radioButtonListPartsCondition', function () {
        var obj = $(this).closest('.serviceRow').find('.partsOriginal');
        var value = $(this).find('.active input[type="radio"]').val();
        if (value == 1){
            obj.show();
        } else {
            obj.hide();
        }
    });

    $(document).on('beforeSubmit', 'form#login-form', function () {
        var errorDiv = $('.error-summary');
        errorDiv.hide();

        var form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if (response == 1) {
                    $('button.close').trigger('click');
                    window.location.reload();

                } else {
                    $('.error-summary ul').html('<li>Incorrect username or password.</li>');
                    errorDiv.show();
                }
            }
        });

        return false;
    });
});