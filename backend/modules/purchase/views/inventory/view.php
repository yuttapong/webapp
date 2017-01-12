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
                        'create_at:datetime',
                        'create_by',
                        'update_at:datetime',
                        'update_by',
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
 Html::a(Html::img('http://www.sirivalai.com/images/slide/main1.jpg',['width'=>250]),
    'http://www.sirivalai.com/images/slide/main1.jpg',
    ['rel' => 'fancybox']);

?>
<hr>
<a href="http://www.sirivalai.com/images/slide/main1.jpg" class="lightbox" title="">
    <img src="http://www.sirivalai.com/images/slide/main1.jpg" alt="Thumbnail 1"  width="250">
</a>

