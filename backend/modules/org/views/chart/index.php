<?php
/* @var $this yii\web\View */
$this->title = 'แผนผังองค์กร';

use yii\widgets\Pjax;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\widgets\treeimge\TreeImage;
use backend\modules\org\models\TreeManager;
use common\siricenter\tree\TreeAjax;
?>
<?php

echo TreeImage::widget([
    'query' => TreeManager::find()->addOrderBy('root, lft'),
    'root'      => 'Parent',
    'icon'      => 'list',
    'iconRoot'  => 'tree fa-4x',
]);

?>








