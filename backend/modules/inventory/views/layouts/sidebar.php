<?php
use common\models\SysMenu;

$items = SysMenu::getSidebarItem('inventory');
?>

<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items,
]);
?>