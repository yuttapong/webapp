<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgJobOption */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Org Job Option', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-job-option-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Org Job Option'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
                        
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'hidden' => true],
        [
            'attribute' => 'orgPosition._id',
            'label' => 'Position',
        ],
        '_type',
        'title',
        'create_at',
        'create_id',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>