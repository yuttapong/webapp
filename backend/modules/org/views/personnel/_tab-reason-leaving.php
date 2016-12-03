<?php
use yii\widgets\DetailView;

/**
 * Created by PhpStorm.
 * User: Noom
 * Date: 10/6/2559
 * Time: 10:05
 */
?>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th width="20%">เหตุผล</th>
        <th width="20%">วันที่ทำรายการ</th>
        <th>ผู้ทำรายการ</th>

    </tr>
    <?php
    if ($model->jobReasonLeaving) {
        $datas = $model->jobReasonLeaving;
        foreach ($datas as $w) {
            ?>

            <tr>
                <td><?=$w->id?></td>
                <td><?= nl2br($w->note) ?></td>
                <td><?=Yii::$app->thaiFormatter->asDatetime($w->created_at,'medium') ?></td>
                <td><?= $w->created_by ?></td>
                <td></td>
            </tr>

            <?php
        }
    }

    ?>
</table>


