<?php
use yii\helpers\ArrayHelper;

?>

<div class="row rowOffer">
    <div class="col-md-12">
        <a href="javascript:;" class="viewMainOfferInfo">Посмотреть предложение</a>

        <div class="mainOfferInfoBlock" style="display: none;">
            <table class="table table-striped table-condensed table-bordered detail-view">
                <tr>
                    <th>Описание</th>
                    <td><?= $model->description; ?></td>
                </tr>
                <tr>
                    <th>Комментарий</th>
                    <td><?= $model->comment; ?></td>
                </tr>

                <?php foreach ($model->getAttributesData() as $attribute => $value) : ?>
                    <tr>
                        <th><?= ArrayHelper::getValue($labels, $attribute); ?></th>
                        <td><?= $value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>