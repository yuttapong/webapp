<?php
/* @var $this yii\web\View */

$this->title = 'รายการชำระเงิน';
?>
<div class="row">


    <div class="col-md-12">


        <div class="table-responsive">


            <table id="mytable" class="table table-bordred table-striped">
                <thead>
                <th>Status</th>
                <th>วันที่</th>
                <th>โครงการ</th>
                <th>แปลงที่</th>
                <th>ประเภท</th>
                <th>งวดที่</th>
                <th>จำนวนเงิน</th>
                <th>First Name</th>
                <th>Last Name</th>

                <th>วันที่ทำรายการ</th>
                <th>ผู้ทำรายการ</th>
                <th>Edit</th>
                <th>Delete</th>
                </thead>
                <tbody>
                <?php
                $projectName = ['Bann Sirivalai', 'The modish', 'Four Seasons'];
                $feeType = ['ค่าจองบ้าน', 'ค่าทำสัญญา', 'ค่าผ่อนดาวน์','ค่าโอนกรรมสิทธิ์'];
                $statusBooking = [
                    '<span class="label label-success">รอชำระเงิน</span>',
                    '<span class="label label-default">ชำระเงินแล้ว</span>',
                    '<span class="label label-danger">ยกเลิกแล้ว</span>'
                ];
                for ($i = 1; $i < 10; $i++):
                    ?>
                    <tr>
                        <td><?= $statusBooking[rand(0, 2)] ?></td>
                        <td><?php
                            echo \common\siricenter\thaiformatter\ThaiDate::widget([
                                'timestamp' => time(),
                                'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_MEDIUM,
                            ]);
                            ?></td>
                        <td><?= ($projectName[rand(0, 2)]) ?></td>
                        <td><span class="badge"><?= rand(1, 100) ?></span></td>
                        <td><?=$feeType[rand(0,3)]?></td>
                        <td><?= rand(1, 10) ?></td>
                        <td><?=number_format(rand(2000,12000))?></td>
                        <td>ชื่อจริง</td>
                        <td>นามสกุล</td>
                        <td><?php
                            echo \common\siricenter\thaiformatter\ThaiDate::widget([
                                'timestamp' => time(),
                                'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_MEDIUM,
                            ]);
                            ?></td>
                        <td>ยุทธพงค์</td>
                        <td>
                            <p data-placement="top" data-toggle="tooltip" title="Edit">
                                <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal"
                                        data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button>
                            </p>
                        </td>
                        <td>
                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"
                                        data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button>
                            </p>
                        </td>
                    </tr>
                    <?php
                endfor;
                ?>
                </tbody>

            </table>


            <div class="clearfix"></div>


            <ul class="pagination">
                <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
            </ul>

        </div>

    </div>
</div>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control " type="text" placeholder="Mohsin">
                </div>
                <div class="form-group">

                    <input class="form-control " type="text" placeholder="Irshad">
                </div>
                <div class="form-group">
                    <textarea rows="2" class="form-control"
                              placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>


                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span
                        class="glyphicon glyphicon-ok-sign"></span> Update
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you
                    want to delete this Record?
                </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> No
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>