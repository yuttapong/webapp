<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;


/**

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var backend\modules\crm\models\CommunicationSearch $searchModel

 */



$this->title = Yii::t('crm.communication', 'ประวัติการติดต่อลูกค้า');

$this->params['breadcrumbs'][] = $this->title;

?>

<?php
    echo  ListView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid-communication',
        'itemView' => 'communication/_list',
        'itemOptions' => ['class' => 'col-xs-12 col-sm-12'],
        'layout' => "{items}\n{pager}",
    ]);



