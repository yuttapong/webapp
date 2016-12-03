<?php
/* @var $this yii\web\View */
$this->title = 'จัดการแผนผังองค์กร';
?>



<?php

// VIEW - views/product/index.php
use kartik\tree\TreeView;
use backend\models\TreeManager;


echo TreeView::widget([
    // single query fetch to render the tree
    // use the Product model you have in the previous step
    'query' => TreeManager::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'โครงสร้าง'],
    'fontAwesome' => false,     // optional
    'isAdmin' => true,         // optional (toggle to enable admin mode)
    'displayValue' => 1,        // initial display value
    'softDelete' => true,       // defaults to true
    'cacheSettings' => [
        'enableCache' => true   // defaults to true
    ],
    'nodeView' => '@backend/views/tree-manager/_form'
]);

