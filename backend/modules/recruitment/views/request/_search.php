<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmAppManpowerSearch $model
 * @var yii\widgets\ActiveForm $form
 */


//เมนูสถานะ
foreach ($model->statusApproveItems as $id => $label) {
    $data[] = [
        'label' => $label,
        'url' => ['request/index', 'RcmAppManpowerSearch[status]' => $id]
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

<div class="rc-app-manpower-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE

    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'position_id')->widget(Select2::className(),[
        'data' => $model->getPositionList(),
        'pluginOptions' => [
            'allowClear' => true,
            'width' => 250
        ],
        'options' => ['prompt'=> '-ตำแหน่ง-'],
    ]) ?>

    <?= $form->field($model, 'log_status')->widget(Select2::className(),[
        'data' => $model->getItemLogStatus(),
        'pluginOptions' => [
            'allowClear' => false,
            'width' => 150
        ],
        'options' => ['prompt'=> '-Log Status-']
    ]) ?>

    <?= $form->field($model, 'status')->widget(Select2::className(),[
        'data' => $model->getStatusApproveItems(),
        'pluginOptions' => [
            'allowClear' => true,
            'width' => 150
        ],
        'options' => ['prompt'=> '-สถานะอนุมัติ-']
    ]) ?>

    <?php //$form->field($model, 'leader_user_id') ?>

    <?php // echo $form->field($model, 'user_approve_id') ?>

    <?php // echo $form->field($model, 'approver_seq') ?>

    <?php // echo $form->field($model, 'user_next_id') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <?php // echo $form->field($model, 'reason_request') ?>

    <?php // echo $form->field($model, 'reason_request_text') ?>

    <?php // echo $form->field($model, 'data_property') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'log_status') ?>

    <?php // echo $form->field($model, 'date_to') ?>

    <?php // echo $form->field($model, 'salary') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
