<?php
use common\models\SysMenu;

$items = SysMenu::getSidebarItem(4);
?>

<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items,
]);
?>