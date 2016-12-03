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



<div class="customer-search well">



    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_INLINE,
        'action' => ['index'],

        'method' => 'get',

    ]); ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'lastname') ?>
        <?php  echo $form->field($model, 'mobile') ?>
        <?php  echo $form->field($model, 'tel') ?>
        <?= Html::submitButton(Yii::t('app','Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app','Reset'), ['class' => 'btn btn-default']) ?>
        <?=Html::a('<i class="fa fa-plus"></i> เพิ่มข้อมูลลูกค้าใหม่', ['create'], ['class' => 'btn btn-success'])?>
    <?php ActiveForm::end(); ?>

</div>

