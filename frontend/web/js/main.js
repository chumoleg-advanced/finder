$(document).ready(function () {
    $.extend($.ui.autocomplete.prototype, {
        _renderItem: function (ul, item) {
            var searchMask = this.element.val();
            var regEx = new RegExp(searchMask, "ig");
            var replaceMask = "<b>$&</b>";
            var html = item.label.replace(regEx, replaceMask);

            return $("<li></li>")
                .data("item.autocomplete", item)
                .append($("<a></a>").html(html))
                .appendTo(ul);
        }
    });

    $(".dynamicform_wrapper").on("afterInsert", function (e, item) {
        try {
            activateAutoComplete();

            $('input[type=checkbox]').val(function (i, val) {
                return $(this).data('value');
            });
        } catch (err) {
        }
    });

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
        obj.find('.help-block').text('');
        obj.find('.deleteService').show();
        obj.appendTo('.placeListServices');
    });

    $(document).on('click', '.deleteService', function () {
        $(this).closest('.serviceRow').remove();
    });

    $(document).on('click', '.showFileUpload', function () {
        $(this).closest('.form-options-item').find('.uploadFilesBlock').toggle();
    });

    $(document).on('change', '.buttonListPartsCondition', function () {
        var obj = $(this).closest('.form-options-item').find('.partsOriginal');
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