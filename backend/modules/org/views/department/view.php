<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\orgDepartment */
$this->title = $model->name;

$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['division/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->orgPart->orgDivision->name,
    'url' => ['parts', 'division_id' => $model->orgPart->orgDivision->id]
];

$this->params['breadcrumbs'][] = [
    'label' => $model->orgPart->name,
    'url' => ['departments', 'part_id' => $model->part_id]
];


$this->params['breadcrumbs'][] = $this->title;
echo $userId = Yii::$app->user->id;
?>
<div class="org-department-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update-department', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-department', 'id' => $model->id], [
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
            'orgDivision.name',
            'orgPart.name',
            'email:email',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ]) ?>

</div>

