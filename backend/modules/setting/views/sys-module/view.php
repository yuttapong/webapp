<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $model backend\models\SysModule */

$this->title = $model->name_th;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => 'โมดูล', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="sys-module-view">


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
                'slug',
                'name_en',
                'name_th',
                'description:ntext',
                'created_at:datetime',
                'created_by',
                'img',
                'url',
                'sysBd.name',
                'active',
            ],
        ]) ?>


    </div>
    <div class="col-md-6">
        <?php
        if($model->sysMenus){
            $menus = $model->sysMenus;
            echo '<table class="table table-bordered">';
            echo'<tr>';
            echo'<th>ID</th>';
            echo'<th>เมนู</th>';
            echo'<th>Route</th>';
            echo'<th>เรียงลำดับ</th>';
            echo'<th>Parent</th>';
            echo'</tr>';
            foreach ($menus as $menu){
               ?>
        <tr>
            <td><?= $menu->id?></td>
            <td><?= ($menu->parent>0)?'- '.$menu->name:$menu->name?></td>
            <td><?= $menu->route?></td>
            <td><?= $menu->order?></td>
            <td><?= $menu->parent?></td>

        </tr>
        <?php
            }
            echo'</table>';
        }
        ?>

        <?php
        echo \kartik\widgets\SideNav::widget([
            'heading' => '<i class="fa fa-star"></i> ข้อมูลเมนู',
            'headingOptions' => ['class'=>'text-strong'],
            'type' => \kartik\sidenav\SideNav::TYPE_INFO,
            'items'=> \common\models\SysModule::getMenuForNav($model->id),
        ]);
        ?>
    </div>
</div>

</div>
