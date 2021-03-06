<?php



use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Typeahead;

/**

 * @var yii\web\View $this

 * @var backend\modules\crm\models\Communication $model

 * @var yii\widgets\ActiveForm $form

 */



?>

<?php $form = ActiveForm::begin([

    'id' => 'communication-form',

   // 'enableAjaxValidation' => true,

]);

?>

<?= Typeahead::widget ([
    'name'=> 'searchCustomer',
    'options' => [
        'placeholder' => 'ค้นหาผู้ใช้งาน:: ชื่อ, นามสกุล',
        'id' => 'search-customer',
    ],
    'pluginOptions' => ['highlight' => true, 'minLength' => 2],
    'pluginEvents' => [
        "typeahead:selected" => "function(obj, item) { 
                                $('#res-user_id').val(item.id);  
                                $('#res-name').val(item.value);  
                                return true;
                             }",
    ],
    'dataset' => [
        [
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'name',
            'remote' => [
                'url' => Url::to(['personnel-list']) . '?q=%QUERY',
                'wildcard' => '%QUERY'
            ]
        ]
    ]
]) ?>
<?= $form->field($model, 'user_id')->textInput(['class' => 'form-control','id'=>'res-user_id','readonly'=>true]) ?>
<?= $form->field($model, 'customer_id')->hiddenInput(['class' => 'form-control','value'=>$customer->id,'readonly'=> true])->label(false) ?>
<?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

<?php
echo Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
    'onclick' => "$.ajax({
        url : $('#communication-form').attr('action'),
        type: 'post',
        data:$('#communication-form').serialize(),
        dataType:'json',
        success:function(rs){
        console.log(rs);
        if(rs.success == 1){
            $('#res-result').html(rs.msg).addClass(rs.msgClass);
            $.pjax.reload({container:\"#grid-personincharge\"}); 
        }else{
           $('#res-result').html(rs.msg).addClass(rs.msgClass);
        }
        }
    });
    return false;
    "

]);
echo '&nbsp;&nbsp;' . Html::tag('span',null,['id'=>'res-result']);
ActiveForm::end(); ?>

