<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Communication $model
 */

$this->title = $model->customer->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm.communication', 'ประวัติการติดตาม'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$datetime = $model->datetime? ' ('.Yii::$app->formatter->asDatetime($model->datetime,'short') .')':'';
?>
<div class="communication-view">
    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title . $datetime,
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            'datetime:datetime',
            'detail:ntext',
            'created_at:datetime',
            'createdName',
            'updated_at:datetime',
            'updatedName',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
