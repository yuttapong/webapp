<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title = 'เพิ่มบุคลากร';
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


    <?= $this->render('_form', [
        'model' => $model,
        'tab' => $tab,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'modelsReasonLeaving' => $modelsReasonLeaving,
        'modelsPosition' => $modelsPosition,
        'citizenAmphur' => $citizenAmphur,
        'initialPreviewPhoto'=> $initialPreviewPhoto,
        'initialPreviewPhotoConfig'=>$initialPreviewPhotoConfig,
    ]) ?>

    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->