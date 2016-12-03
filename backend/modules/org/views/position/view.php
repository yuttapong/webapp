<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPosition */

$this->title = $model->name_th;
$this->params['breadcrumbs'][] = ['label' => 'ตำแหน่งงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="org-position-view">


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

    <div class="col-xs-12 col-sm-6 col-md-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'levelName',
                'name_th',
                'name_en',
            ],
        ]) ?>
    </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
               // 'id',
                'orgDivision.name',
                'orgPart.name',
                'orgDepartment.name',

            ],
        ]);?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'created_at:datetime',
                'created_by',
                'updated_at:datetime',
                'updated_by',
            ],
        ]) ?>
    </div>
</div>

    <div class="container">
        <div class="col-md-6">
        
            <?php   
            if(count($model->properties)>0){
            	echo  '<strong>คุณสมบัติผู้สมัคร</strong>';
            	$pos=1;
            	foreach ($model->properties as $val_pos){
            		echo '<div class="row">  '.$pos.'. '.$val_pos->title.'</div>';
            		$pos++;
            	}
            }
          
            ?>
        </div>
        <div class="col-md-6">
            <?php
            if(count($model->responsibilities)>0){
            	echo  '<strong>ความรับผิดชอบ</strong>';
            	$pes=1;
            	foreach ($model->responsibilities as $val_pes){
            		echo '<div class="row">  '.$pes.'. '.$val_pes->title.'</div>';
            		$pes++;
            	}
            }
          
            ?>
        </div>
    </div>


</div>
