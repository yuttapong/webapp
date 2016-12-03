<?php


use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;

 ?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-3">
        <?php
        $tags ;
        ?>
    </div>
    <div class="col-md-9">
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>
