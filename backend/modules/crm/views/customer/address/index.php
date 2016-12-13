<?php
use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="table-responsive">
    <?php
    \yii\widgets\Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProviderAddress,
        'columns' => [
            /*        [
                        'attribute' => 'active',
                        'format' => 'raw',
                        'value' => function($model){
                            return ($model->active)
                                ?'<span class="label label-success">Active</span>'
                                :'<span class="label label-danger">Inactive</span>';
                        }
            ],*/
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    if ($model->type == \common\models\GeneralAddress::TYPE_CONTACT) {
                        return $model->typeName;
                    } elseif ($model->type == \common\models\GeneralAddress::TYPE_OFFICE) {
                        return $model->typeName;
                    }
                }
            ],
            'company',
            'no',
            // 'amphur.name_th',
            'province.name_th',
            [
                'class' => '\yii\grid\ActionColumn',
                'template' => '{update-address} {view-address} {delete-address}',
                'buttons' => [
                    'update-address' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>',
                            ['update-address', 'id' => $model->id], [
                                'title' => Yii::t('yii', 'Edit'),
                                'class' => 'modal-edit-address',
                                'data-header' => 'แก้ไข: ' . $model->typeName,
                            ]);
                    },
                    'view-address' => function ($url, $model) {
                        return Html::a('<i class="fa fa-search"></i>', ['view-address', 'id' => $model->id], [
                            'class' => 'modal-view-address',
                            'data-header' => 'รายละเอียด: ' . $model->typeName,
                        ]);
                    },
                    'delete-address' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete-address', 'id' => $model->id], [
                            'data-confirm' => 'ต้องการลบที่อยุ่ที่อยุ่ใช่หรือไม่ ?',
                            'data-method' => 'POST'
                        ]);

                    }

                ]

            ],


        ]

    ]);

    \yii\widgets\Pjax::end();
    ?>
  </div>
