<?php
use yii\bootstrap\Html;

?>
<?php $this->beginBlock('moduleName') ?>
&nbsp;<?= Html::a("CRM") ?>
<?php $this->endBlock() ?>



<?php $this->beginBlock('navbar') ?>
<?php echo $this->render('_navbar') ?>
<?php $this->endBlock() ?>



<?php $this->beginContent('@app/views/layouts/main-full.php'); ?>

 <div><?= $content ?></div>


<?php $this->endContent(); ?>

