<?php
/**
 * Created by PhpStorm.
 * User: Yuttapong Napikun
 * Date: 4/6/2559
 * Time: 16:26
 */
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\bootstrap\Nav;

?>
<style>

    .badge-red {
        background-color: #d43f3a;
    }

    .badge-green {
        background-color: #00aa00;
    }

    .badge-blue {
        background-color: #0000cc;
    }

    .notify-approve {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .notify-approve li {
        padding: 3px;
    }

    .notify-approve li:hover {
        cursor: pointer;
        background-color: #f4f0ec;
    }
</style>
<?php
if ($type == 'panel'):
    ?>
    <div class="row">
    </div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-cloud"></i>&nbsp;&nbsp;
                <?= $heading ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="panel-content">
                <?php
                if ($items) {
                    // echo  Nav::widget(['items'=>$items]);
                    echo '<ul class="notify-approve">';
                    foreach ($items as $item) {
                        // if ($item['count'] > 0) {
                        $label = '<i class="fa fa-check"></i> ' . $item['label'];
                        $label .= '<span class="badge badge-' . $color . ' pull-right">' . ($item['count']) . '</span>';
                        echo '<li class="item">' . Html::a($label) . '</li>';
                        //}
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
<?php elseif ($type = 'nav'): ?>

<?php endif; ?>
