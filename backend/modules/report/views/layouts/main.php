<?phpuse yii\bootstrap\Html;?><?php $this->beginBlock('moduleName') ?>&nbsp;<?= Html::a("Report") ?><?php $this->endBlock() ?><?php $this->beginBlock('navbar') ?><?php echo $this->render('_navbar') ?><?php $this->endBlock() ?><?php $this->beginContent('@app/views/layouts/main-full.php'); ?><div class="panel panel-default">    <div class="panel-body">        <div class="panel-content">            <div rcm-app><?= $content ?></div>        </div>    </div></div><?php $this->endContent(); ?>