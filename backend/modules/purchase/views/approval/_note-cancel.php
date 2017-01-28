<?php
use yii\helpers\Html;

?>


<?= \common\siricenter\thaiformatter\ThaiDate::widget([
    'timestamp' => $note['cancelAt'],
    'showTime' => true,
]);
?>
<div class="row">
    <div class="col-xs-3">ผู้ยกเลิก</div>
    <div class="col-xs-9"></div>
</div>
<p><?=Html::decode($note['note'])?></p>
