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
<div class="row">
    <?php
    if(isset($this->blocks['sidebar'])){
        ?>
        <div class="col-md-10">
            <div><?= $content ?></div>
        </div>
        <div class="col-md-2"><?=$this->blocks['sidebar']?></div>
        <?php
    }else{
        ?>
        <div class="col-md-12">
            <div><?= $content ?></div>
        </div>
        <?php
    }
    ?>
</div>
<?php $this->endContent(); ?>

