<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'บริษัท', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-company-view">


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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'name',
            'address_full:ntext',
            'contact',
            'img',
            [
                'label' => 'จำนวนไซต์งาน',
                'value' =>$model->countOrgSite(),
            ],
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ]) ?>

</div>
