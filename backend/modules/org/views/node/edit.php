<?php
use backend\modules\org\models\OrgCompany;

use kartik\tree\TreeView;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
$tree_id=!empty($_GET['tree_id'])?$_GET['tree_id']:'';
$this->title = 'จัดการแผนผังองค์กร';
$this->params['breadcrumbs'][] = ['label' => 'บริษัท', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => $modelCompany->name, 'url' => ['company/view','id'=>$modelCompany->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <strong><?=$modelCompany->name?></strong>
    </div>
</div>
<?php
$template = <<<TEMPLATE
<div class="row">
    <div class="col-sm-6">
        {wrapper}
    </div>
    <div class="col-sm-6">
        {detail}
    </div>
</div>

TEMPLATE;
echo Html::hiddenInput('currentCompany',$modelCompany->id,['id'=>'current-company-id']);
echo TreeView::widget([
    'query' => $models,
		'nodeLabel'=>'id',
    'headingOptions' => ['label' => 'โครงสร้าง'],
    'fontAwesome' => false,     // optional
    'isAdmin' => true,         // optional (toggle to enable admin mode)
   'displayValue' => $tree_id,        // initial display value
    'softDelete' => true,       // defaults to true
    'cacheSettings' => [
        'enableCache' => false   // defaults to true
    ],

    'nodeView' => '@backend/modules/org/views/node/_form',
    'allowNewRoots' => true,
    'mainTemplate' => $template,
    'nodeFormOptions' => ['class'=> '']

]);

