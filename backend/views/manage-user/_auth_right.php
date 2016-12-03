<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 3/6/2559
 * Time: 14:07
 */
use common\models\SysModule;
use yii\bootstrap\Html;

?>
<table class="table table-bordered" border="1">
    <tr>
        <td></td>
        <td>ชื่อรายการ</td>
        <td>จัดการ</td>
    </tr>
    <?php
    if ($auth_right) {
        foreach ($auth_right as $right) {
            ?>
            <tr>
                <td><?=Html::checkbox("right[{$right->_id}]")?></td>
                <td><?=$right->menu->name?></td>
                <td>
                    <?php
                    foreach($right->getItemRight($right->menu_id) as $r){
                        echo Html::checkbox("itemRight[]").'&nbsp;'.$r->item_item.'&nbsp&nbsp';

                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>
