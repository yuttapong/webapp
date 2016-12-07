<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title = $model->fullnameTH;
$this->params['breadcrumbs'][] = ['label' => 'บุคลากร', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <?= Html::a('<i class="fa fa-arrow-left"></i> ฺBack', ['index'], ['class' => 'btn btn-default']) ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

    <p>
        <?= Html::a('<i class="fa fa-edit"></i> แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('<i class="fa fa-trash"></i> ลบ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณต้องการลบข้อมูลผู้ใช้งานนี้ ใช่หรือไม่ ?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('<i class="fa fa-key"></i> ตั้ง/กู้ Password', ['build-username', 'id' => $model->id], [
            'class' => 'btn btn-default',
        ]) ?>
    </p>
    <div class="row">
        <div class="col-xs12 col-sm12 col-md-2">
            <div align="center">
                <?= Html::img($model->photoThumbnailLink,['class'=>'img img-responsive img-thumbnail']);?>
                <div><strong><?=$model->code?></strong></div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <table class="table">
                <tr>
                    <td><?=Html::activeLabel($model,'fullnameTH')?></td>
                    <td><?=$model->fullnameTH?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'educations')?></td>
                    <td><?=$model->getLatestEductionName()?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'age')?></td>
                    <td><?=$model->age?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'birthday')?></td>
                    <td>
                        <?php echo Yii::$app->formatter->asDate($model->birthday)?>

                    </td>
                  <tr>
                    <td>Email</td>
                    <td>
                        <?php echo Html::encode(@$model->user->email)?>

                    </td>
                </tr>
                </tr>
            </table>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <table class="table">
                <tr>
                    <td><?=Html::activeLabel($model,'work_status')?></td>
                    <td><?=$model->workStatusName?> (<?=$model->work_status?>)</td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'work_type')?></td>
                    <td><?=$model->workTypeName?>  (<?=$model->work_type?>)</td>
                </tr>
            </table>
        </div>
    </div>
<br>
    <?php
    $items = [
        [
            'label' => '<i class="fa fa-user"></i> ทั่วไป',
            'content' => $this->render('_tab-general', [
                'model' => $model
            ]),
            'active' => true
        ],
        [
            'label' => '<i class="fa fa-graduation-cap" aria-hidden="true"></i> การศึกษา',
            'content' => $this->render('_tab-education', [
                'model' => $model
            ]),
        ],
        [
            'label' => '<i class="fa fa-users" aria-hidden="true"></i> ประวัติการทำงาน',
            'content' => $this->render('_tab-work', [
                'model' => $model
            ]),
        ],
        [
            'label' => '<i class="fa fa-star" aria-hidden="true"></i> เหตุผลที่ออกจากงาน',
            'content' => $this->render('_tab-reason-leaving', [
                'model' => $model
            ]),
        ],
        [
            'label' => '<i class="fa fa-users"></i> ตำแหน่งงานที่รับผิดชอบ',
            'headerOptions' => ['class' => 'disabled']
        ],
        [
            'label' => '<i class="glyphicon glyphicon-king"></i> Disabled',
            'headerOptions' => ['class' => 'disabled']
        ],
    ];
?>

    <?php

     TabsX::widget([
        'items' => $items,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        //'bordered' => true,
    ]);


    ?>


    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->
