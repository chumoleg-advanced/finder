<?php
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\company\CompanyContactData;
use frontend\assets\CompanyAsset;

CompanyAsset::register($this);
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'companyContactDataDynamic',
    'widgetBody'      => '.container-items',
    'widgetItem'      => '.item',
    'limit'           => 12,
    'min'             => 1,
    'insertButton'    => '.add-item',
    'deleteButton'    => '.remove-item',
    'model'           => new CompanyContactData(),
    'formId'          => 'company-data-form',
    'formFields'      => [
        'type',
        'data'
    ],
]);
?>

    <div class="form-group form-options-body">
        <div class="container-items">
            <?php
            if (isset($modelCompany)) {
                foreach ($modelCompany->companyContactDatas as $k => $contactData) {
                    echo $this->render('_contactDataRow', ['form' => $form, 'model' => $contactData, 'k' => $k]);
                }

            } else {
                echo $this->render('_contactDataRow', ['form' => $form, 'model' => new CompanyContactData(), 'k' => 0]);
            }
            ?>
        </div>

        <a class="btn btn-default add-item">
            <i class="glyphicon glyphicon-plus"></i> Добавить
        </a>
    </div>
<?php DynamicFormWidget::end(); ?>