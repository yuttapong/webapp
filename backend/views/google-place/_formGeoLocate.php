<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 21/6/2559
 * Time: 17:39
 */

use yii\helpers\Html;
use yii\helpers\BaseHtml;
use yii\widgets\ActiveForm;

use backend\assets\LocateAsset;
LocateAsset::register($this);
?>
<div class="place-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">

        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'website')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'place_type')
            ->dropDownList(
                $model->getPlaceTypeOptions(),
                ['prompt'=>'What type of place is this?']
            )->label('Type of Place') ?>

        <?= $form->field($model, 'notes')->textArea() ?>

        <?= BaseHtml::activeHiddenInput($model, 'lat'); ?>
        <?= BaseHtml::activeHiddenInput($model, 'lng'); ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div> <!-- end col 1 --><div class="col-md-6">
        <div id="preSearch" class="center">
            <p><br /></p>    <?= Html::a('Lookup Location',"#", ['class' => 'btn btn-success', 'onclick' => "javascript:beginSearch();return false;"]) ?>
        </div>

        <div id="searchArea" class="hidden">
            <div id="autolocateAlert">
            </div> <!-- end autolocateAlert -->
            <p>Searching for your current location...<span id="status"></span></p>
            <article>
            </article>
            <div class="form-actions hidden" id="actionBar">
            </div> <!-- end action Bar-->
        </div>   <!-- end searchArea -->
    </div> <!-- end col 2 -->
    <?php ActiveForm::end(); ?>

</div>
