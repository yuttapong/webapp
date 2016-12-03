<?php
use common\models\SysMenu;
$items = SysMenu::getSidebarItem('hr');
?>

<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items,
]);
?>