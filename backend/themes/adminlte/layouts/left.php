<?php
$items =  \common\models\SysModule::getListModuleForWidget();
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <?php
            if(isset($this->blocks['moduleName'])){
                echo \yii\bootstrap\Html::tag('strong',$this->blocks['moduleName']);
            }
            ?>
            <!--
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
            -->
        </div>



        <?php
        $items = \common\models\SysModule::getListModuleForWidget();
        if(isset($this->blocks['sidebar'])){
            echo $this->blocks['sidebar'];
        } else {
              dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => $items,
                ]
            );

        }
        ?>

    </section>

</aside>
