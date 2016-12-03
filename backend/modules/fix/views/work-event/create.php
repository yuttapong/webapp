<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\WorkEvent */

$this->title = 'เพิ่มข้อมูล ลง ปฏิทิน';
$this->params['breadcrumbs'][] = ['label' => 'Work Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
