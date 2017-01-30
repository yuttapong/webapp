<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\widgets\Typeahead;

?>

<!-- ////////////// column 1 ///////////-->


<?php

?>
<!-- /////////////// column search  //////////-->

<div class="box box-default">
    <div class="box-header with-border">
        <div class="box-tools pull-right">

        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

        <div class="row">
            <!-- ///////////// จำนวนยอดต่าง ๆ ////////////-->
            <div class="col-xs-12 col-sm-8 col-md-8">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">

                        <div class="info-box">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon bg-aqua"><i class="fa fa-address-book"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">ทั้งหมด</span>
                                <span class="info-box-number"><?= $count['approval']['countAll'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->


                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3">

                        <div class="info-box">
                            <!-- Apply any bg-* class to to the icong to color it -->
                            <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">เดือนนี้</span>
                                <span class="info-box-number"><?= $count['approval']['countThisMonth'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="info-box">
                            <!-- Apply any bg-* class to to the icong to color it -->
                            <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">วันนี้</span>
                                <span class="info-box-number"><?= $count['approval']['countToday'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                </div>


            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <h4>ค้นหาลูกค้า</h4>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">

                    </div>

                </div>
            </div>

        </div>
        <hr>

        <div class="row">
            <div class="col-xs-12"><h4>ประวัติการติดต่อกับลูกค้าล่าสุด</h4></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                echo  \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProviderApproval,
                    'id' => 'grid-appraval',
                    'itemView' => 'approval/approval',
                    'itemOptions' => ['class' => 'col-xs-12 col-sm-12'],
                    'layout' => "{items}\n{pager}",
                ]);
                ?>
            </div>
        </div>


    </div><!-- /.box-body -->
</div><!-- /.box -->
