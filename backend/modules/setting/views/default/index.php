<?php
use yii\bootstrap\Html;
/*
echo '<pre>';
print_r($items);
echo'<pre>';
*/
$this->title = 'Dashboard';
/*
echo Html::beginTag('div', ['class' => 'row']);
foreach ($items as $name => $item) {
    echo Html::beginTag('div', ['class' => 'col-xs-4 col-sm-3']);
    echo Html::beginTag('div', ['class' => 'alert alert-warning']);
    echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-xs-12 col-sm-12']);
    echo Html::tag('div', "<i class='{$item['icon']} fa-3x'></i>", ['align' => 'center']);
    echo Html::endTag('div');
    echo Html::beginTag('div', ['class' => 'col-xs-12 col-sm-12', 'align' => "center"]);
    $link = Html::a($item['name'], $item['url']);
    echo Html::tag('div', $link . ' <span class="badge badge-red">' . $item['count'] . '</span>', ['class' => '']);

    echo Html::endTag('div');
    echo Html::endTag('div');
    echo Html::endTag('div');
    echo Html::endTag('div');

}
echo Html::endTag('div');
*/
?>

        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-green"><i class="fa fa-user-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><?=$items['user']['name']?></span>
                        <span class="info-box-number"><?=$items['user']['count']?></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><?=$items['personnel']['name']?></span>
                        <span class="info-box-number"><?=$items['personnel']['count']?></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">93,139</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-red"><i class="fa fa-user-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">93,139</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>


        </div>
        









