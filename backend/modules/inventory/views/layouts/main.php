<?php
use yii\bootstrap\Html;
?>
<?php $this->beginBlock('moduleName')?>
<?= Html::a("Inventory")?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('sidebar') ?>
<?= $this->render('sidebar')?>
<?php $this->endBlock() ?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?= $content?>
<?php $this->endContent();