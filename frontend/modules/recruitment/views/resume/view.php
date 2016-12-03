<?php

use kartik\tabs\TabsX;
use kartik\helpers\Html;
/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title = $modelPersonnel->fullnameTH;
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = ['label' => 'ใบสมัครงาน', 'url' => ['list']];
$this->params['breadcrumbs'][] = $model->code;

?>
<div class="org-personnel-view">
    <p>
        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <div class="row">
        <div class="col-xs-3 col-sm-4 col-md-3">
            <p align="left">
                <?php echo Html::img($model->photoUrl,['class' => 'img img-responsive img-thumbnail'])?>
            </p>

        </div>
        <div class="col-xs-9 col-sm-8 col-md-9">
            <table class="table">
                <tr>
                    <td><?=Html::activeLabel($model,'code')?></td>
                    <td><?=Html::decode($model->code)?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($modelPersonnel,'fullnameTH')?></td>
                    <td><?=Html::decode($modelPersonnel->fullnameTH)?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($modelPersonnel,'educations')?></td>
                    <td><?=$modelPersonnel->getLatestEductionName()?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'positionApply')?></td>
                    <td><?=$model->getShowApplyPosition()?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'salary_desired')?></td>
                    <td><?=$model->salary_desired?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'created_at')?></td>
                    <td><?=Yii::$app->formatter->asDatetime($model->created_at)?></td>
                </tr>
                <tr>
                    <td><?=Html::activeLabel($model,'updated_at')?></td>
                    <td><?=Yii::$app->formatter->asDatetime($model->updated_at)?></td>
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
                'model' => $modelPersonnel
            ]),
            'active' => true
        ],
        [
            'label' => '<i class="fa fa-graduation-cap" aria-hidden="true"></i> การศึกษา',
            'content' => $this->render('_tab-education', [
                'model' => $modelPersonnel
            ]),
        ],
        [
            'label' => '<i class="fa fa-graduation-group" aria-hidden="true"></i> ประวัติการทำงาน',
            'content' => $this->render('_tab-work', [
                'model' => $modelPersonnel
            ]),
        ],
    ];
?>

    <?php

    echo TabsX::widget([
        'items' => $items,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        //'bordered' => true,
    ]);


    ?>


</div>
