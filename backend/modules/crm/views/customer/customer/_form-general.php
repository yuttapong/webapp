<?php
/**
 * Created by IntelliJ IDEA.
 * User: RB
 * Date: 10/12/2559
 * Time: 14:25
 */

use kartik\builder\Form;
?>
<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 4,
    'attributes' => [
        'gender' => [
            'type' => Form::INPUT_DROPDOWN_LIST,
            'items' => $model->getGenderItems(),
            'options' => ['prompt' => '-เพศ-']
        ],
        'prefixname' => ['type' => Form::INPUT_DROPDOWN_LIST,'items'=>$model->getPrefixNameItems(),'options'=> [
            'prompt' => '-คำนำหน้า-'
        ]],
        'prefixname_other' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'คำนำหน้าพิเศษ...']],

        'firstname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ ชื่อจริง...']],
        'lastname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ นามสกุล...']],

        'age' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ อายุ...']],
        // 'birthday' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATE]],
        'birthday' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \yii\widgets\MaskedInput::className(),
            'options' => [

                'clientOptions' => [
                    'alias' => ['99-99-9999']
                ]
            ],
        ],
        'tel' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ เบอร์โทร...']],
        'mobile' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \yii\widgets\MaskedInput::className(),
            'options' => [
                'clientOptions' => [
                    'alias' => ['9999999999']
                ]
            ],
        ],

        'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ Email...']],
        'source' => [
            'type' => Form::INPUT_DROPDOWN_LIST,
            'items'=>$model->getSourceItems(),
            'options'=> [
                'prompt' => '-แหล่งที่มา-'
            ]
        ],
        'is_vip' => ['type' => Form::INPUT_CHECKBOX, 'options' => ['title' => 'เป็นลูกค้า VIP']],

    ]

]);
?>
