<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\crm\models\CustomerSearch $searchModel
 */


$this->title = 'ค้นหาลูกค้า';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="div">
    <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-3">
     <div class="well">

         <?php echo $this->render('_search-index', [
             'model' => $searchModel,
             'action' => ['index']
         ]); ?>

     </div>
    </div>
</div>



