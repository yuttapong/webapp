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
            <i class="fa fa-clock-o"></i> แก้ไขล่าสุด: <span
                id="comment-updatedat<?= $model->id ?>"><?= Yii::$app->formatter->asRelativeTime($model->updated_at) ?></span>
            | <i class="fa fa-user"></i>
            ลูกค้า: <?= Html::a($model->customer->fullname, ['customer/view', 'id' => $model->customer_id], [
                'target' => '_blank',
                'title' => 'ลูกค้า'
            ]) ?>
            <div>
            <a class="btn btn-default btn-xs  btn-edit-comment comment-btn-edit<?= $model->id ?>" data-id="<?= $model->id ?>" href="javascript::void(0);">
                <i class="fa fa-edit"></i>
            </a>

            <?php
            echo Html::a('<i class="fa fa-trash"></i>', ['delete-communication', 'id' => $model->id], [
                'class' => 'btn btn-xs btn-danger',
                'data-confirm' => 'ต้องการลบที่อยุ่ที่อยุ่ใช่หรือไม่ ?',
                'data-method' => 'POST'
            ]);
            ?>
            </div>
        </p>
        <div contenteditable="false" id="comment-detail<?= $model->id ?>"
             class="comment-item"><?= nl2br(HtmlPurifier::process($model->detail)) ?></div>
        <div id="comment-nav-<?= $model->id ?>" style="display: none;" class="comment-nav">
            <button class="btn btn-primary btn-xs btn-update-comment" type="button" data-id="<?= $model->id ?>"><i
                    class="fa fa-save"></i> Save
            </button>
            <button class="btn btn-default btn-xs btn-cancel-comment" type="button" data-id="<?= $model->id ?>"><i
                    class="fa fa-refresh"></i> Cancel
            </button>
        </div>
    </div>
</div>
<hr>