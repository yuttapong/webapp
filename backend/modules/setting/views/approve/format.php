<?php
/* @var $this yii\web\View */


$this->title = 'รูปแบบการอนุมัติ';
$this->params['breadcrumbs'][] = $this->title;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\widgets\SwitchInput;
use common\models\SysDocumentOption;
use common\models\SysDocument;
use unclead\widgets\MultipleInput;


?>

<?php $form = ActiveForm::begin([
]); ?>

<?php

if($formats) {
    foreach ($formats as $format) {
        //echo Html::tag('p', $format->name);
    }
}

?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
