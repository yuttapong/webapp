<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/modules/crm/assets');
?>

<div class="media">
    <div class="media-left media-middle" style="min-width:120px" align="center">
        <a href="#">
            <div><?= Html::img($directoryAsset . '/img/ce.png') ?></div>
            <?= $model->createdName ?>
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= Html::encode($model->title) ?></h4>
        <p>
            <i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </p>
        <?= nl2br(HtmlPurifier::process($model->detail)) ?>
    </div>
</div>
<hr>