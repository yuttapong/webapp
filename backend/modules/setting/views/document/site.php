<?php
/* @var $this yii\web\View */


$this->title = 'การอนุมัติ';
$this->params['breadcrumbs'][] = $this->title;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\widgets\SwitchInput;
use common\models\SysDocumentOption;
use common\models\SysDocument;

use kartik\select2\Select2;

use unclead\multipleinput\MultipleInputColumn;
use unclead\multipleinput\MultipleInput;


$option['user_id']= Yii::$app->user->id;
$option['site_id']=1;
$xxx=$modelsDocument->getDataApprove($modelsDocument->document_id,$option);

echo '<pre>';
print_r($xxx);
echo '</pre>';
?>

<?php  $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

 <?php echo $form->field($modelsDocument, 'document_id')->hiddenInput(['maxlength' => true])->label(false) ?>
    <div class="panel panel-info">
        <div class="panel-heading"><strong class="panel-title"><?= $modelsDocument->name ?></strong></div>
        <div class="panel-body">
         <?php 
         foreach ($modelsDocument->documentOptions as $index => $option) {
         	
         	$data=unserialize( $option->data);
         	
      
         	$_type=$option->_type;
         	if ($option->_type == SysDocumentOption::TYPE_CUSTOM) {
         		echo '<div class="well">';
         		echo '<div class=" row">';
         		echo '<div class="col-xs-6 col-sm-6">กำหนดเอง';
         		echo   $form->field($option, '[1]_id')->hiddenInput()->label(false);
         		echo   $form->field($option, '[1]_type')->hiddenInput()->label(false);
         		echo   $form->field($option, '[1]seq')->textInput()->label();
         		echo '</div>';
         		echo '<div class="col-xs-6 col-sm-6">';
         		echo $form->field($option, '[1]active')->widget(SwitchInput::className(), [
         				'id' => uniqid()
         		]);
         		echo '</div>';
         	
         		$indexData = 0;
         		//foreach ($option->extractData as $data) {
         		echo 	$this->render('_form_position', [
         				'model' => $modelsDocument,
         				'modelPos' =>$modelPos,
         				'modelPersonnel' =>$modelPersonnel,
         				'form'=>$form
         		]);
         		/*echo $form->field($option, '[1]data')->widget(MultipleInput::className(), [
         				'limit' => 10,
         				'allowEmptyList' => true,
         				'data'=> $modelsDocument->documentPersonnel,
         				'rowOptions' => [
         						'id' => 'row{multiple_index_sysdocumentoption-1-data}',
         						
         				],
         				'columns' => [
         						[ 	'name' => 'id',
         							'title' => 'ID', 
         							'enableError' => true,
         								 'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
         								
         						 ], 
         						[
         								'name' => 'personnel_id',
         								'title' => 'พนักงาน',
         								// 'defaultValue' => 1,
         								'type' => \kartik\select2\Select2::className(),
         								'enableError' => true,
         								'options' => [
         										
         										'data' => $option->personnelItems,
         									
         										'pluginOptions' => [
         												'placeholder' => '--เลือกพนักงาน--',
         												'allowClear' => true,
         											
         										],
         								]
         						],
         						[
         								'name' => 'position_id',
         								//'type'  => MultipleInputColumn::TYPE_DROPDOWN,
         								'type' => \kartik\select2\Select2::className(),
         								'title' => 'ตำแหน่งงาน',
         								'options' => [
         										'data' =>$option->positionItems,
         										'pluginOptions' => [
         												'placeholder' => 'เลือกตำแหน่งงาน',
         												'allowClear' => true,
         											
         										],
         								],
         								// 'defaultValue' => 1,
         								//'items' => $option->positionItems
         						],
         				],
         		])->label(false);*/
         						echo '</div>';//row
         						echo '</div>';//well
         	
         	
         	}
         	/**************************************
         	 * อนุมัติตามตำแหน่ง
         	 *************************************/
         	if ($option->_type == SysDocumentOption::TYPE_POSITION) {
         		$option->position=$data;
         		echo '<div class="well">';
         		echo '<div class="row">';
         		echo '<div class="col-xs-9">';
         		echo   $form->field($option, '[2]_id')->hiddenInput()->label(false);
         		echo   $form->field($option, '[2]_type')->hiddenInput()->label(false);
         		echo   $form->field($option, '[2]seq')->textInput()->label();
         		echo $form->field($option, '[2]position')->widget(MultipleInput::className(), [
         				//'limit' => 10,
         				'allowEmptyList' => true,
         				'data'=> $data,
         				
         				'columns' => [
         						[ 	'name' => 'id',
         							'title' => 'ID', 
         							'enableError' => true,
         								 'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
         								
         						 ], 
         						[
         								'name' => 'position_id',
         								//'type'  => MultipleInputColumn::TYPE_DROPDOWN,
         								'type' => \kartik\select2\Select2::className(),
         								'title' => 'ตำแหน่งงาน',
         								'options' => [
         										'data' =>$option->positionItems,
         										'pluginOptions' => [
         												'placeholder' => 'เลือกตำแหน่งงาน',
         												'allowClear' => true,
         											
         										],
         								],
         								// 'defaultValue' => 1,
         								//'items' => $option->positionItems
         						],
         				],
         		])->label(false);
         		
         		/*echo $form->field($option, '[2]position')->widget(\kartik\widgets\Select2::classname(), [
         				'name' => "[" . SysDocumentOption::TYPE_POSITION . "]",
         				'data' => $option->positionItems,
         				'options' => [
         						'id' => uniqid(),
         						'multiple' => true,
         				]
         		] ) ->label(false);*/
         				 
         				echo '</div>';
         				echo '<div class="col-xs-3">';
         				echo $form->field($option, "[2]active")->widget(SwitchInput::className(), [
         						'id' => uniqid(),
         				]) ->label(false);
         					
         				echo '</div>';
         	
         				echo '</div>';// row
         				echo '</div>';		
         	}
         	if ($option->_type == SysDocumentOption::TYPE_ORGANIZATION) { 
         		 $option->level=$data['level'];
         		echo '<div class="well">';
         		echo '<div class="row">';
         		echo '<div class="col-xs-2">';
         		echo   $form->field($option, '[3]seq')->textInput()->label();
         		echo '</div>';
         		echo '<div class="col-xs-7">';
         		echo   $form->field($option, '[3]_id')->hiddenInput()->label(false);
         		echo   $form->field($option, '[3]_type')->hiddenInput()->label(false);
         		
         		echo $form->field($option, '[3]level')->widget(Select2::classname(), [
         				'data' => [1=>'lvel 1',2=>'lvel 2',3=>'lvel 3',4=>'lvel 4'],
         				'options' => ['placeholder' => 'Select a state ...'],
         				'pluginOptions' => [
         						'allowClear' => true
         				],
         		]);
         		echo '</div>';
         		echo '<div class="col-xs-3">';
         		echo $form->field($option, "[3]active")->widget(SwitchInput::className(), [
         				'id' => uniqid(),
         		]) ->label(false);
         		echo '</div>';
         		echo '</div>';// row
         		echo '</div>';
         	}
         }
         ?>
        </div>
    </div>




<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php 
$js = <<<JS
$('#sysdocumentoption-1-data').on('afterInit', function(){
    console.log('calls on after initialization event');
}).on('beforeAddRow', function(e,row) {
    console.log('calls on before add row event');
}).on('afterAddRow', function(e) {
		alert(JSON.stringify(e.target.id));

    console.log('calls on after add row event');
}).on('beforeDeleteRow', function(e, row){
		alert(JSON.stringify(row));
    // row - HTML container of the current row for removal.
    // For TableRenderer it is tr.multiple-input-list__item
    console.log('calls on before remove row event.');
      console.log(row);
   // return confirm('Are you sure you want to delete row?')
}).on('afterDeleteRow', function(e, row){
    console.log('calls on after remove row event');
    console.log(row);
});
JS;
$this->registerJs($js);
?>
