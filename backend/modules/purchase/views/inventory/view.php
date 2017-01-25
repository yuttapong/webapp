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
                <td><?php
                     if ($price->active === InventoryPrice::STATUS_ACTIVE)
                         $t = [
                            'name' => 'Active',
                             'class' => 'label label-success',
                         ];
                    else
                        $t = [
                            'name' => 'Inactive',
                            'class' => 'label label-danger',
                        ];

                     Html::a($t['name'],"javascript:void(0);",[
                        'id' => 'noomy_toggle_'. $price['id'],
                        'data-status' => $price['active'],
                        'data-id' => $price['id'],
                        'onclick' => new \yii\web\JsExpression('
                          var id =  $(this).data("id");
                          var status = $(this).data("status");
                          var target = $(this).attr("id");
                          if(status==0){ 
                                $(this).removeClass("label-danger").addClass("label-success"); 
                                $(this).text("Active");
                                $(this).data("status",1);
                          }
                          if(status==1){ 
                                $(this).removeClass("label-success").addClass("label-danger"); 
                                 $(this).text("Inactive");
                                 $(this).data("status",0);
                          }
                        '),
                        'class' => $t['class']
                    ]);

                    echo \backend\modules\purchase\widgets\buttontoggle\ButtonToggleStatus::widget([
                        'dataKey' => $price['id'],
                        'dataStatus' => $price['active'],
                        'url' => 'change-price-status',
                        'options' => [
                            'title' => $price['vendor_name']
                        ]
                    ]);
                    ?></td>
            </tr>
            <?php
        }
    }
    ?>
</table>



