<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setting.role', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\mdm\admin\AnimateAsset::register($this);
\yii\web\YiiAsset::register($this);

$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';

/*
echo '<pre>';
print_r($itemsAllRole);
echo '<pre>';


echo '<pre>';
print_r($itemsAssigned);
echo '<pre>';
*/

?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">


    <p>
        <?= Html::a(Yii::t('setting.role', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('setting.role', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger hidden',
            'data' => [
                'confirm' => Yii::t('setting.role', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>



<div class="row">
    <div class="col-xs-12 col-sm-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'email:email',
                'statusName',
                'created_at:datetime',
                'updated_at:datetime',
                'logged_in_ip',
                'logged_in_at:datetime',
                'banned_reason',
            ],
        ]) ?>

    </div>
    <div class="col-xs-12 col-sm-6">
         <h4><strong>สามารถเห็น Icon ระบบต่อไปนี้</strong></h4>
         <?php
         foreach ($modules as $module) {
             $mark = '<i class="fa fa-close"></i>';
             $textClass = 'text text-danger';
             if (in_array($module->id, $userModule)) {
                 $mark =  '<i class="fa fa-check-circle"></i>';
                 $textClass = 'text text-success text-strong';
             }
             echo Html::tag('p', $mark  . ' ' .  $module->name_th, ['class'=>$textClass]);
         }


         ?>


     </div>

</div>

        <!--
        <div class="row">
            <div class="col-sm-5">
                <input class="form-control search" data-target="available"
                       placeholder="<?=Yii::t('rbac-admin', 'Search for available');?>">
                <select multiple size="20" class="form-control list" data-target="available">
                </select>
            </div>
            <div class="col-sm-1">
                <br><br>
                <?=Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => (string) $model->id], [
                    'class' => 'btn btn-success btn-assign',
                    'data-target' => 'available',
                    'title' => Yii::t('rbac-admin', 'Assign'),
                ]);?><br><br>
                <?=Html::a('&lt;&lt;' . $animateIcon, ['revoke', 'id' => (string) $model->id], [
                    'class' => 'btn btn-danger btn-assign',
                    'data-target' => 'assigned',
                    'title' => Yii::t('rbac-admin', 'Remove'),
                ]);?>
            </div>
            <div class="col-sm-5">
                <input class="form-control search" data-target="assigned"
                       placeholder="<?=Yii::t('rbac-admin', 'Search for assigned');?>">
                <select multiple size="20" class="form-control list" data-target="assigned">
                </select>
            </div>
        </div>

  -->

</div><!-- /.box-body -->
<div class="box-footer">
</div><!-- box-footer -->
</div><!-- /.box -->




<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Roles</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

<?php
foreach ($itemsAllRole as $itemAllRole) {
    $mark = '<i class="fa fa-close"></i>';
    $textClass = 'text text-disabed';

    if (in_array($itemAllRole, $itemsAssigned)) {
        $mark =  '<i class="fa fa-check-circle"></i>';
        $textClass = 'text text-success';
    }
    echo Html::tag('div', $mark  . ' ' .  $itemAllRole, ['class'=>$textClass]);

}
?>
</div><!-- /.box-body -->
<div class="box-footer">
</div><!-- box-footer -->
</div><!-- /.box -->