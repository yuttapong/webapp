<?php
use kartik\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmAppManpower $model
 */

$this->title = @$model->position->name_th;
$this->params['breadcrumbs'][] = ['label' => 'ระบบรับสมัครงาน', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'ตำแหน่งงานที่เปิดรับสมัคร', 'url' => ['position/index']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::pageHeader($this->title);
?>

<div class="row">
    <!-- ชื่อบริษัท -->
    <div class="col-xs-10" align="center"><strong><?= $model->companyName ?></strong></div>
    <!-- เลขที่ -->
    <div class="col-xs-2">
        <div align="right"><strong><?= Html::badge($model->code) ?></strong></div>
    </div>
</div>

<div class="row">
    <!-- วันที่ -->
    <div class="col-xs-6 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'created_date') ?></div>
    <div class="col-xs-6 col-sm-10 col-md-10"><?= Yii::$app->formatter->asDate($model->created_at, 'medium') ?></div>
</div>
<div class="row">
    <!-- ที่อยู่ -->
    <div class="col-xs-6 col-sm-2 col-md-2"><?= Html::activeLabel($model->company, 'address_full') ?></div>
    <div class="col-xs-6 col-sm-10 col-md-10"><?= $model->company->address_full ?></div>
</div>

<div class="row">
    <!-- ตำแหน่ง -->
    <div class="col-xs-3 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'position_id') ?></div>
    <div class="col-xs-3 col-sm-4 col-md-4"><?= $model->positionName ?></div>
    <!-- เงินเดือนที่ต้องการ -->
    <div class="col-xs-3 col-sm-2 col-md-2" align=""><?= Html::activeLabel($model, 'salary') ?></div>
    <div class="col-xs-3 col-sm-4 col-md-4"><?= Yii::$app->formatter->asDecimal($model->salary) ?></div>
</div>

<div class="row">
    <!-- ผู้บังคับบัญชา -->
    <div class="col-xs-2 col-sm-2" align=""><?= Html::activeLabel($model, 'leader_user_id') ?></div>
    <div class="col-xs-4 col-sm-4"><?= $model->leaderName ?></div>
    <!-- วันที่ต้องการ -->
    <div class="col-xs-2 col-sm-2 col-md-2" align=""><?= Html::activeLabel($model, 'date_to') ?></div>
    <div class="col-xs-4 col-sm-4 col-md-4"><?= Yii::$app->formatter->asDate($model->date_to) ?></div>
</div>

<div class="row">
    <!-- จำนวนที่ต้องการ -->
    <div class="col-xs-2 col-sm-2" align=""><?= Html::activeLabel($model, 'qty') ?></div>
    <div class="col-xs-4 col-sm-4"><?= $model->qty ?></div>
    <!-- เหตุผลในการขอ -->
    <div class="col-xs-2 col-sm-2 col-md-2" align=""><?= Html::activeLabel($model, 'reason_request') ?></div>
    <div class="col-xs-4 col-sm-4 col-md-4"><?= $model->reasonRequestName ?>
        <?php
        if ($model->reason_request == 100) {
            echo '(' . $model->reason_request_text . ')';
        }
        ?>
    </div>
</div>

<br>

<!-- ///////////////////  คุณสมบัติผู้สมัคร ////////////////////////////////-->
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">คุณสมบัติผู้สมัคร</h3>
        </div>

        <div class="panel-body">
            <div class="panel-content">
                <?php
                if ($model->optionProperties)
                    echo '<ul>';
                foreach ($model->optionProperties as $prop) {
                    echo Html::tag('li', $prop->title);
                }
                echo '</ul>';
                ?>
            </div>
        </div>
    </div>
</div>



<!-- ///////////////////////////หน้าที่รับผิดชอบ//////////////////////////// -->
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">หน้าที่รับผิดชอบ</h3>
        </div>

        <div class="panel-body">
            <div class="panel-content">
                <?php
                if ($model->optionResponsibilities)
                    echo '<ul>';
                foreach ($model->optionResponsibilities as $res) {
                    echo Html::tag('li', $res->title);
                }
                echo '</ul>';
                ?>
            </div>
        </div>
    </div>
</div>




<!-- ///////////////////////////สวัสดิการ//////////////////////////// -->
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">สวัสดิการ</h3>
        </div>
        <div class="panel-body">
            <div class="panel-content">
                <?php
                if ($model->optionBenefits)
                    echo '<ul>';
                foreach ($model->optionBenefits as $ben) {
                    echo Html::tag('li', $ben->title);
                }
                echo '</ul>';
                ?>
            </div>
        </div>
    </div>
</div>

<?php
echo Html::a('สมัครงานตำแหน่งนี้ !',['resume/apply','position_id' =>$model->id],['class' => 'btn btn-success']);

