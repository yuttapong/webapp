<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'โปรไฟล์';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <?=Html::img($profile->getPhotoThumbnailLink(),['class'=>'img img-responsive' ])?>
    <h5><?=$profile->fullnameTH?></h5>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
        ],
    ]) ?>

    <?php
    echo Html::img($model->getImageUrl('avatar'));
    echo Html::img($model->getImageUrl('logo', 'mini')); //get url of thumbnail named 'mini' for 'logo' attribute


    ?>

</div>
