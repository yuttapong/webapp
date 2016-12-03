<?php
use yii\widgets\DetailView;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' =>  'fullnameTH',
                    'value' => $model->prefix_name_th.' '.$model->fullnameTH,

                ],
                [
                    'attribute' =>  'fullnameEN',
                    'value' => $model->prefix_name_en.' '.$model->fullnameEN,

                ],
                'middlename_th',
                'middlename_en',
                'birthday:date',
                'age',
                // 'day_probation',
                //'work_status',
                //'work_type',
                //'status',
                'nickname',
            ],
        ]) ?>

    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'militaryStatusName',
                'nationalityName',
                'raceName',
                'religionName',
                'bloodName',
                'livingStatusName',
                'marriageStatusName',
            ],
        ]) ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'idcard',
                'idcardProvinceName',
                'idcardAmphurName',
                'idcard_date_expiry:date',
            ],
        ]) ?>
    </div>

</div>
