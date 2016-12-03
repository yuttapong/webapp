<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmAppManpower $model
 */

$this->title = 'แบบฟอร์มขออัตรากำลังคน';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลขออัตรากำลัง', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rc-app-manpower-create">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
