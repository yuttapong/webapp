<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 21/6/2559
 * Time: 17:53
 */
use kartik\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\Place */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-6">

    <div class="placegoogle-form">
        <p>พิมพ์สถานะที่ต้องการ:</p>

        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal'
        ]); ?>
        <?= $form->field($model, 'searchbox')->textInput(['maxlength' => 255])->label('Place') ?>
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'google_place_id'); ?>
        <?= $form->field($model, 'location'); ?>
        <?= $form->field($model, 'website'); ?>
        <?= $form->field($model, 'vicinity'); ?>
        <?= $form->field($model, 'full_address'); ?>
        <?= $form->field($model, 'place_type')
            ->dropDownList($model->getPlaceTypeOptions(),
                ['prompt' => 'What type of place is this?']
            )->label('Type of Place') ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::resetButton( Yii::t('app','Reset'), ['class' => 'btn btn-default' ])?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div> <!-- end col1 -->
<div class="col-md-6">
    <div id="map-canvas">
        <article></article>
    </div>
</div> <!-- end col2 -->