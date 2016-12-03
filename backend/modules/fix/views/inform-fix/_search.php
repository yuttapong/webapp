<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformFixSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inform-fix-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'fform-inline'
        ]
    ]); ?>
      <div class="row">


    <?php // $form->field($model, 'id') ?>
      <div class="col-xs-12 col-sm-6 col-md-5">
          <?= $form->field($model, 'project_id')
              ->dropDownList(ArrayHelper::map(\common\models\Project::find()->all(),'id', 'name'),['prompt'=>'--Select--']) ?>

      </div>
     <div class="col-xs-12 col-sm-3 col-md-2"><?= $form->field($model, 'plan_no') ?></div>
     <div class="col-xs-12 col-sm-3 col-md-2"> <?= $form->field($model, 'home_no') ?></div>
          <div class="col-xs-12 col-sm-12 col-md-2">
              <div class="form-group">
              <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
              <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
              </div>
          </div>
      </div>






    <?php ActiveForm::end(); ?>

</div>
