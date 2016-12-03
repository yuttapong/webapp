<?phpuse yii\helpers\Html;use yii\widgets\ActiveForm;/* @var $this yii\web\View *//* @var $model backend\modules\crm\models\Response *//* @var $form yii\widgets\ActiveForm */?><div class="response-form">    <?php $form = ActiveForm::begin(); ?>    <?= $form->field($model, 'survey_id')->textInput(['maxlength' => true]) ?>    <?= $form->field($model, 'submitted')->textInput() ?>    <?= $form->field($model, 'complete')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>    <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>    <?= $form->field($model, 'table_key')->textInput() ?>    <?= $form->field($model, 'created_at')->textInput() ?>    <?= $form->field($model, 'created_by')->textInput() ?>    <?= $form->field($model, 'site_id')->textInput() ?>    <?= $form->field($model, 'customer_id')->textInput() ?>    <div class="form-group">        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>    </div>    <?php ActiveForm::end(); ?></div>