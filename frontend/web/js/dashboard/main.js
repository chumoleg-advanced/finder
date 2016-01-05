$(document).ready(function () {
    _toggleFormElements($('.companyFormGroup'));

    function _toggleFormElements(obj) {
        var formId = obj.find('.active input').val();
        if (formId == 2) {
            $('.fioForm, .ogrnForm').hide();
            $('.legalNameForm, .actualNameForm, .ogrnipForm').show();

        } else if (formId == 3) {
            $('.legalNameForm, .actualNameForm, .ogrnipForm, .ogrnForm').hide();
            $('.fioForm').show();

        } else {
            $('.fioForm, .ogrnipForm').hide();
            $('.legalNameForm, .actualNameForm, .ogrnForm').show();
        }
    }

    $(document).on('change', '.companyFormGroup', function () {
        _toggleFormElements($(this));
    });

    $(document).on('change', '.checkAllRubrics', function () {
        var selector = $(this).is(':checked') ? true : false;
        $(this).closest('.companyRubricsList').find('.categoryRubrics input[type="checkbox"]').each(function () {
            $(this).prop('checked', selector);
        });
    });

    $(document).on('change', 'input[type=radio][name=categoryId]', function () {
        var value = $(this).val();
        $.pjax({
            url: $('#filter-form').attr('action'),
            container: '#requestGrid',
            data: {'RequestSearch[categoryId]': value}
        });
    });
});