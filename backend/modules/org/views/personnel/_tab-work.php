<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: Noom
 * Date: 10/6/2559
 * Time: 10:05
 */
$modelWork = new \backend\modules\org\models\OrgPersonnelWork();
?>
<table class="table table-striped">
    <tr>
        <th><?=Html::activeLabel($modelWork,'seq')?></th>
        <th  width="20%"><?=Html::activeLabel($modelWork,'company')?></th>
        <th  width="20%"><?=Html::activeLabel($modelWork,'business_type')?></th>
        <th><?=Html::activeLabel($modelWork,'address')?></th>
        <th  width="20%"><?=Html::activeLabel($modelWork,'scope_work')?></th>
        <th  width="20%"><?=Html::activeLabel($modelWork,'reason_leaving')?></th>
    </tr>
    <?php
    if($model->works){
        foreach ($model->works as $w){
            ?>

            <tr>
                <td><?=$w->seq?></td>
                <td><?=$w->company?></td>
                <td><?=$w->business_type?></td>
                <td><?=$w->address?></td>
                <td><?=nl2br($w->scope_work)?></td>
                <td><?=$w->reason_leaving?></td>
            </tr>

            <?php
        }
    }

    ?>
</table>


