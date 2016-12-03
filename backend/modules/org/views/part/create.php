<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\orgPart */

$this->title = 'สร้างส่วนงาน';
$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['division/index']
];
if (Yii::$app->request->get('division_id')) {
    $this->params['breadcrumbs'][] = [
        'label' => $modelDivision->name,
        'url' => ['index', 'division_id' => $modelDivision->id]
    ];

}


$this->params['breadcrumbs'][] = [
    'label' => 'ส่วนงาน',
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-part-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
