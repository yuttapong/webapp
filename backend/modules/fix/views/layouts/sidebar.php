<?php
use common\models\SysMenu;

$items = SysMenu::getSidebarItem('crm');
?>
<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items,
]);
?>