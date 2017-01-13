<?php
use yii\bootstrap\Html;
$data = [1,3,3];
?>
<td><?=\kartik\widgets\Select2::widget([
        'name' => 'state_2',
        'value' => '',
        'data' => $data,
        'options' => ['multiple' => true, 'placeholder' => 'Select states ...']
    ])?></td>
<td><?= Html::activeTextInput($model,"[$key]price") ?></td>
<td><a data-action="delete"><i class="fa fa-trash"></i></a></td>
