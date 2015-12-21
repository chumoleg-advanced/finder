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

    $('.checkAllRubrics').change(function () {
        var selector = $(this).is(':checked') ? true : false;
        $(this).closest('.companyRubricsList').find('.categoryRubrics input[type="checkbox"]').each(function () {
            $(this).prop('checked', selector);
        });
    });
});