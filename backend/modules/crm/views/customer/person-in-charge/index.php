<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-plus fa-2x"></i> ผู้รับผิดชอบ</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <?php
            // ผู้ใช้งานสามารถกำหนดผู้รับผิดชอบได้หรือไม่ ?
            if(  Yii::$app->user->can('/crm/customer/change-person-in-charge'))
            {
                echo Html::a('<i class="fa fa-plus"></i>',
                    ['customer/change-person-in-charge', 'customerId' => $modelCustomer->id],
                    [
                        'class' => 'btn btn-success btn-sm  modal-add-personincharge',
                        'title' => 'กำหนดผู้รับผิดชอบ',
                        'data-header' => 'กำหนด: ผู้รับชอบ',
                    ]);
            }
            ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">



<?php  echo GridView::widget([
    'dataProvider' => $dataProviderPersonInCharge,
   // 'filterModel' => $searchModel,
    'id' => 'grid-personincharge',
    'pjax'=>true,
    'columns' => [
        [
            'attribute' => 'user_id',
            'value' => function($model) {
                $code = !empty( $model->personnel->code)?" ({$model->personnel->code})":'';
                return $model->personnel->fullnameTH . $code ;
            }
        ],
        /*
                   [
                        'class' => \kartik\grid\EditableColumn::className(),
                        'attribute' => 'active',
                        'editableOptions' => [
                            'submitOnEnter' => false,
                            'inputType' => \kartik\editable\Editable::INPUT_SWITCH,
                             'asPopover' => false,
                            'formOptions' => [
                                'action' => \yii\helpers\Url::to(['communication/editcommunication'])
                            ],
                        ],
                        'hAlign' => GridView::ALIGN_LEFT,

                    ],
        */
        [
            'attribute' => 'datetime',
            'format' => 'raw',
            'value' => function($model) {
                return \common\siricenter\thaiformatter\ThaiDate::widget([
                    'timestamp' => $model->created_at,
                    'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                    'showTime' => true,
                ]);
            }
        ],
        [
          'header' => 'สร้างโดย',
            'value' => 'createdName.firstname_th'
        ],
        'active:boolean',
        [
            'class' => '\yii\grid\ActionColumn',
            'template' => '{update-communication} {view-communication} {delete-communication}',
            'options'=> [
                'style' => 'width:60px',
            ],
            /*
            'buttons' => [
                'update-communication' => function ($url, $model) {
                    return Html::a('<i class="fa fa-edit"></i>',
                        ['update-communication', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Edit'),
                            'class' => 'modal-edit-address',
                            'data-header' => 'แก้ไข: '.$model->title,
                        ]);
                },
                'view-communication' => function ($url, $model) {
                    return Html::a('<i class="fa fa-search"></i>', ['view-communication', 'id' => $model->id], [
                        'class' => 'modal-view-communication',
                        'data-header' => Yii::$app->formatter->asDatetime($model->datetime),
                    ]);
                },
                'delete-communication' => function ($url, $model) {
                    return Html::a('<i class="fa fa-trash"></i>', ['delete-communication', 'id' => $model->id], [
                        'data-confirm' => 'ต้องการลบที่อยุ่ที่อยุ่ใช่หรือไม่ ?',
                        'data-method' => 'POST'
                    ]);

                }

            ]
            */

        ],
    ],
    'responsive'=>true,
    'hover'=>true,
    'condensed'=>true,



    /*
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
                'type'=>'info',
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                'showFooter'=>false
            ],*/
]);?>
</div><!-- /.box-body -->
<div class="box-footer">
    The footer of the box
</div><!-- box-footer -->
</div><!-- /.box -->
