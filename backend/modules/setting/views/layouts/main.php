<?php
use yii\bootstrap\Html;
?>
<?php $this->beginBlock('moduleName')?>
<?= Html::a("Setting")?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('sidebar') ?>
<?= $this->render('sidebar')?>
<?php $this->endBlock() ?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <div class="panel panel-default">
    <div class="panel-body">
    <div class="panel-content">
    <?= $content?>
    </div>
    </div>
    </div>
<?php $this->endContent();