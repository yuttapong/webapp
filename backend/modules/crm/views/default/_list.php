<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>

<div class="media">
    <div class="media-left media-middle" style="min-width:120px" align="center">
        <a href="#">
            <i class="fa fa-user-circle fa-3x"></i><br>
           <?=$model->createdName?>
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"> <?= \common\siricenter\thaiformatter\ThaiDate::widget([
                'timestamp' => $model->created_at,
                'showTime' => true
            ]) ?></h4>
        <?= HtmlPurifier::process($model->detail) ?>
    </div>
</div>
<hr>