<?php
use common\models\SysMenu;

$items = SysMenu::getSidebarItem('recruitment');
?>
<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items,
]);
?>