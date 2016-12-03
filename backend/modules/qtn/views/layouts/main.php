<?php
use yii\bootstrap\Html;

?>

<?php $this->beginBlock('moduleName') ?>
&nbsp;<?= Html::a("CRM") ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('sidebar') ?>
<?= $this->render('sidebar') ?>
<?php $this->endBlock() ?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-content">
            <p>
                <?php
                echo \yii\bootstrap\Nav::widget([
                    'items' => [
                        ['label' => 'แบบฟอร์ม', 'url' => ['survey/index']],
                    ],
                    'options' => ['class' => 'nav-pills'], // set this to nav-tab to get tab-styled navigation
                ]);
                ?>

            </p>
            <div rcm-app><?= $content ?></div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
