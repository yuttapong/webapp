<?php
use kartik\form\ActiveForm;
use yii\bootstrap\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'บุคลากร', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>$model->fullnameTH , 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'build-form',
    //'enableAjaxValidation' => true,
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>
<?= $form->errorSummary($user) ?>
<?=$form->field($user, 'email')->textInput(['readonly'=> true])?>
<?=$form->field($user,'username')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? '<fa class="fa fa-save"></i> Set Password' : 'Reset Password', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'data' => [
                'confirm' => 'ยืนยันข้อมูล ? '
            ]
        ]) ?>
    </div>


<?php
if( ! $user->isNewRecord){
    echo Html::activeHiddenInput($user,'id');
}
?>


<?php ActiveForm::end(); ?>

<?php
