<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrgSite */

$this->title = $model->site_name;
$this->params['breadcrumbs'][] = ['label' => 'ไซต์งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-site-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->site_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->site_id], [
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
            'site_id',
            'site_type',
            'site_name',
            'site_description:ntext',
            'company.name',
            'created_at:dateTime',
            'created_by',
            'updated_at:dateTime',
            'updated_by',
        ],
    ]) ?>

</div>
