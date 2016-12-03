<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\recruitment\models\RcmAppForm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rcm App Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rcm-app-form-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Rcm App Form'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'hidden' => true],
        'company_id',
        'salary_desired',
        'personnel_id',
        'interview_status',
        'type',
        'status',
        'description:ntext',
        'position_id',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
