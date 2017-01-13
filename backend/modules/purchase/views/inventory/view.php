<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use backend\modules\purchase\models\InventoryPrice;

\backend\modules\purchase\InventoryAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>
<h3><?= Html::encode($this->title) ?></h3>
<div class="row">

    <div class="col-md-4">
        <?php
        if( ! $model->isNewRecord) {
           if($model->file_id)  {
               echo  Html::a(Html::img(Url::to(['file/show','id'=>$model->file_id]),['class' => 'img img-thumbnail']),
                   Url::to(['file/show','id'=>$model->file_id]),
                   [
                       'class' => 'lightbox',
                       'title' => $model->name,
                       'alt' => $model->name
                   ]
               );
           }else{

           }
        }
        ?>
    </div>
    <div class="col-md-4">

        <!--  start panel -->
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">รหัสสินค้า</h3></div>
            <div class="panel-body">
                <strong class="btn btn-default btn-block"> <?=$model->code?></strong>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'master_id',
                        'created_at:datetime',
                        'created_by',
                        'updated_at:datetime',
                        'updated_by',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => ($model->status == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger'])
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <!-- end panel -->
        </div>
    <div class="col-md-4">
        <!--  start panel -->
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">ข้อมูลสินค้า</h3></div>
            <div class="panel-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'categories_id',
                        'code',
                        'type',
                        'name',
                        'unit_name',
                        'comment:ntext',
                    ],
                ]) ?>
            </div>
        </div>
        <!-- end panel -->

    </div>

</div>

<hr>

<table class="table table-bordered table-striped">
    <tr>
        <th>#</th>
        <th>Code / ID</th>
        <th>Vendor</th>
        <th><div align="right">ราคา</div></th>
        <th>หน่วนนับ</th>
        <th><div align="center">จำนวนที่จะส่งของได้</div></th>
        <th>Status</th>
    </tr>
    <?php
    if ($model->prices) {
        foreach ($model->prices as $key => $price) {
            ?>
            <tr>
                <td><?=$key+1?></td>
                <td><?= $price->vendor->code ?> / <?=$price->vendor_id?></td>
                <td><?=$price->vendor_name?> </td>
                <td align="right"><?= Yii::$app->formatter->asDecimal($price->price, 2) ?></td>
                <td> <?=$model->unit_name?></td>
                <td align="center"><?= $price->due_date ?></td>
                <td><?= ($price->status === InventoryPrice::STATUS_ACTIVE) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger']) ?></td>
            </tr>
            <?php
        }
    }
    ?>
</table>

<?php
 \newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
 echo Html::a(Html::img($model->getImageThumbnailUrl(),['width'=>150]),
    'data:image/jpeg;base64,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',
    ['rel' => 'fancybox','title' => $model->name]);

?>


