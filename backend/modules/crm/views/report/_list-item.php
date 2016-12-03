<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 26/9/2559
 * Time: 12:32
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<tr class="item" data-key="<?= $model->id; ?>">
    <td><?=$model->survey->name?></td>
    <td><?=Yii::$app->formatter->asDate($model->datetime,'medium')?></td>
    <td><?=$model->customer->id?></td>
    <td><?=$model->customer->fullname?></td>
    <td><?=Yii::$app->formatter->asDate($model->created_at,'medium')?></td>
    <td><?=$model->created->firstname_th?></td>
</tr>