<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

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
  <div class="row">
      <div class="col-md-6">
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'id',
                  'master_id',
                  'categories_id',
                  'code',
                  'type',
                  'name',
                  'unit_id',
                  'unit_name',
                  'comment:ntext',
              ],
          ]) ?>
      </div>

      <div class="col-md-6">
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'status',
                  'create_at',
                  'create_by',
                  'update_at',
                  'update_by',
              ],
          ]) ?>
      </div>
  </div>


