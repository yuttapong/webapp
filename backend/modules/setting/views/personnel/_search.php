<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-personnel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',

    ]); ?>
    <?= $form->field($model, 'code')->textInput(['placeholder' => 'รหัสพนักงาน']) ?>
    <?php echo $form->field($model, 'firstname_th')->textInput(['placeholder' => 'ชื่อจริง']) ?>
    <?php echo $form->field($model, 'lastname_th')->textInput(['placeholder' => 'นามสกุล']) ?>
    <?= $form->field($model, 'work_status')->dropDownList($model->workStatusItems, ['prompt' => '--สถานะ--']) ?>
    <?= $form->field($model, 'work_type')->dropDownList($model->workTypeItems, ['prompt' => '--ประเภท--']) ?>
    <?php // $form->field($model, 'prefix_name_en') ?>


    <?php // echo $form->field($model, 'firstname_en') ?>

    <?php // echo $form->field($model, 'middlename_th') ?>

    <?php // echo $form->field($model, 'middlename_en') ?>



    <?php // echo $form->field($model, 'lastname_en') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'day_probation') ?>

    <?php // echo $form->field($model, 'work_status') ?>

    <?php // echo $form->field($model, 'work_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'nationality') ?>

    <?php // echo $form->field($model, 'race') ?>

    <?php // echo $form->field($model, 'religion') ?>

    <?php // echo $form->field($model, 'idcard') ?>

    <?php // echo $form->field($model, 'blood') ?>

    <?php // echo $form->field($model, 'status_living') ?>

    <?php // echo $form->field($model, 'marriage_status') ?>

    <?php // echo $form->field($model, 'idcard_province_id') ?>

    <?php // echo $form->field($model, 'idcard_amphur_id') ?>

    <?php // echo $form->field($model, 'idcard_day_end') ?>

    <?php // echo $form->field($model, 'military_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
