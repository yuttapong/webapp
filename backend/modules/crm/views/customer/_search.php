<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\CustomerSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>
 <?php $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_INLINE,
                'action' => isset($action)?$action:['index'],
                'method' => 'get',
 ]); ?>
<?= $form->field($model, 'firstname') ?>
<?= $form->field($model, 'lastname') ?>
<?php  echo $form->field($model, 'mobile') ?>
<?php  echo $form->field($model, 'tel') ?>
<?= $form->field($model, 'id') ?>
<?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>



