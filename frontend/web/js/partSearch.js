$(document).ready(function () {
    activateAutoComplete();

    $(document).on('click', '.ajaxLink', function () {
        var selected = $(this).hasClass('active');
        formSideSelect($(this));
        if (selected) {
            return false;
        }

        var links = $(this).closest('.form-options-item').find('.ajaxLink');
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
        var links = $(this).closest('.form-options-item').find('.ajaxLink');
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
    var query = link.closest('.form-options-item').find('.descriptionQuery');
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
                url: '/search/parts-list',
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