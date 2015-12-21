function disableEnterKey(e) {
    var key;
    if (window.event) {
        key = window.event.keyCode;
    } else {
        key = e.which;
    }

    if (key == 13) {
        return false;
    }

    return true;
}

$(document).ready(function () {
    $('#auto-service-form').attr('onKeyPress', 'return disableEnterKey(event)');

    $('a.delete-item').hide();

    $.extend($.ui.autocomplete.prototype, {
        _renderItem: function (ul, item) {
            var searchMask = this.element.val();
            var html = item.label;
            try {
                var regEx = new RegExp(searchMask, "ig");
                var replaceMask = "<b>$&</b>";
                html = item.label.replace(regEx, replaceMask);
            } catch (e) {
            }

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

            var form = $('#auto-service-form');
            form.find(".dynamicFormRow").each(function (index) {
                var attribute = {
                    enableAjaxValidation: true,
                    encodeError: true,
                    container: ".field-queryarrayform-" + index + "-condition",
                    error: ".help-block",
                    id: "queryarrayform-" + index + "-condition",
                    input: "#queryarrayform-" + index + "-condition",
                    name: "[" + index + "]condition",
                };

                form.yiiActiveForm('add', attribute);
            });
        } catch (err) {
        }
    });

    $(".option-value-img").on("filecleared", function (event) {
        var regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
        var id = event.target.id;
        var matches = id.match(regexID);
        if (matches && matches.length === 4) {
            var identifiers = matches[2].split("-");
            $("#optionvalue-" + identifiers[1] + "-deleteimg").val("1");
        }
    });

    $(document).on('click', '.ajaxLink', function () {
        var selected = $(this).hasClass('active');
        formSideSelect($(this));
        if (selected) {
            return false;
        }

        var links = $(this).closest('.dynamicFormRow').find('.ajaxLink');
        var index = links.index(this);
        if (index == 0 && links.eq(1).hasClass('active')) formSideSelect(links.eq(1));
        if (index == 1 && links.eq(0).hasClass('active')) formSideSelect(links.eq(0));

        if (index == 2 && links.eq(3).hasClass('active')) formSideSelect(links.eq(3));
        if (index == 3 && links.eq(2).hasClass('active')) formSideSelect(links.eq(2));

        if (index == 4 && links.eq(5).hasClass('active')) formSideSelect(links.eq(5));
        if (index == 5 && links.eq(4).hasClass('active')) formSideSelect(links.eq(4));

        return false;
    });

    $(document).on('change keyup', '.descriptionQuery', function () {
        var val = $(this).val();
        var links = $(this).closest('.dynamicFormRow').find('.ajaxLink');
        if (val != '') {
            var valFirstWord = val.split(' ')[0];
            var sideForm = new Array('левый', 'правый', 'передний', 'задний', 'верхний', 'нижний');

            if (valFirstWord.match(/(а|епь|ерь|ось|сть|ая|яя|оль|аль|eль|ля|ня|нель)$/i)) sideForm = new Array('левая', 'правая', 'передняя', 'задняя', 'верхняя', 'нижняя');
            else if (valFirstWord.match(/(ее|ие|ле|ое|ще|ье|ло|ое|но|цо|хо)$/i)) sideForm = new Array('левое', 'правое', 'переднее', 'заднее', 'верхнее', 'нижнее');
            else if (valFirstWord.match(/(и|ы|нья|ые|зья|ия)$/i)) sideForm = new Array('левые', 'правые', 'передние', 'задние', 'верхние', 'нижние');

            links.eq(0).text(sideForm[0]);
            links.eq(1).text(sideForm[1]);
            links.eq(2).text(sideForm[2]);
            links.eq(3).text(sideForm[3]);
            links.eq(4).text(sideForm[4]);
            links.eq(5).text(sideForm[5]);
        }

        links.each(function () {
            if (val.match(new RegExp('([^а-я])(' + $(this).attr('match') + ')[а-я]{0,}', 'gi')) ||
                val.match(new RegExp('^(' + $(this).attr('match') + ')[а-я]{0,}', 'gi'))) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    });
});

function formSideSelect(link) {
    var query = link.closest('.dynamicFormRow').find('.descriptionQuery');
    var val = query.val();
    var selected = link.hasClass('active');

    if (selected) {
        link.each(function () {
            val = val.replace(new RegExp('([^а-я])(' + link.attr('match') + ')[а-я]{0,}', 'gi'), '$1');
            val = val.replace(new RegExp('^(' + link.attr('match') + ')[а-я]{0,}', 'gi'), '');
        });
    } else {
        val += ' ' + link.text();
    }

    val = $.trim(val.replace(/\s+/g, ' '));
    query.val(val).change();
}

function activateAutoComplete() {
    $('.descriptionQuery').autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: '/ajax/search/parts-list',
                dataType: 'json',
                data: {q: request.term},
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.value,
                            value: item.value
                        };
                    }));
                }
            });
        }
    });
}