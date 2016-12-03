<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'รายงาน';
$this->params['breadcrumbs'][] = ['label' => 'CRM', 'url' => ['/crm']];
$this->params['breadcrumbs'][] = ['label' => 'แบบสอบถามลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Html::button('<i class="fa fa-search"></i> เลือกช่วงเวลา...', [
    'class' => 'btn btn-default',
    'data-toggle' => 'modal',
    'data-target' => '#search-modal'
]);
?>
<?php
Modal::begin([
    'id' => 'search-modal',
    'header' => '<h2>ค้นหา</h2>',
]);
?>
<?php Modal::end() ?>
<?php Pjax::begin() ?>
<h1><i class="fa fa-bar-chart"></i> <?= $this->title ?></h1>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<table class="table table-bordered table-condensed">
    <tr>
        <th>แบบสอบถาม</th>
        <th>วันที่มาเยี่ยมชม</th>
        <th>รหัสลูกค้า</th>
        <th>ลูกค้า</th>
        <th>วันที่บันทึกลงระบบ</th>
        <th>CE</th>
    </tr>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list-item',
    ]);
    ?>
</table>
<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
<?php Pjax::end() ?>
