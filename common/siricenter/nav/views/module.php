<?php
/**
 * Created by PhpStorm.
 * User: Yuttapong Napikun
 * Date: 4/6/2559
 * Time: 13:31
 */
use kartik\icons\Icon;
use kartik\helpers\Html;

?>
    <!--
<div class="row">
    <div class="col-xs-12">
        <div align="">

            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    Application
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <?php
    /*
    foreach ($items as $moduleId => $item):
        echo Html::tag('li', Html::a(@$item['label'], [@$item['url']]));
        ?>
    <?php 
    endforeach;
    */
    ?>
                </ul>
            </div>

        </div>
    </div>
</div>
<br>
<div class="clearfix"></div>
-->
<?php
echo '<div class="row">';
foreach ($items as $moduleId => $item):
    echo '<div class="col-xs-6 col-sm-4 col-md-3">';
    echo '<div align="center" style="valign:middle;min-height:120px;">';
    echo Html::a('<i class="fa-5x ' . ($item['icon'] ? $item['icon'] : 'fa fa-desktop') . '"></i>' . '<br><span>' . @$item['label'] . '</span>', [@$item['url']]);
    echo '</div>';
    echo '</div>';
endforeach;
echo '</div>';
?>