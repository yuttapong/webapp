<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Project;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformFixSearch */
/* @var $form yii\widgets\ActiveForm */

$dataHome=[];
if(!empty($_GET['InformFixSearch']['project_id']) && $_GET['InformFixSearch']['project_id']!='' ){
	$dataHome=	Yii::$app->controller->getHomeList($_GET['InformFixSearch']['project_id']);

}
?>

<div class="inform-fix-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
   <div class="row">
       <div class="col-sm-2 col-md-2">
        <?= $form->field($model, 'project_id')->dropdownList(
            ArrayHelper::map(Project::find()->all(),
            'id',
            'name'),
            [
                'id'=>'ddl-project',
                'prompt'=>'--เลือกโครงการ--'
       ]); ?>
       </div>
        <div class="col-sm-4 col-md-4">
       <?= $form->field($model, 'home_id')->widget(DepDrop::classname(), [
       		'type'=>DepDrop::TYPE_SELECT2,
       		'select2Options' => ['pluginOptions'=>['allowClear'=>true]],
         'data'=>$dataHome,
       		'pluginOptions'=>[
            	
                'depends'=>['ddl-project'],
                'placeholder'=>'---แปลงบ้าน--',
                'url'=>Url::to(['home/get-home'])
            ],

        ]); ?>
    </div>
    <div class="col-sm-2 col-md-2">
     <?php  echo $form->field($model, 'code') ?>
     </div>
     <div class="col-sm-2 col-md-2">
       <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
     </div>
    </div>   

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'date_inform') ?>

    <?php // echo $form->field($model, 'customs_id') ?>

    <?php // echo $form->field($model, 'name_inform') ?>

    <?php // echo $form->field($model, 'job_status') ?>

    <?php // echo $form->field($model, 'job_sub_status') ?>

    <?php // echo $form->field($model, 'work_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'type') ?>

  

    <?php ActiveForm::end(); ?>

</div>
