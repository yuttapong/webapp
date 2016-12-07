<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title =  $model->fullnameTH;
$this->params['breadcrumbs'][] = ['label' => 'บุคลากร', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullnameTH, 'url' =>
    ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
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


    <?= $this->render('_form', [
        'model' => $model,
        'tab' => $tab,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'modelsReasonLeaving' => $modelsReasonLeaving,
        'modelsPosition' => $modelsPosition,
        'modelsGallery' => $modelsGallery,
        'citizenAmphur' => $citizenAmphur,
        'initialPreviewPhoto'=> $initialPreviewPhoto,
        'initialPreviewPhotoConfig'=>$initialPreviewPhotoConfig,

    ]) ?>

    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->