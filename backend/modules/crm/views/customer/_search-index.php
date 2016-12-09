<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

    <!-- start  -->
    <div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ค้นหาข้อมูลลูกค้า</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->

        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_VERTICAL,
    'action' => isset($action)?$action:['index'],
    'method' => 'get',
]); ?>
<?= $form->field($model, 'firstname') ?>
<?= $form->field($model, 'lastname') ?>
<?php  echo $form->field($model, 'mobile') ?>
<?php  echo $form->field($model, 'tel') ?>
<div class="">
    <?= Html::submitButton('<i class="fa fa-search"></i> '. Yii::t('app','Search'), ['class' => 'btn btn-primary btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>

    </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- box-footer -->
    </div><!-- /.box -->

<!-- end -->
