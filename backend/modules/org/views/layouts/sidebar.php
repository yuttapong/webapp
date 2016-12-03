<?php
use common\models\SysMenu;

$items = SysMenu::getSidebarItem('org');
?>

<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items,
]);
?>