<?php
use yii\bootstrap\Html;

?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="box box-solid box-default">
            <div class="box-header with-border">
                <i class="fa fa-book"></i> โปรโมชั่นล่าสุด
                <div class="box-tools pull-right">
                    <?php
                    echo Html::a('<i class="fa fa-list"></i> ดูทั้งหมด...', ['promotion/index'], [
                        'class' => 'btn btn-default',
                    ])
                    ?>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="table-responsive">
                    <table id="table-promotion" class="table table-bordred table-striped">
                        <thead>
                        <th>Image</th>
                        <th>Title</th>
                        </thead>
                        <tbody>

                        <tr>
                            <td><img src="https://placeimg.com/100/80/any1" class="img img-thumbnail"></td>
                            <td>แอร์ Sumsung 22,000 BTU จำนวน 1 ตัว</td>
                            <td>22,900฿</td>
                        </tr>

                        <tr>
                            <td><img src="https://placeimg.com/100/80/any2" class="img img-thumbnail"></td>
                            <td>เงินคืน จอง+สัญญา</td>
                            <td>50,000฿</td>
                        </tr>


                        <tr>
                            <td><img src="https://placeimg.com/100/80/any3" class="img img-thumbnail"></td>
                            <td>ชุดครัว Built-In</td>
                            <td>300,000฿</td>
                        </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div> <!-- end box -->

    </div>

    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-green"><i class="fa fa-file-text-o"></i></span>
                    <div class="info-box-content">
                        <span
                            class="info-box-text"><?= Html::a('ใบจอง', ['booking/index'], ['title' => 'ใบจองใหม่']); ?></span>
                        <span class="info-box-number">2</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-text-o"></i></span>
                    <div class="info-box-content">
                        <span
                            class="info-box-text"><?= Html::a('สัญญาจะซื้อจะขาย', ['contract/index'], ['title' => 'ใบสัญญาใหม่']); ?></span>
                        <span class="info-box-number">12</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>
                    <div class="info-box-content">
                        <span
                            class="info-box-text"><?= Html::a('เอกสารยื่นกู้', ['loan/index'], ['title' => 'เอกสารยื่นกู้ใหม่']); ?></span>
                        <span class="info-box-number">2</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-text-o"></i></span>
                    <div class="info-box-content">
                        <span
                            class="info-box-text"> <?= Html::a('หนังสือโอน', ['transfer/index'], ['title' => 'หนังสือโอนใหม่']); ?></span>
                        <span class="info-box-number">2</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span
                            class="info-box-text"> <?= Html::a('ใกล้ครบกำหนดชำระเงิน', ['payment/index'], ['title' => 'ลูกหนี้ใกล้ครบกำหนดชำระเงิน']); ?></span>
                        <span class="info-box-number">2</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

        </div>
    </div>
</div>

</div>

