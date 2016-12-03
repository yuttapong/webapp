<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'โปรไฟล์';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'username',
            'email:email',
            'statusName',
            'created_at:dateTime',
            'updated_at:dateTime',
        ],
    ]) ?>

</div>
