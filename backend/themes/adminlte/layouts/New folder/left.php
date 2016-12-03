<?php
$userId = Yii::$app->user->id;
$user = \common\models\User::findIdentity($userId);

if(isset($sidebarItems)){
    $items = $sidebarItems;
}else{
    $items =  \common\models\SysModule::getListModuleForWidget();

}


?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <?php
            if(isset($this->blocks['moduleName'])){
                echo $this->blocks['moduleName'];
            }
            ?>
        </div>


        <!-- search form -->
        <form action="#" method="get" class="sidebar-form hidden">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php
        $items = \common\models\SysModule::getListModuleForWidget();
        if(isset($this->blocks['sidebar'])){

           echo $this->blocks['sidebar'];
        } else {

          echo  dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => $items,
                ]
            );

        }
        ?>

    </section>

</aside>
