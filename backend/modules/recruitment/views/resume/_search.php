<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model backend\modules\recruitment\models\RcmAppFormSearch */
/* @var $form yii\widgets\ActiveForm */


//เมนูสถานะ
foreach ($model->statusItems as $id => $label) {
    $data[] = [
        'label' => $label,
        'url' => ['resume/index', 'RcmAppFormSearch[status]' => $id],
        'active' => Yii::$app->request->get('RcmAppFormSearch[status]') == $id ? true : false,
    ];
}
NavBar::begin(['brandLabel' => Html::activeLabel($model, 'status')]);
echo Nav::widget([
    'items' => $data,
    'activateParents' => true,
    'activateItems' => true,
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>

<div class="form-rcm-app-form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'inline'
    ]); ?>



    <?= $form->field($model, 'q')->textInput(['placeholder' => 'ชื่อ, นามสกุล, เลขที่สม้คร',])->label(false) ?>
    <?= $form->field($model, 'status')->dropDownList($model->statusItems, ['prompt' => '--สถานะใบสมัคร--']) ?>
    <?php /* echo $form->field($model, 'type')->dropDownList([ 'Wait' => 'Wait', 'Call' => 'Call', ], ['prompt' => '']) */ ?>

    <?php /* echo $form->field($model, 'status')->dropDownList([ 'Finish' => 'Finish', 'Canceled' => 'Canceled', 'Start' => 'Start', ], ['prompt' => '']) */ ?>

    <?php /* echo $form->field($model, 'description')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'position_id')->textInput(['maxlength' => true, 'placeholder' => 'Position']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-plus"></i> กรอกใบสมัคร', ['apply'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
