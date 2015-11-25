<div class="additionOptions">
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <?= $this->render('_additionCarData', ['form' => $form, 'model' => $model]); ?>
        </div>
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <?= $this->render('_districtWithMe', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>
</div>