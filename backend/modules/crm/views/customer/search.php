<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\crm\models\CustomerSearch $searchModel
 */


$this->title = 'ค้นหาลูกค้า';

$this->params['breadcrumbs'][] = $this->title;

?>

<?php
echo $this->render('toolbar/customer');
?>

<br>
<div class="row">
    <div class="col-md-4 col-lg-4">

         <?php echo $this->render('_search-index', [
             'model' => $searchModel,
             'action' => ['index']
         ]); ?>

</div>
    </div>



