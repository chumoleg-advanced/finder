$(document).ready(function () {
    $(document).on('change', 'input[type=radio][name=categoryId]', function () {
        var value = $(this).val();
        $.pjax({
            url: $('#filter-form').attr('action'),
            container: '#requestGrid',
            data: {'RequestSearch[categoryId]': value}
        });
    });

    $(document).on('change', 'input[type=radio][name=companyId]', function () {
        var value = $(this).val();
        $.pjax({
            url: $('#filter-form').attr('action'),
            container: '#requestGrid',
            data: {'RequestSearch[performer_company_id]': value}
        });
    });
});