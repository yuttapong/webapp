<?php
/**
 * Created by PhpStorm.
 * User: Yuttapong Napikun
 * Date: 4/6/2559
 * Time: 13:31
 */
use kartik\icons\Icon;
use yii\helpers\Html;

$i = 0;
foreach ($items as $item):?>
    <?php

    if ($i >= 1) {

    }
    ?>
    <div class="row">
    </div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?= $item['label'] ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="panel-content">
                <?php
                foreach ($item['items'] as $subitem) {
                    echo '<div class="col-xs-6 col-sm-3 col-md-2" align="center">';
                    echo Html::a('<i class="fa fa-2x fa-industry circle"></i>' . '<br>' . $subitem['label'], $subitem['url']);
                    echo '</div>';
                }

                ?>
            </div>
        </div>
    </div>
    <?php
    $i++;
endforeach;


?>

